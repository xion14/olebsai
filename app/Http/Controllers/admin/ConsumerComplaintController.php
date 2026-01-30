<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ConsumerComplaintController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 7) abort(403);
        $subsectors = DB::table('setting_sub_categories')->pluck('name','id');
        return view('admin.consumer.complaints', compact('subsectors'));
    }

    public function data(Request $request)
    {
        if (Auth::user()->role != 7) abort(403);

        $status = $request->get('status');
        $subsector = $request->get('subsector');

        $hasDecision = Schema::hasColumn('transaction_products', 'complain_final_decision');
        $hasEscalated = Schema::hasColumn('transaction_products', 'complain_escalated');

        $q = DB::table('transaction_products as tp')
            ->join('transactions as t', 't.id', '=', 'tp.transaction_id')
            ->join('products as p', 'p.id', '=', 'tp.product_id')
            ->leftJoin('setting_sub_categories as sc', 'sc.id', '=', 'p.sub_category_id')
            ->leftJoin('sellers as s', 's.id', '=', 't.seller_id')
            ->leftJoin('customers as c', 'c.id', '=', 't.customer_id')
            ->selectRaw('tp.id, t.code as order_code, tp.complain, tp.complain_status, tp.complain_note, tp.complained_at, p.name as product_name, sc.name as subsector, s.name as seller_name, s.phone as seller_phone, c.name as customer_name')
            ->whereNotNull('tp.complain');

        if ($hasDecision) {
            $q->addSelect('tp.complain_final_decision');
        } else {
            $q->addSelect(DB::raw('NULL as complain_final_decision'));
        }
        if ($hasEscalated) {
            $q->addSelect('tp.complain_escalated');
        } else {
            $q->addSelect(DB::raw('0 as complain_escalated'));
        }

        if ($status) $q->where('tp.complain_status', $status);
        if ($subsector) $q->where('sc.id', $subsector);

        return \DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('status_badge', function($row){
                $map = ['eopn' => ['Terbuka','badge-warning'], 'close' => ['Selesai','badge-success']];
                [$label,$cls] = $map[$row->complain_status] ?? ['-', 'badge-secondary'];
                return '<span class="badge '.$cls.'">'.$label.'</span>';
            })
            ->addColumn('escalated', function($row){
                return $row->complain_escalated ? '<span class="badge badge-danger">Eskalasi</span>' : '<span class="text-muted">-</span>';
            })
            ->addColumn('clean_note', function($row){
                return trim(preg_replace('/TAG\\[.*?\\]/', '', $row->complain_note ?? '')) ?: '-';
            })
            ->addColumn('action', function($row){
                $data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return '<button class="btn btn-sm btn-primary btn-detail" data-row="'.$data.'"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['status_badge','escalated','action'])
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role != 7) abort(403);

        $validated = $request->validate([
            'complain_status' => 'required|in:eopn,close',
            'complain_final_decision' => 'nullable|string',
            'complain_note' => 'nullable|string',
            'escalated' => 'nullable|boolean'
        ]);

        $data = [
            'complain_status' => $validated['complain_status'],
            'complain_note' => $validated['complain_note'] ?? null,
            'updated_at' => now()
        ];
        if (Schema::hasColumn('transaction_products', 'complain_final_decision')) {
            $data['complain_final_decision'] = $validated['complain_final_decision'] ?? null;
        }
        if (Schema::hasColumn('transaction_products', 'complain_escalated')) {
            $data['complain_escalated'] = $request->boolean('escalated');
        }

        DB::table('transaction_products')->where('id', $id)->update($data);

        return response()->json(['status' => 200, 'text' => 'Komplain diperbarui']);
    }
}
