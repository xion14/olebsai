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
		
		$transaction = Transaction::find($request->transaction_id);
		if($transaction->status==6 && $transaction->shipping_information && $transaction->shipping_received=='no') {
			$shipping_information = json_decode($transaction->shipping_information, true);
			$curl = curl_init();

			$shipping_number = $transaction->shipping_number;
			$shipping_information_service = $shipping_information['service'];
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/track/waybill?awb=$shipping_number&courier=$shipping_information_service",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_HTTPHEADER => array('key: '.env('RAJAONGKIR_API_KEY')),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			if($response['data']['delivered'] == true) {
				$delivery_tracking = new DeliveryTracking();
				$delivery_tracking->transaction_id = $transaction->id;
				$delivery_tracking->status = $response['meta']['status'];
				$delivery_tracking->note = $response['meta']['message'];
				$delivery_tracking->save();
				Transaction::where('id', $transaction->id)->update([
					'shipping_received' => 'yes',
				]);
			} else {
				if($data->status != $response['meta']['status'] && $data->note != $response['meta']['message']) {
					$delivery_tracking = new DeliveryTracking();
					$delivery_tracking->transaction_id = $transaction->id;
					$delivery_tracking->status = $response['meta']['status'];
					$delivery_tracking->note = $response['meta']['message'];
					$delivery_tracking->save();
				}
			}
		}

        

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
