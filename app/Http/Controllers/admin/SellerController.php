<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Log;

class SellerController extends Controller
{   

    public function __construct()
    {
        // Log::info(Auth::user());
    }

    public function index(Request $request)
    {

        $admin_priviledge_id = Auth::user()->admin_priviledge;
		if($admin_priviledge_id==1) return redirect('/admin/setting/contact-admin');
        
        if ($request->ajax()) {
            $data = Seller::where('status', 4);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('location', content: function ($row) {
                    return '
                        <span>' . $row->address . ', Kota ' . $row->city . ', Provinsi ' . $row->province . ', ' . $row->country . ' (' . $row->zip . ')</span>
                    ';
                })
                ->addColumn('oap', content: function ($row) {
                    $label = $row->oap === 'yes' ? 'OAP' : 'Non OAP';
                    $class = $row->oap === 'yes' ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge ' . $class . '">' . $label . '</span>';
                })
                ->addColumn('action', content: function ($row) {
                    return '
                    <div class="btn-group" role="group">
                        <a class="btn btn-sm btn-warning" href="' . route('admin.sellers.edit', [$row->id]) . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-info btn-message" data-phone="' . $row->phone . '" data-name="' . e($row->name) . '">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary btn-disable" data-id="' . $row->id . '">
                            <i class="fas fa-ban"></i>
                        </button>
                        <button type="button" alt="Reset Password" class="btn-reset-password btn btn-sm btn-primary" data-id="' . $row->id . '">
                            <i class="fas fa-key"></i> 
                        </button>
                    </div>
                    ';
                })
                ->rawColumns(['location', 'oap', 'action'])
                ->make(true);
        }
        return view('admin.seller.index');
    }
    

    public function edit(string $id)
    {
        $seller = Seller::findOrFail($id);
        return view('admin.seller.edit', compact('seller'));
    }

