<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    /** Pusat Komplain (Master) */
    public function index()
    {
        $statuses = [
            'eopn'  => 'Terbuka',
            'close' => 'Ditutup',
        ];
        $tags = ['fraud' => 'Fraud', 'pelanggaran' => 'Pelanggaran Berat', 'sindikat' => 'Sindikat'];
        return view('admin.complaint.master', compact('statuses', 'tags'));
    }

    public function data(Request $request)
    {
        $status = $request->get('status');
        $tag    = $request->get('tag');

        $query = DB::table('transaction_products as tp')
            ->join('transactions as t', 't.id', '=', 'tp.transaction_id')
            ->join('products as p', 'p.id', '=', 'tp.product_id')
            ->join('sellers as s', 's.id', '=', 't.seller_id')
            ->leftJoin('customers as c', 'c.id', '=', 't.customer_id')
            ->select(
                'tp.id',
                'tp.complain',
                'tp.complain_status',
                'tp.complain_note',
                'tp.complained_at',
                't.code as transaction_code',
                'p.name as product_name',
                's.name as seller_name',
                'c.name as customer_name'
            )
            ->whereNotNull('tp.complain');

        if ($status) {
            $query->where('tp.complain_status', $status);
        }

        if ($tag) {
            $query->where('tp.complain_note', 'like', 'TAG[' . $tag . ']%');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status_badge', function ($row) {
                $map = ['eopn' => ['Terbuka', 'badge-warning'], 'close' => ['Ditutup', 'badge-success']];
                [$label, $class] = $map[$row->complain_status] ?? ['-', 'badge-secondary'];
                return '<span class="badge ' . $class . '">' . $label . '</span>';
            })
            ->addColumn('tag', function ($row) {
                $tag = $this->extractTag($row->complain_note);
                return $tag ? ucfirst($tag) : '-';
            })
            ->addColumn('complained_at_fmt', function ($row) {
                return $row->complained_at ? Carbon::parse($row->complained_at)->format('d M Y H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group">'
                    . '<button class="btn btn-info btn-sm btn-detail" data-id="' . $row->id . '" '
                    . 'data-code="' . e($row->transaction_code) . '" '
                    . 'data-product="' . e($row->product_name) . '" '
                    . 'data-seller="' . e($row->seller_name) . '" '
                    . 'data-customer="' . e($row->customer_name) . '" '
                    . 'data-complain="' . e($row->complain) . '" '
                    . 'data-status="' . e($row->complain_status) . '" '
                    . 'data-tag="' . e($this->extractTag($row->complain_note)) . '" '
                    . 'data-note="' . e($this->stripTag($row->complain_note)) . '"><i class="fas fa-eye"></i></button>'
                    . '</div>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function override(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:eopn,close',
            'tag'    => 'nullable|in:fraud,pelanggaran,sindikat',
            'note'   => 'nullable|string'
        ]);

        $record = DB::table('transaction_products')->where('id', $id)->first();
        if (!$record) {
            return response()->json(['status' => 404, 'text' => 'Komplain tidak ditemukan'], 404);
        }

        $note = $validated['note'] ?? '';
        if (!empty($validated['tag'])) {
            $note = 'TAG[' . $validated['tag'] . '] ' . $note;
        }

        DB::table('transaction_products')
            ->where('id', $id)
            ->update([
                'complain_status' => $validated['status'],
                'complain_note'   => $note,
                'updated_at'      => now()
            ]);

        return response()->json(['status' => 200, 'text' => 'Komplain diperbarui']);
    }

    private function extractTag($note)
    {
        if (!$note) return null;
        if (preg_match('/TAG\\[(.*?)\\]/', $note, $m)) {
            return $m[1];
        }
        return null;
    }

    private function stripTag($note)
    {
        if (!$note) return '';
        return trim(preg_replace('/TAG\\[.*?\\]/', '', $note));
    }
}

