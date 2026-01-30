<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Seller;

class RegisterDashboardController extends Controller
{
    public function index()
    {
        // Pastikan hanya role 5 (Admin Register/SKPD)
        if (Auth::user()->role != 5) {
            abort(403);
        }

        $unverified = Seller::where('status', 1)->count();      // belum diverifikasi
        $approved   = Seller::where('status', 4)->count();      // disetujui
        $needFix    = Seller::where('status', 2)->count();      // sedang ditinjau / perlu perbaikan

        // Sebaran per subsektor (berdasarkan produk)
        $subsectorDist = DB::table('products')
            ->join('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id')
            ->join('sellers', 'sellers.id', '=', 'products.seller_id')
            ->select('setting_sub_categories.name as subsektor', DB::raw('COUNT(DISTINCT sellers.id) as total'))
            ->groupBy('setting_sub_categories.id', 'setting_sub_categories.name')
            ->orderBy('setting_sub_categories.name')
            ->get();

        // Sebaran per distrik/kampung (gunakan field city)
        $districtDist = Seller::select('city as distrik', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        return view('admin.register.dashboard', compact(
            'unverified',
            'approved',
            'needFix',
            'subsectorDist',
            'districtDist'
        ));
    }

    /** Halaman verifikasi pelapak (role 5) */
    public function verifyPage()
    {
        if (Auth::user()->role != 5) abort(403);
        return view('admin.register.verify');
    }

    public function verifyData()
    {
        if (Auth::user()->role != 5) abort(403);

        $query = Seller::whereIn('status', [1, 2]); // 1=belum, 2=ditinjau/perlu perbaikan

        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status_badge', function ($row) {
                $map = [
                    1 => ['BELUM', 'badge-warning'],
                    2 => ['DITINJAU', 'badge-info'],
                    3 => ['DITOLAK', 'badge-danger'],
                    4 => ['DISETUJUI', 'badge-success'],
                ];
                [$label, $class] = $map[$row->status] ?? ['-', 'badge-secondary'];
                return '<span class="badge '.$class.'">'.$label.'</span>';
            })
            ->addColumn('oap_badge', function ($row) {
                $label = $row->oap === 'yes' ? 'OAP' : 'Non OAP';
                $class = $row->oap === 'yes' ? 'badge-success' : 'badge-secondary';
                return '<span class="badge '.$class.'">'.$label.'</span>';
            })
            ->addColumn('dokumen', function ($row) {
                if ($row->profile_dokumen) {
                    $url = asset('storage/' . $row->profile_dokumen);
                    return '<a href="'.$url.'" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Dokumen</a>';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })
            ->addColumn('foto', function ($row) {
                $url = $row->profile_picture ? asset('storage/'.$row->profile_picture) : asset('assets/image/profile/profile.jpeg');
                return '<img src="'.$url.'" alt="foto" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">';
            })
            ->addColumn('binaan', function ($row) {
                $checked = $row->binaan_skpd ? 'checked' : '';
                return '<div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input toggle-binaan" id="binaan'.$row->id.'" data-id="'.$row->id.'" '.$checked.'>
                            <label class="custom-control-label" for="binaan'.$row->id.'"></label>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group">
                            <button class="btn btn-success btn-sm btn-approve" data-id="'.$row->id.'"><i class="fas fa-check"></i></button>
                            <button class="btn btn-warning btn-sm btn-revise" data-id="'.$row->id.'"><i class="fas fa-undo"></i></button>
                            <button class="btn btn-danger btn-sm btn-reject" data-id="'.$row->id.'"><i class="fas fa-times"></i></button>
                        </div>';
            })
            ->rawColumns(['status_badge','oap_badge','dokumen','foto','binaan','action'])
            ->make(true);
    }

