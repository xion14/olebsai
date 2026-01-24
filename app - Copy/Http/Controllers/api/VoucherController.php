<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Voucher;
use Carbon\Carbon;

class VoucherController extends Controller
{

    public function get_all_voucher(Request $request) {
        $vouchers = Voucher::get(10);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $vouchers
        ], 200);
    }

    public function get_active_voucher(Request $request)
    {
        $now = Carbon::now();
        $vouchers = Voucher::where('start_date', '<=', $now)
            ->where('expired_date', '>=', $now)
            ->where('status', 1)
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $vouchers
        ], 200);
    }
}