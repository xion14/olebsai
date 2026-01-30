<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ConsumerReviewController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 7) abort(403);
        $subsectors = DB::table('setting_sub_categories')->pluck('name','id');
        return view('admin.consumer.reviews', compact('subsectors'));
    }

    public function data(Request $request)
    {
        if (Auth::user()->role != 7) abort(403);

        $subsector = $request->get('subsector');

        $hasFlag = Schema::hasColumn('transaction_products', 'review_flagged');
        $hasFlagNote = Schema::hasColumn('transaction_products', 'review_flag_note');

        $q = DB::table('transaction_products as tp')
            ->join('transactions as t', 't.id', '=', 'tp.transaction_id')
            ->join('products as p', 'p.id', '=', 'tp.product_id')
            ->leftJoin('setting_sub_categories as sc', 'sc.id', '=', 'p.sub_category_id')
            ->leftJoin('sellers as s', 's.id', '=', 't.seller_id')
            ->leftJoin('customers as c', 'c.id', '=', 't.customer_id')
            ->whereNotNull('tp.review')
            ->selectRaw('tp.id, t.code as order_code, tp.review, tp.reviewed_at, p.name as product_name, sc.name as subsector, s.name as seller_name, c.name as customer_name');

        if ($hasFlag) {
            $q->addSelect('tp.review_flagged');
        } else {
            $q->addSelect(DB::raw('0 as review_flagged'));
        }
        if ($hasFlagNote) {
            $q->addSelect('tp.review_flag_note');
        } else {
            $q->addSelect(DB::raw('NULL as review_flag_note'));
        }

        if ($subsector) $q->where('sc.id', $subsector);

        return \DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('flagged', function($row){
                return $row->review_flagged ? '<span class="badge badge-danger">Ditandai</span>' : '<span class="text-muted">-</span>';
            })
            ->addColumn('action', function($row){
                $data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<button class="btn btn-sm btn-primary btn-detail" data-row="'.$data.'"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['flagged','action'])
            ->make(true);
    }

    public function flag(Request $request, $id)
    {
        if (Auth::user()->role != 7) abort(403);
        if (!Schema::hasColumn('transaction_products', 'review_flagged')) {
            return response()->json(['status'=>400,'text'=>'Kolom flag belum tersedia; jalankan update DB'], 400);
        }

        $validated = $request->validate([
            'flagged' => 'required|boolean',
            'note' => 'nullable|string'
        ]);

        DB::table('transaction_products')
            ->where('id', $id)
            ->update([
                'review_flagged' => $validated['flagged'],
                'review_flag_note' => $validated['note'] ?? null,
                'updated_at' => now()
            ]);

        return response()->json(['status'=>200,'text'=>'Review diperbarui']);
    }
}