    public function update(Request $request, string $id)
    {
        $seller = Seller::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:10',
            'tax_number' => 'nullable|string|max:255',
            'business_number' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
            'note' => 'nullable|string',
            'oap' => 'nullable|in:yes,no'
        ]);

        $seller->update($validated);

        return redirect()->route('admin.sellers')->with('success', 'Seller updated');
    }

    public function disable(string $id)
    {
        $seller = Seller::findOrFail($id);
        $seller->status = 0;
        $seller->save();

        return response()->json(['status' => 200, 'text' => 'Seller dinonaktifkan']);
    }

    public function getDisabled(Request $request)
    {
        $data = Seller::where('status', 0)->get();
        $index = 1;
        return DataTables::of(source: $data)
            ->addColumn('no', function () use (&$index) {
                return $index++;
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-success btn-enable" data-id="' . $row->id . '"><i class="fas fa-toggle-on"></i></button>';
            })
            ->make(true);
    }

    public function disabledPage()
    {
        return view('admin.seller.disabled');
    }

    public function enable(string $id)
    {
        $seller = Seller::findOrFail($id);
        $seller->status = 4;
        $seller->save();

        return response()->json(['status' => 200, 'text' => 'Seller diaktifkan kembali']);
    }

    /** Laporan pelapak per subsektor & kota (proxy distrik/kampung) */
    public function reportSubsector(Request $request)
    {
        $subsectorId = $request->get('subsector');
        $cityFilter  = $request->get('city');
        $oapFilter   = $request->get('oap');

        $rows = DB::table('sellers')
            ->leftJoin('products', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id')
            ->select(
                DB::raw('COALESCE(setting_sub_categories.name, "Tanpa Subsektor") as subsector'),
                DB::raw('COALESCE(sellers.city, "Tanpa Kota") as city'),
                DB::raw('COUNT(DISTINCT sellers.id) as total_sellers')
            )
            ->groupBy('subsector', 'city');

        if ($subsectorId) $rows->where('setting_sub_categories.id', $subsectorId);
        if ($cityFilter) $rows->where('sellers.city', $cityFilter);
        if ($oapFilter) $rows->where('sellers.oap', $oapFilter);

        $rows = $rows->orderBy('subsector')->orderBy('city')->get();

        $perSubsector = DB::table('sellers')
            ->leftJoin('products', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id')
            ->select(
                DB::raw('COALESCE(setting_sub_categories.name, "Tanpa Subsektor") as subsector'),
                DB::raw('COUNT(DISTINCT sellers.id) as total_sellers')
            );
        if ($subsectorId) $perSubsector->where('setting_sub_categories.id', $subsectorId);
        if ($cityFilter) $perSubsector->where('sellers.city', $cityFilter);
        if ($oapFilter) $perSubsector->where('sellers.oap', $oapFilter);

        $perSubsector = $perSubsector->groupBy('subsector')->orderBy('subsector')->get();

        $subsectors = DB::table('setting_sub_categories')->pluck('name', 'id');
        $cities = Seller::select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        return view('admin.seller.report_subsector', compact('rows','perSubsector','subsectors','cities','subsectorId','cityFilter','oapFilter'));

        return view('admin.seller.report_subsector', compact('rows','perSubsector'));
    }

    /** Laporan pelapak OAP vs Non-OAP */
    public function reportOap(Request $request)
    {
        $subsectorId = $request->get('subsector');
        $cityFilter  = $request->get('city');

        $base = DB::table('sellers')
            ->leftJoin('products', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('setting_sub_categories', 'setting_sub_categories.id', '=', 'products.sub_category_id');

        if ($subsectorId) $base->where('setting_sub_categories.id', $subsectorId);
        if ($cityFilter) $base->where('sellers.city', $cityFilter);

        // Gunakan DISTINCT agar join ke products tidak menggandakan hitungan seller
        $summary = (clone $base)
            ->select('sellers.oap', DB::raw('COUNT(DISTINCT sellers.id) as total'))
            ->groupBy('sellers.oap')
            ->get();

        $perCity = (clone $base)
            ->select(
                DB::raw('COALESCE(sellers.city, "Tanpa Kota") as city'),
                DB::raw('COUNT(DISTINCT CASE WHEN sellers.oap="yes" THEN sellers.id END) as oap_yes'),
                DB::raw('COUNT(DISTINCT CASE WHEN sellers.oap="no" THEN sellers.id END) as oap_no'),
                DB::raw('COUNT(DISTINCT sellers.id) as total')
            )
            ->groupBy('sellers.city')
            ->orderBy('city')
            ->get();

        $detail = (clone $base)
            ->select('sellers.name','sellers.email','sellers.phone','sellers.city','sellers.oap')
            ->groupBy('sellers.id','sellers.name','sellers.email','sellers.phone','sellers.city','sellers.oap')
            ->orderBy('sellers.name')
            ->get();

        $subsectors = DB::table('setting_sub_categories')->pluck('name','id');
        $cities = Seller::select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        return view('admin.seller.report_oap', compact('summary','perCity','detail','subsectors','cities','subsectorId','cityFilter'));
    }

    /** Pandangan Sistem: Data Pelapak & Toko */
    public function masterView()
    {
        $cities = Seller::select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $subsectors = DB::table('setting_sub_categories')->pluck('name', 'id');
        return view('admin.seller.master', compact('cities', 'subsectors'));
    }

    public function masterData(Request $request)
    {
        $oap = $request->get('oap');
        $city = $request->get('city');
        $subsector = $request->get('subsector');

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
                'sellers.profile_dokumen',
                DB::raw('GROUP_CONCAT(DISTINCT setting_sub_categories.name SEPARATOR ", ") as subsectors'),
                DB::raw('COUNT(DISTINCT products.id) as total_products')
            )
            ->groupBy('sellers.id','sellers.name','sellers.email','sellers.phone','sellers.city','sellers.province','sellers.oap','sellers.profile_dokumen');

        if ($oap) {
            $query->where('sellers.oap', $oap);
        }
        if ($city) {
            $query->where('sellers.city', $city);
        }
        if ($subsector) {
            $query->where('setting_sub_categories.id', $subsector);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('oap_badge', function ($row) {
                $label = $row->oap === 'yes' ? 'OAP' : 'Non OAP';
                $class = $row->oap === 'yes' ? 'badge-success' : 'badge-secondary';
                return '<span class="badge '.$class.'">'.$label.'</span>';
            })
            ->addColumn('document', function ($row) {
                if ($row->profile_dokumen) {
                    $url = asset('storage/' . $row->profile_dokumen);
                    return '<a href="'.$url.'" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Lihat</a>';
                }
                return '<span class="text-muted">Tidak ada</span>';
            })
            ->addColumn('action', function ($row) {
                $blockBtn = '<button class="btn btn-sm btn-secondary btn-block-seller" data-id="'.$row->id.'"><i class="fas fa-ban"></i></button>';
                $detailBtn = '<button class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'" data-name="'.e($row->name).'" data-email="'.e($row->email).'" data-phone="'.e($row->phone).'" data-city="'.e($row->city).'" data-province="'.e($row->province).'" data-oap="'.$row->oap.'" data-subsectors="'.e($row->subsectors).'" data-products="'.$row->total_products.'" data-document="'.e($row->profile_dokumen).'"><i class="fas fa-eye"></i></button>';
                return '<div class="btn-group" role="group">'.$detailBtn.$blockBtn.'</div>';
            })
            ->rawColumns(['oap_badge','document','action'])
            ->make(true);
    }

    public function forceBlock($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->status = 0; // nonaktif / blokir
        $seller->save();
        return response()->json(['status'=>200,'text'=>'Pelapak diblokir/nonaktif']);
    }

    public function forceUnblock($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->status = 4; // aktif
        $seller->save();
        return response()->json(['status'=>200,'text'=>'Pelapak diaktifkan kembali']);
    }

    public function performance()
    {
        $sellers = Seller::leftJoin('transactions', 'transactions.seller_id', '=', 'sellers.id')
            ->leftJoin('transaction_products', 'transaction_products.transaction_id', '=', 'transactions.id')
            ->select(
                'sellers.id',
                'sellers.name',
                'sellers.email',
                'sellers.phone',
                DB::raw('SUM(CASE WHEN transactions.status = 7 THEN 1 ELSE 0 END) as selesai'),
                DB::raw('SUM(CASE WHEN transactions.status IN (8,9) THEN 1 ELSE 0 END) as batal'),
                DB::raw('SUM(CASE WHEN transaction_products.complain IS NOT NULL OR transaction_products.complain_status = "eopn" THEN 1 ELSE 0 END) as komplain')
            )
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email', 'sellers.phone')
            ->get()
            ->map(function ($row) {
                $total = ($row->selesai ?? 0) + ($row->batal ?? 0);
                $ratio = $total > 0 ? round(($row->selesai / $total) * 100, 1) : 0;
                $row->ratio = $ratio;
                $row->rating = '-'; // kolom rating tidak tersedia di data saat ini
                return $row;
            });

        return view('admin.seller.performance', compact('sellers'));
    }


    public function confirmationSeller(Request $request){
        if ($request->ajax()) {
            $data = Seller::where('status',1);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('oap', content: function ($row) {
                    $label = $row->oap === 'yes' ? 'OAP' : 'Non OAP';
                    $class = $row->oap === 'yes' ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge ' . $class . '">' . $label . '</span>';
                })
                ->addColumn('document', content: function ($row) {
                    if ($row->profile_dokumen) {
                        $url = asset('storage/' . $row->profile_dokumen);
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Lihat</a>';
                    }
                    return '<span class="text-muted">Tidak ada</span>';
                })
                ->addColumn('location',content: function ($row){
                    $el = '
                        <span>' . $row->address . ',Kota '. $row->city . ',Provinsi '.$row->province.','.$row->country.'.('.$row->zip.')</span>
                    ';
                    return $el;
                })
                ->addColumn('action', content: function ($row) {
                    
                    return '
                        <div class="btn-group" role="group">
                            <a class="btn btn-sm btn-warning" href="' . route('admin.sellers.edit', [$row->id]) . '">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn-reject btn btn-sm btn-danger" data-id="' . $row->id . '">
                                <i class="fas fa-times"></i>
                            </button>
                            <button class="btn-accept btn btn-sm btn-success" data-id="' . $row->id . '">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['location','oap','document','action'])
                ->make(true);
        }
        return view('admin.seller.confirmation');
    }

    public function failedSeller(Request $request){
        if ($request->ajax()) {
            $data = Seller::where('status',3);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('location',content: function ($row){
                    $el = '
                        <span>' . $row->address . ',Kota '. $row->city . ',Provinsi '.$row->province.','.$row->country.'.('.$row->zip.')</span>
                    ';
                    return $el;
                })
                ->rawColumns(['location'])
                ->make(true);
        }
        return view('admin.seller.failed');
    }

    public function activeSellers()
    {
        $since = Carbon::now()->subDays(30);

        $sellers = Seller::select(
                'sellers.id',
                'sellers.name',
                'sellers.email',
                'sellers.phone',
                DB::raw('COUNT(DISTINCT transactions.id) as total_transactions'),
                DB::raw('MAX(transactions.created_at) as last_transaction_at')
            )
            ->join('transactions', 'transactions.seller_id', '=', 'sellers.id')
            ->where('transactions.created_at', '>=', $since)
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email', 'sellers.phone')
            ->orderByDesc('last_transaction_at')
            ->get();

        return view('admin.seller.active', compact('sellers', 'since'));
    }

    public function problematicSellers()
    {
        $cancelExpr = "COUNT(DISTINCT CASE WHEN transactions.status IN (8,9) THEN transactions.id END)";
        $complainExpr = "COUNT(DISTINCT CASE WHEN transaction_products.complain IS NOT NULL OR transaction_products.complain_status = 'eopn' THEN transaction_products.id END)";

        $sellers = Seller::select(
                'sellers.id',
                'sellers.name',
                'sellers.email',
                'sellers.phone',
                DB::raw("$complainExpr AS complaints"),
                DB::raw("$cancelExpr AS cancelled_orders"),
                DB::raw("$complainExpr + $cancelExpr AS total_issues"),
                DB::raw('MAX(GREATEST(IFNULL(transactions.created_at,0), IFNULL(transaction_products.created_at,0))) AS last_issue_at')
            )
            ->leftJoin('transactions', 'transactions.seller_id', '=', 'sellers.id')
            ->leftJoin('transaction_products', 'transaction_products.transaction_id', '=', 'transactions.id')
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email', 'sellers.phone')
            ->havingRaw("$complainExpr + $cancelExpr > 0")
            ->orderByDesc('total_issues')
            ->get();

        return view('admin.seller.problematic', compact('sellers'));
    }

    public function acceptSeller(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);

                $seller->update(['status' => 4]);

                DB::commit();
                return response()->json(['status' => 200, 'text' => 'Seller Diterima']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            }
           
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
     
    }

    public function rejectSeller(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);
                $seller->status = 3;
                if($request->note){
                    $seller->note = $request->note;
                }
                $seller->save();

                

                DB::commit();
    
                return response()->json(['status' => 200, 'text' => 'Seller Ditolak']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            } 
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
      
    }

    public function resetPassword(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);
                $password = $request->password;
                if ($seller->user) {
                    $seller->user->password = Hash::make($password);
                    $seller->user->save(); // Harus save ke model User, bukan Seller
                }
                
                
                DB::commit();

                //send email
                Mail::to($seller->email)->send(new ResetPasswordMail($password , $seller->name));

                // $redirect_url = 'https://api.whatsapp.com/send?phone=62'.$seller->phone.'&text=' . urlencode(
                //     "Halo, {$seller->name}.\n\n".
                //     "Permintaan reset password Anda telah disetujui. Berikut adalah password baru Anda:\n\n".
                //     "*{$password}*\n\n".
                //     "Silakan segera mengganti password ini demi keamanan akun Anda.\n\n".
                //     "Terima kasih.\nSalam,\nAdmin Olebsai"
                // );
                return response()->json(['status' => 200, 'text' => 'Password Berhasil Direset']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }


    public function getSeller(Request $request){
        $data = Seller::where('status', 4)->get();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di ambil', 'data' => $data]);
    }
       
}
