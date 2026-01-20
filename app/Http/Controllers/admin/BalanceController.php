<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SellerBalance;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BalanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $total_balance = 0;
            $balance_in = 0;
            $balance_out = 0;
            
            // Query utama
            $query = SellerBalance::orderBy('created_at', 'desc');
            
            // Filter berdasarkan rentang tanggal
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $start_date = $request->start_date . ' 00:00:00';
                $end_date = $request->end_date . ' 23:59:59';
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            
            // Filter berdasarkan tipe transaksi (in / out)
            if (!empty($request->type)) {
                $query->where('type', $request->type);
            }

            if(!empty($request->seller_id)){
                $query->where('seller_id', $request->seller_id);
            }
            
            // Ambil data transaksi
            $data = $query->get();
            
            // Hitung balance_in & balance_out
            $balance_in = $data->where('type', 'in')->sum('amount');
            $balance_out = $data->where('type', 'out')->sum('amount');
            
            // Hitung total balance (in - out)
            $total_balance = $balance_in - $balance_out;
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y H:i:s');
                })
                ->addColumn('amount', function ($row) {
                    return 'Rp ' . number_format($row->amount, 0, ',', '.');
                })
                ->addColumn('transaction_code', function ($row) {
                    return $row->transaction ? $row->transaction->code : ($row->withdraw ? $row->withdraw->code : '-');
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-info btn-sm" href="' . route('seller.balance.show', $data->id) . '">
                                <i class="fa fa-eye"></i>
                            </a>';
                })
                ->with([
                    'balance_in' => 'Rp ' . number_format($balance_in, 0, ',', '.'),
                    'balance_out' => 'Rp ' . number_format($balance_out, 0, ',', '.'),
                    'total_balance' => 'Rp ' . number_format($total_balance, 0, ',', '.')
                ])
                ->rawColumns(['updated_at', 'amount', 'transaction_code', 'action'])
                ->make(true);
        }
        return view('admin.balance.index');
    }
}
