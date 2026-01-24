<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\SellerBalance;

class DashboardController extends Controller
{
    public function index()
    {
        $seller_id = Seller::where('user_id',Auth::id())->first()->id;
        

        return view('seller.dashboard.index',compact('seller_id'));
    }
    

    public function getTransactionStatistics(Request $request) {
        $month = $request->month;
        $year = $request->year;
        $seller = Seller::where('user_id', Auth::user()->id)->first();

        $data = [
            'total_waiting_seller' => Transaction::where('status', 1)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_admin' => Transaction::where('status', 2)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_payment' => Transaction::where('status', 3)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_packing' => Transaction::where('status', 4)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_delivery' => Transaction::where('status', 5)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_on_delivery' => Transaction::where('status', 6)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_success' => Transaction::where('status', 7)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_cancel' => Transaction::where('status', 8)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_expired' => Transaction::where('status', 9)
                ->where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_all' => Transaction::where('seller_id', $seller->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Data Transaction'
        ]);
    }

    public function getChartDataBalance(Request $request)
    {
        $now = Carbon::now()->startOfMonth();
        $startDate = $now->copy()->subMonths(5); // 6 bulan ke belakang (termasuk bulan ini)
        $seller = Seller::where('user_id', Auth::user()->id)->first();

        // Step 1: generate 6 bulan terakhir
        $months = collect();
        for ($i = 0; $i < 6; $i++) {
            $monthDate = $startDate->copy()->addMonths($i);
            $months->push([
                'month_key' => $monthDate->format('Y-m'),
                'month' => $monthDate->format('F Y'),
                'balance' => 0
            ]);
        }

        // Step 2: ambil data balance dari DB
        $balances = SellerBalance::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_key"),
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"),
                DB::raw("SUM(amount) as balance")
            )
            ->where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $now->copy()->endOfMonth()])
            ->where('type', 'in')
            ->groupBy('month_key', 'month')
            ->orderBy('month_key')
            ->get();

        // Step 3: gabungkan hasil dari DB ke dalam data 6 bulan yang sudah fix
        $final = $months->map(function ($month) use ($balances) {
            $found = $balances->firstWhere('month_key', $month['month_key']);
            if ($found) {
                $month['balance'] = $found->balance;
            }
            return $month;
        });

        return response()->json([
            'status' => 'success',
            'data' => $final,
            'message' => 'Monthly Balance Chart (Last 6 Months)'
        ]);
    }

    public function getChartDataTransaction(Request $request)
    {
        $now = Carbon::now()->startOfMonth();
        $startDate = $now->copy()->subMonths(5); // 6 bulan ke belakang (termasuk bulan ini)
        $seller = Seller::where('user_id', Auth::user()->id)->first();

        // Step 1: generate 6 bulan terakhir
        $months = collect();
        for ($i = 0; $i < 6; $i++) {
            $monthDate = $startDate->copy()->addMonths($i);
            $months->push([
                'month_key' => $monthDate->format('Y-m'),
                'month' => $monthDate->format('F Y'),
                'transaction' => 0
            ]);
        }

        // Step 2: ambil data transaksi dari DB
        $transactions = Transaction::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_key"),
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"),
                DB::raw("COUNT(*) as transaction")
            )
            ->whereBetween('created_at', [$startDate, $now->copy()->endOfMonth()])
            ->where('seller_id', $seller->id)
            ->where('status', 7)
            ->groupBy('month_key', 'month')
            ->orderBy('month_key')
            ->get();

        // Step 3: gabungkan hasil dari DB ke 6 bulan terakhir
        $final = $months->map(function ($month) use ($transactions) {
            $found = $transactions->firstWhere('month_key', $month['month_key']);
            if ($found) {
                $month['transaction'] = $found->transaction;
            }
            return $month;
        });

        return response()->json([
            'status' => 'success',
            'data' => $final,
            'message' => 'Monthly Transaction Chart (Last 6 Months)'
        ]);
    }
}
