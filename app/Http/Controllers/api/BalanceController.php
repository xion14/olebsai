<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\CustomerBalance;
use App\Models\CustomerWithdraw;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $validateData = $request->validate([
                'customer_id' => 'required'
            ]);

            $customerBalance = CustomerBalance::where('customer_id', $validateData['customer_id'])->orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $customerBalance
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkAvailableBalance(Request $request)
    {
        try {
            $validateData = $request->validate([
                'customer_id' => 'required'
            ]);

            $customerBalance = CustomerBalance::where('customer_id', $validateData['customer_id'])->where('type', 'in')->sum('amount');
            $customerWithdraw = CustomerBalance::where('customer_id', $validateData['customer_id'])->where('type', 'out')->sum('amount');
            $total = $customerBalance - $customerWithdraw;
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $total
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}