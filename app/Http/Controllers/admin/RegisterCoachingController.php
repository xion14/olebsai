<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Seller;

class RegisterCoachingController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 5) abort(403);
        $sellers = Seller::orderBy('name')->get(['id','name']);
        return view('admin.register.coaching', compact('sellers'));
    }

    public function data()
    {
        if (Auth::user()->role != 5) abort(403);

        $query = DB::table('seller_coachings as sc')
            ->join('sellers as s', 's.id', '=', 'sc.seller_id')
            ->select(
                'sc.id',
                'sc.title',
                'sc.type',
                'sc.description',
                'sc.coaching_date',
                'sc.attachment',
                's.name as seller_name'
            )
            ->orderByDesc('sc.coaching_date');

        return \DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('type_label', function ($row) {
                $map = [
                    'pelatihan' => 'Pelatihan',
                    'bantuan' => 'Bantuan Alat/Dana',
                    'pendampingan_kur' => 'Pendampingan KUR',
                    'lainnya' => 'Lainnya'
                ];
                return $map[$row->type] ?? $row->type;
            })
            ->addColumn('attachment_link', function ($row) {
                if ($row->attachment) {
                    $url = asset('storage/'.$row->attachment);
                    return '<a href="'.$url.'" target="_blank" class="btn btn-sm btn-info">Lampiran</a>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->rawColumns(['attachment_link'])
            ->make(true);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role != 5) abort(403);

        $validated = $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'type' => 'required|in:pelatihan,bantuan,pendampingan_kur,lainnya',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coaching_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('coaching', 'public');
        }

        DB::table('seller_coachings')->insert([
            'seller_id' => $validated['seller_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'coaching_date' => $validated['coaching_date'] ?? null,
            'attachment' => $path,
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'text' => 'Catatan pembinaan ditambahkan']);
    }
}

