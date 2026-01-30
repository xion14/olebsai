<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConsumerDashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 7) abort(403);

        $today = Carbon::today();

        $complainToday = DB::table('transaction_products')
            ->whereDate('complained_at', $today)
            ->count();

        $complainOpen = DB::table('transaction_products')
            ->where('complain_status', 'eopn')
            ->count();

        $stale = DB::table('transaction_products')
            ->where('complain_status', 'eopn')
            ->where('complained_at', '<', Carbon::now()->subDays(7))
            ->count();

        // Komplain per subsektor (berdasarkan produk)
        $perSubsector = DB::table('transaction_products as tp')
            ->join('products as p', 'p.id', '=', 'tp.product_id')
            ->leftJoin('setting_sub_categories as sc', 'sc.id', '=', 'p.sub_category_id')
            ->whereNotNull('tp.complain')
            ->select(DB::raw('COALESCE(sc.name, "Tanpa Subsector") as subsektor'), DB::raw('COUNT(*) as total'))
            ->groupBy('subsektor')
            ->orderBy('total', 'desc')
            ->get();

        // Persentase komplain yang selesai (close)
        $totalComplain = DB::table('transaction_products')->whereNotNull('complain')->count();
        $closedComplain = DB::table('transaction_products')->whereNotNull('complain')->where('complain_status', 'close')->count();
        $resolvedPct = $totalComplain > 0 ? round(($closedComplain / $totalComplain) * 100, 1) : 0;

        return view('admin.consumer.dashboard', compact(
            'complainToday',
            'complainOpen',
            'stale',
            'perSubsector',
            'resolvedPct',
            'totalComplain'
        ));
    }
}

