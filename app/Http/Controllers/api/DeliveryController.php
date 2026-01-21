<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryTracking;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->transaction_id) return response()->json(['error' => 'Transaction Number is required'], 400);

        $data = DeliveryTracking::where('transaction_id', $request->transaction_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Data has been retrieved successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
            'status' => 'required',
            'note' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $transaction = Transaction::find($request->transaction_id);
			$shipping_cost_status = $transaction->shipping_cost ? true : false;
			

            if ($transaction->shipping_status == 'Received') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction has been received'
                ], 400);
            }

            if ($request->status == 'Received') {
                $notif = new NotificationUser;
                $notif->user_id = $transaction->customer->user_id;
                $notif->title = 'Transaction Received';
                $notif->content = 'Transaction ' . $transaction->transaction_number . ' has been arrived to your address';
                $notif->type = 'success';
                $notif->url = '/order-history';
                $notif->save();
            }

            $data = DeliveryTracking::create($request->all());

            $transaction->shipping_status = $request->status;
            $transaction->update();
            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Data has been saved successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