    public function verifyAction(\Illuminate\Http\Request $request, $id)
    {
        if (Auth::user()->role != 5) abort(403);

        $seller = Seller::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:approve,reject,revise',
            'note'   => 'nullable|string'
        ]);

        switch ($validated['action']) {
            case 'approve':
                $seller->status = 4; // DISETUJUI
                $seller->note = null;
                break;
            case 'reject':
                $seller->status = 3; // DITOLAK
                $seller->note = $validated['note'] ?? 'Ditolak';
                break;
            case 'revise':
                $seller->status = 2; // PERLU_PERBAIKAN / DITINJAU
                $seller->note = $validated['note'] ?? 'Perlu perbaikan dokumen';
                break;
        }

        $seller->save();

        return response()->json(['status' => 200, 'text' => 'Status diperbarui']);
    }

    public function toggleBinaan(\Illuminate\Http\Request $request, $id)
    {
        if (Auth::user()->role != 5) abort(403);
        $seller = Seller::findOrFail($id);
        $seller->binaan_skpd = $request->get('binaan') ? 1 : 0;
        $seller->save();
        return response()->json(['status' => 200, 'text' => 'Label binaan diperbarui']);
    }

    /** Pemetaan Pelapak Ekraf: list + export (role 5) */
    public function mapPage()
    {
        if (Auth::user()->role != 5) abort(403);
        $subsectors = DB::table('setting_sub_categories')->pluck('name', 'id');
        $cities = Seller::select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        return view('admin.register.map', compact('subsectors', 'cities'));
    }

    public function mapData(\Illuminate\Http\Request $request)
    {
        if (Auth::user()->role != 5) abort(403);

        $subsector = $request->get('subsector');
        $city = $request->get('city');
        $oap = $request->get('oap');

        $query = Seller::query()
            ->leftJoin('products', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id')
            ->select(
                'sellers.id',
                'sellers.name',
                'sellers.email',
                'sellers.phone',
                'sellers.city',
                'sellers.province',
                'sellers.oap',
                DB::raw('GROUP_CONCAT(DISTINCT setting_sub_categories.name SEPARATOR ", ") as subsectors')
            )
            ->groupBy('sellers.id','sellers.name','sellers.email','sellers.phone','sellers.city','sellers.province','sellers.oap');

        if ($subsector) $query->where('setting_sub_categories.id', $subsector);
        if ($city) $query->where('sellers.city', $city);
        if ($oap !== null && $oap !== '') $query->where('sellers.oap', $oap);

        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('oap_badge', function ($row) {
                $label = $row->oap === 'yes' ? 'OAP' : 'Non OAP';
                $class = $row->oap === 'yes' ? 'badge-success' : 'badge-secondary';
                return '<span class="badge '.$class.'">'.$label.'</span>';
            })
            ->rawColumns(['oap_badge'])
            ->make(true);
    }

    public function mapExport(\Illuminate\Http\Request $request)
    {
        if (Auth::user()->role != 5) abort(403);

        $subsector = $request->get('subsector');
        $city = $request->get('city');
        $oap = $request->get('oap');

        $query = Seller::query()
            ->leftJoin('products', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id')
            ->select(
                'sellers.name',
                'sellers.email',
                'sellers.phone',
                'sellers.city',
                'sellers.province',
                'sellers.oap',
                DB::raw('GROUP_CONCAT(DISTINCT setting_sub_categories.name SEPARATOR ", ") as subsectors')
            )
            ->groupBy('sellers.id','sellers.name','sellers.email','sellers.phone','sellers.city','sellers.province','sellers.oap');

        if ($subsector) $query->where('setting_sub_categories.id', $subsector);
        if ($city) $query->where('sellers.city', $city);
        if ($oap !== null && $oap !== '') $query->where('sellers.oap', $oap);

        $rows = $query->get();

        $filename = 'pemetaan_pelapak_'.now()->format('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Email', 'Telepon', 'Kota', 'Provinsi', 'OAP', 'Subsektor']);
            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->name,
                    $r->email,
                    $r->phone,
                    $r->city,
                    $r->province,
                    $r->oap,
                    $r->subsectors
                ]);
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
