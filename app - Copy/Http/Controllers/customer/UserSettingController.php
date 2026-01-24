<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use Carbon\Carbon;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the profile setting.
     */
    public function profileSetting()
    {
        return view('customer.profile.profile');
    }

    /**
     * Display a listing of the address setting.
     */
    public function addressSetting()
    {
        return view('customer.profile.address');
    }

    /**
     * Display a listing of the order history setting.
     */
    public function orderHistorySetting()
    {
        return view('customer.profile.order_history');
    }

    /**
     * Display a listing of the order history setting.
     */
    public function waitingPaymentSetting()
    {
        return view('customer.profile.waiting_payment');
    }

    /**
     * Display a listing of the order history setting.
     */
    public function waitingConfirmation()
    {
        return view('customer.profile.waiting_confirm');
    }

    
    /**
     * Display a listing of the get saldo setting.
     */
    public function getSaldo()
    {
        return view('customer.profile.saldo');
    }
	
	public function submitReview(Request $request)
    {
		Log::info(print_r($request->all(), true));
		
		$validationRules = [
				'item_review' => 'required',
                'item_id' => 'required',
				'item_code' => 'required',
			];
			
		$messages = [
					'item_review.required' => 'Review message is missing',
					'item_id.required' => 'Review item is missing',
					'item_code.required' => 'Review code is missing',
			];
			
		$this->validate($request, $validationRules, $messages);
		
		$transaction = DB::table('transactions')->where('code', $request->item_code)->get();
		Log::info(print_r($transaction->toArray(), true));
		Log::info('**************************');
		if($transaction->count()) {
			$item_variant = $request->item_variant ? trim($request->item_variant) : '';
			$transaction_product = DB::table('transaction_products')
								->where('transaction_id', $transaction[0]->id)
								->where('product_id', $request->item_id)
								->where('variant', $item_variant)
								->get();
			Log::info('count = '.$transaction_product->count());
			Log::info(print_r($transaction_product->toArray(), true));
			if($transaction_product->count()) {
				$now = Carbon::now();
				$now_time = $now->format('Y-m-d');
				$updated = DB::table('transaction_products')
				->where('id', $transaction_product[0]->id)
				->update([
					'review' => $request->item_review,
					'reviewed_at' => Carbon::now()
				]);
				echo '<div class="message-content">'.$request->item_review.'</div>
					<div class="message-time">'.$now_time.'</div>';
			} else echo '';
		} else {
			echo '';
		}

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}