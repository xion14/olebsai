<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 6) abort(403);

        $active = DB::table('sellers')->where('status', 4)->count();
        $nonactive = DB::table('sellers')->where('status', 0)->count();
        $newReg = DB::table('sellers')->where('status', 1)->count();

        $problematic = DB::table('sellers as s')
            ->leftJoin('transactions as t', 't.seller_id', '=', 's.id')
            ->leftJoin('transaction_products as tp', 'tp.transaction_id', '=', 't.id')
            ->select('s.id')
            ->where(function ($q) {
                $q->whereIn('t.status', [8,9])
                  ->orWhereNotNull('tp.complain')
                  ->orWhere('tp.complain_status', 'eopn');
            })
            ->distinct()
            ->count();

        return view('admin.user.dashboard', compact('active','nonactive','newReg','problematic'));
    }
}

