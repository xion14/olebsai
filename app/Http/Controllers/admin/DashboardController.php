<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return view('admin.dashboard');
    }

    public function getDataDashboard ()
    {
        $data = [
            'total_seller' => Seller::where('status', 4)->count(),
            'total_customer' => Customer::count(),
            'total_product' => Product::where('status', 2)->count(),
            'total_transaction_wait_admin' => Transaction::where('status', 2)->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Data Dashboard'
        ]);
    }

    public function getTransactionStatistics(Request $request) {
        $month = $request->month;
        $year = $request->year;

        $data = [
            'total_waiting_seller' => Transaction::where('status', 1)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_admin' => Transaction::where('status', 2)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_payment' => Transaction::where('status', 3)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_packing' => Transaction::where('status', 4)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_waiting_delivery' => Transaction::where('status', 5)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_on_delivery' => Transaction::where('status', 6)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_success' => Transaction::where('status', 7)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_cancel' => Transaction::where('status', 8)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_expired' => Transaction::where('status', 9)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'total_all' => Transaction::whereMonth('created_at', $month)
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
