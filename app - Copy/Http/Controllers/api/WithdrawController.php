<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerWithdraw;
use App\Models\CustomerBalance;
use App\Models\NotificationAdmin; // Import model NotificationAdmin
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    // Withdraw List
    public function index(Request $request)
    {
        $customer_id = $request->customer_id;

        $customerWithdraw = CustomerWithdraw::where('customer_id', $customer_id)->get();

        return response()->json([
            'success' => true,
            'data' => $customerWithdraw,
            'message' => 'Withdraw List'
        ]);
    }

    // Store Withdraw
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $customer_id = $request->customer_id;
            $amount = $request->amount;
            $note = $request->note;

            // Get current balance
            $balanceIn = CustomerBalance::where('customer_id', $customer_id)->where('type', 'in')->sum('amount');
            $balanceOut = CustomerBalance::where('customer_id', $customer_id)->where('type', 'out')->sum('amount');
            $balance = $balanceIn - $balanceOut;

            if ($balance < $amount) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Insufficient balance'
                ], 400);
            }

            // Generate withdraw code
            $last_id = CustomerWithdraw::latest('id')->first()->id ?? 0;
            $code = "WD" . date("YmdHi") . str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT) . ($last_id + 1);

            $withdraw = new CustomerWithdraw();
            $withdraw->code = $code;
            $withdraw->note = $note;
            $withdraw->customer_id = $customer_id;
            $withdraw->amount = $amount;
            $withdraw->save();

            // Create admin notification
            $notif = new NotificationAdmin();
            $notif->title = 'Withdrawal Request';
            $notif->content = 'Withdrawal request from customer ID ' . $customer_id . ' with amount Rp ' . number_format($amount, 0, ',', '.');
            $notif->type = 'info';
            $notif->url = '/admin/withdraw';
            $notif->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $withdraw,
                'status' => 'success',
                'message' => 'Withdrawal successful'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error during withdrawal',
                'success' => false,
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}