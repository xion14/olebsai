<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\log\TransactionLogController;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\SellerBalance;
use App\Models\NotificationSeller;
use App\Models\NotificationCustomer;
use App\Models\NotificationAdmin;
use App\Models\Voucher;
use App\Models\OtherCost;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Services\MidtransService;
use Exception;

//email service
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;

use Session;
use Log;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        // // // // // die('key = '.session()->get('tandah'));
		// // // // // $request->session()->put('logincodezz', '999');
        try {
            $query = Transaction::with(['transactionProducts.seller', 'seller', 'transactionProducts.product', 'customer', 'customerAddress', 'other_costs'])
                ->where('customer_id', $request->customer_id);

            if (isset($request->status)) {
                $query->where('status', $request->status);
            }

            if (!empty($request->date)) {
                $query->whereDate('created_at', $request->date);
            }

            $data = $query->orderBy('id', 'desc')->paginate(intval($request->item_per_page) ?: 100000);

            foreach ($data as $transaction) {
                $transaction->total = $transaction->total + $transaction->other_costs->sum('amount');
                $transaction->other_cost = $transaction->other_costs->sum('amount');
            }

            return response()->json([
                'success' => true,
                'message' => 'Success get transactions',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ]);
        }
    }


    public function store(Request $request)
    {
		return response()->json([
                        'success' => false,
                        'message' => 'Illegal Access',
                    ], 400);
		
        try {
            DB::beginTransaction();
            // // // // // $request->validate([
                // // // // // 'carts' => 'required|array|min:1',
                // // // // // 'customer_id' => 'required',
                // // // // // 'seller_id' => 'required',
                // // // // // 'customer_address_id' => 'required',
				// // // // // 'shipping_cost' => 'required',
            // // // // // ]);
			
			$validationRules = [
				'carts' => 'required|array|min:1',
                'customer_id' => 'required',
                'seller_id' => 'required',
                'customer_address_id' => 'required',
				'shipping_cost' => 'required',
			];
			
			$messages = [
					'shipping_cost.required' => 'Ongkos Kirim Belum Dipilih !',
			];
			
			$this->validate($request, $validationRules, $messages);
			
			
            $customer = Customer::findOrFail($request->customer_id);
            $seller = Seller::findOrFail($request->seller_id);
            $last_id = @Transaction::latest('id')->first()->id  ?? 0;
            $code = "CO" . date("YmdHi") . str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT) . $last_id + 1;

            if (!empty($request->voucher_id)) {
                $voucher = Voucher::findOrFail($request->voucher_id);
            
                // Hitung jumlah voucher yang sudah digunakan
                $count_voucher_used = Transaction::where('voucher_id', $request->voucher_id)->count();
            
                // Hitung total pembayaran dari cart
                $total_payment = 0;
                foreach ($request->carts as $cart) {
                    $get_cart = CartProduct::find($cart['id']);
                    $get_product = Product::findOrFail($get_cart->product_id);
                    $total_payment += $get_product->price * $get_cart->qty;
                }
            
                // Cek validitas voucher satu per satu dan return pesan spesifik
                if (Carbon::now()->lt($voucher->start_date)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Voucher is not active yet',
                    ], 400);
                }
            
                if (Carbon::now()->gt($voucher->expired_date)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Voucher has expired',
                    ], 400);
                }
            
                if ($voucher->status == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Voucher is inactive',
                    ], 400);
                }
            
                if ($count_voucher_used >= $voucher->quota) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Voucher quota exhausted',
                    ], 400);
                }
            
                if ($total_payment < $voucher->minimum_transaction) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Minimum transaction not reached for this voucher',
                    ], 400);
                }
            }
            
            
            $transaction = Transaction::create([
                'seller_id' => $request->seller_id,
                'customer_id' => $request->customer_id,
                'customer_address_id' => $request->customer_address_id,
                'voucher_id' => $request->voucher_id ?? null,
                'code' => $code,
                'status' => 3,///1,																							reza-mod
                'note' => $request->note
            ]);

            $n=0; $status_non_digital = 0;
            foreach ($request->carts as $cart) {
                $get_cart = CartProduct::find($cart['id']);
                $get_product = Product::findOrFail($get_cart->product_id);

                if($get_product->type_id == 1) $status_non_digital = $status_non_digital + 1;

                //check stock   
                if ($get_product->stock < $get_cart->qty) {
                    throw new Exception("Stock Not Enough", 1);
                } else {
                    $get_product->stock -= $get_cart->qty;
                    $get_product->save();
                }

                $transaction->seller_id = $get_product->seller_id;
                $transaction->subtotal += $get_product->price * $get_cart->qty;
                $transaction->total += $get_product->price * $get_cart->qty;
                

                TransactionProduct::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $get_cart->product_id,
                    'price' => $get_product->price,
                    'seller_price' => $get_product->seller_price,
                    'admin_cost' => $get_product->admin_cost,
                    'qty' => $get_cart->qty,
                    'total' => $get_product['price'] * $get_cart->qty,
                ]);

                $get_cart->delete();
                $n++;
            }

            if($n) {
                // // // // // if($status_non_digital == 0) $transaction->status = 3;		/// ini kl mau combine di cart		reza-mod
				$transaction->status = 3;
                $transaction->save();
            }

            if (!empty($request->voucher_id)) {

                $voucher = Voucher::findOrFail($request->voucher_id);
            
                if ($voucher->type == 1) {
                    $calculatedDiscount = $transaction->total * $voucher->value / 100;
            
                    $maxDiscount = $voucher->max_discount ?? $calculatedDiscount;
            
                    OtherCost::create([
                        'transaction_id' => $transaction->id,
                        'amount' => "-".$maxDiscount,
                        'name' => $voucher->name,
                    ]);
                }
            }
            

            $notif = NotificationSeller::create([
                'user_id' => $seller->user_id,
                'title' => 'New Order',
                'content' => 'You have a new order',
                'type' => 'success',
                'url' => '/seller/transactions/' . $transaction->id,
            ]);

            $transaction_log = (new TransactionLogController)->store($customer->user_id, $transaction->id, 'create', 'order has been created');

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $transaction,
                'message' => 'Transaction has been created',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
	
	
	public function cart(Request $request) {
		
		// // // // // die(session('customer_id'));
		$data = json_decode($request->items, true);
		
	
	}

    public function payment(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'order_id' => 'required',
            ]);

            $transaction = Transaction::where('status', 3)->where('code', $request->order_id)->first();

            if ($transaction->snap_token != null) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'data' => $transaction->snap_token,
                    'message' => 'Success create snap token'
                ], 200);
            }

            $midtrans   = new MidtransService();
            $snapToken  = $midtrans->createTransaction($transaction);

            $transaction->snap_token = $snapToken;
            $transaction->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $snapToken,
                'message' => 'Success create snap token'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function handle_notification(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'order_id' => 'required',
            ]);

            

            $transaction = Transaction::with(['transactionProducts.seller', 'customer' , 'customerAddress' ,'other_costs'])
            ->where('code', $request->order_id)->first();

            $subTotal = $transaction->transactionProducts->sum('total');
            $otherCost = $transaction->other_costs->sum('amount');


        
            // if ($request->gross_amount != $transaction->total) {
            //     DB::rollBack();
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'invalid amount',
            //     ], 500);
            // }

            switch ($request->transaction_status) {
                case 'settlement':
                    $transaction->status = 4;
                    //send email
                    Mail::to($transaction->customer->email)->send(new PaymentSuccessMail($transaction, $transaction->transactionProducts, $transaction->customer , $transaction->seller, $transaction->customerAddress, $subTotal , $otherCost));
                    break;
                case 'pending':
                    $transaction->status = 3;
                    break;
                case 'deny':
                    $transaction->status = 10;
                    break;
                case 'expire':
                    $transaction->status = 9;
                    break;
                case 'cancel':
                    $transaction->status = 8;
                    break;
            }

            $transaction->payment_method = $request->payment_type;
            $transaction->payment_channel = $request->va_number[0]->bank ?? null;
            $transaction->save();

            $transaction_log = (new TransactionLogController)->store($transaction->customer->user_id, $transaction->id, 'handle_notification', 'this transaction is' . $request->transaction_status);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Success handle notification',
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function received(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'order_id' => 'required',
            ]);

            $transaction = Transaction::with(['transactionProducts.seller', 'customer'])
                ->where('code', $request->order_id)
                ->first();

            if (!$transaction) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                    'data' => [],
                ], 404);
            }
			
            if ($transaction->status == 7) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been received',
                    'data' => [],
                ], 400);
            }

            if ($transaction->status != 6) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order status is not valid for receiving',
                    'data' => [],
                ], 400);
            }


            $transaction->status = 7;
            $transaction->save();

            $transaction_log = (new TransactionLogController)->store($transaction->customer->user_id, $transaction->id, 'received', 'order has been received');

            $seller = $transaction->transactionProducts->first()->seller ?? null;

            if ($seller) {
				Log::info('$transaction->status seller ====> '.$transaction->status);
                $existingSellerBalance = SellerBalance::where('seller_id', $seller->id)
                    ->where('transaction_id', $transaction->id)
                    ->first();

                if ($existingSellerBalance) {
					Log::info('existingSellerBalance $seller->id = '.$seller->id);
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Order has already been received',
                    ], 400);
                }

                $net_amount = 0;
                $net_transaction = 0 ;

                foreach ($transaction->transactionProducts as $product) {
                    $net_amount += ($product->qty * $product->price) - ($product->admin_cost * $product->qty) ;
                }

                foreach ($transaction->other_costs as $cost) {
                    $net_amount += $net_transaction + $cost->amount;
                }

                // Buat saldo baru jika belum ada
                $newSellerBalance = new SellerBalance();
                $newSellerBalance->seller_id = $seller->id;
                $newSellerBalance->transaction_id = $transaction->id;
                $newSellerBalance->type = 'in';
                $newSellerBalance->amount = $net_amount;
                $newSellerBalance->save();
            } else Log::info('$transaction->status buyer ====> '.$transaction->status);


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success received transaction',
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'order_id' => 'required',
            ]);

            $transaction = Transaction::with(['transactionProducts.seller', 'customer'])
                ->where('code', $request->order_id)
                ->first();

            if (!$transaction) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                    'data' => [],
                ], 404);
            }

            if ($transaction->status == 9) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been canceled',
                    'data' => [],
                ], 400);
            }

            // if ($transaction->status != 1 || $transaction->status != 2 || $transaction->status != 3) {
            //     DB::rollBack();
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Order status is not valid for canceling',
            //         'data' => $transaction->status,
            //     ], 400);
            // }

            if (!in_array($transaction->status, [1, 2, 3])) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Order status is not valid for canceling',
                    'data' => $transaction->status,
                ], 400);
            }
            

            $transaction->status = 8;
            $transaction->save();

            foreach ($transaction->transactionProducts as $product) {
                $product->product->stock += $product->qty;
                $product->product->save();
            }

            $transaction_log = (new TransactionLogController)->store($transaction->customer->user_id, $transaction->id, 'cancel', 'order has been canceled');

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success cancel transaction',
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}