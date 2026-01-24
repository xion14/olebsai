<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\log\TransactionLogController;

use Illuminate\Http\Request;
use App\Models\CartProduct;
use App\Models\CustomerAddress;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\OtherCost;
use App\Models\NotificationSeller;
use DB;
use Log;

class CheckoutController extends Controller
{
	public $i;
	
	public function __construct() {
		$this->i = 0;
	}
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		session()->forget('data_ongkir');
		$customer_id = session('customer_id');
		$affectedRows = CartProduct::where('customer_id', $customer_id)->update(['checked' => 'no']);
        return view('customer.checkout.checkout');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
	
	public function update_cart(Request $request) {
		session()->forget('data_ongkir');
		Log::info('checkStatus = '.$request->checkStatus);
		$customer_id = session('customer_id');
		$checkStatus = $request->checkStatus;
		$itemArray = $request->items ? json_decode($request->items) : [];
		$ids = [];
		for($n=0; $n<count($itemArray); $n++) {
			$ids[] = $itemArray[$n]->id;
		}
		$checked = $request->checkStatus == 'true' ? 'yes' : 'no';
		Log::info('checked = '.$checked);

		if(count($ids)) {
			if($checked == 'yes')
				$affectedRows = CartProduct::where('customer_id', $customer_id)->whereIn('id', $ids)->update(['checked' => $checked]);
			else
				$affectedRows = CartProduct::where('customer_id', $customer_id)->whereNotIn('id', $ids)->update(['checked' => $checked]);
		} else
			$affectedRows = CartProduct::where('customer_id', $customer_id)->update(['checked' => 'no']);
	}
	
	
	public function check_shipping() {
		$customer_id = session('customer_id');
		try {
			$cart = CartProduct::select('cart_products.customer_id as customer_id', 'cart_products.product_id as product_id',
					'cart_products.qty as qty', 'cart_products.checked as cart_products_checked', 'products.stock as stock', 'products.weight as weight', 'products.price as price', 'price_type',
					DB::raw("CASE WHEN price_type = 'multi' THEN qty * cart_products.price ELSE qty * products.price END AS total_price"),					
					DB::raw('qty * cart_products.price AS cart_total_price'),
					DB::raw('qty * products.price AS product_total_price'))
					->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                    ->where('customer_id', $customer_id)
					->where('checked', 'yes')
					->where('products.stock', '>=', 'cart_products.qty')
                    ->get();

			Log::info(print_r($cart->toArray(), true));
			
			if(!$cart->count()) {
				return response()->json([
					'success' => false,
					'data' => $cart,
					'message' => 'Cart or stock empty',
				], 200);
			}
			
			$customerAddress = CustomerAddress::where('customer_id', $customer_id)->where('active', 'yes')->get();
			if(!$customerAddress->count()) {
				return response()->json([
					'success' => false,
					'data' => $customerAddress,
					'message' => 'Please set your main address first !',
				], 200);
			}
			
			$cart_weight_total = $cart->sum('weight');
			// // // // // $cart_price_total = $cart->where('cart_products_checked', 'yes')->sum('total_price');
			$cart_price_total = $cart->sum('total_price');
			session([
            'cart_price_total' => $cart_price_total
			]);

			$curl = curl_init();

			$post_data = array(
				'origin' 			=> env('RAJAONGKIR_ORIGIN'),
				'destination' 		=> $customerAddress[0]->district_id,
				'weight'			=> $cart_weight_total,
				'courier'			=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion'
			);
			
			$post_body = http_build_query($post_data);
			curl_setopt_array($curl, array(
			  CURLOPT_URL => env('RAJAONGKIR_ENDPOINT').'calculate/domestic-cost',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POST => true,
			  CURLOPT_POSTFIELDS => $post_body,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_HTTPHEADER => array(
				'key: '.env('RAJAONGKIR_API_KEY'),
				'Content-Type: application/x-www-form-urlencoded'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$response = json_decode($response);
			
			$data_ongkir = [];
			if($response->data == null) {
				$success = false;
			} else {
				$success = true;
				$data_ongkir = $response->data;
				// // // // // $affectedRows = Customer::where('id', $customer_id)->update([
					// // // // // 'address_status' => 'yes'
				// // // // // ]);
				session()->forget('data_ongkir');
			}
			
			session([
            'data_ongkir' => $data_ongkir,
			'customer_shipping_address' => $customerAddress[0]
			]);
			
			return response()->json([
				'success' => $success,
				'data' => $data_ongkir,
				'message' => 'Shipping costs proceed successfully',
			], 200);

		} catch (RequestException $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		} catch(Exception $e){
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}
	
	public function select_shipping(Request $request) {
////ambil dari session data_ongkir
		Log::info('$request->shipping = '.$request->shipping);
		$shipping = $request->shipping;
		$data_ongkir = session('data_ongkir');
		$key = array_search($shipping, array_column($data_ongkir, 'service'));
		if($key !== false) {
			$success = true;
			$data = $data_ongkir[$key];
			$data_cost_shipping = $data->cost;
		} else {
			$success = false;
			$data = null;
			$data_cost_shipping = 0;
		}
		$total_include_shipping = session('cart_price_total') + $data_cost_shipping;
		return response()->json([
				'success' => $success,
				'data' => $data,
				'total_include_shipping' => $total_include_shipping
			], 200);
		
	}
	

    public function store(Request $request)
    {
        // // // // // try {
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
					'shipping_problem' => 'Ongkos Kirim harap dipilih, atau refresh halaman dan ulang kembali !',
					'cart_changed' => 'Terjadi perubahan produk & beberapa item akan direset, mohon refresh halaman dan ulang kembali !'
			];
			
			// // // // // $this->validate($request, $validationRules, $messages);
			
			$customer_id = session('customer_id');
			// // // // // Log::info("session('customer_id') = ".session('customer_id'));
			$carts = CartProduct::select('cart_products.id as id', 'cart_products.customer_id as customer_id', 'cart_products.product_id as product_id', 'duration_info', 'cart_products.duration as duration',
			'cart_products.qty as qty', 'cart_products.checked as cart_products_checked', 'products.stock as stock', 'products.weight as weight', 'products.price as price', 'products.subtimes as subtimes', 'cart_products.price as cart_price', 'type_id', 'price_type',
			DB::raw("CASE WHEN price_type = 'multi' THEN qty * cart_products.price ELSE qty * products.price END AS total_price")
			// // // // // ,
			// // // // // DB::raw('qty * products.price AS total_price')
			)
			->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
			->where('customer_id', $customer_id)
			->where('checked', 'yes')
			->where('products.stock', '>=', 'cart_products.qty')
			->get();
			$carts_array = $carts->toArray();
			$cart_ids = [];
			if($carts->count()) {
				foreach($carts as $cart) {
					$cart_ids[] = $cart->id;
				}
			}
			Log::info(print_r($carts->toArray(), true));
			
			
			/// INI NANTI DILAKUKAN SAJA KALAU BARANG BISA DIEDIT UNTUK HARGA DAN TYPE DAN LAIN-LAIN NYA		REZA
			$cart_checks = $carts->filter(function($item){
				$count_subtimes_value = 0;
				$cart_item_status = true;
				if($item->type_id==3) {
					if(trim($item->subtimes)) {
						$subtimes_value =unserialize($item->subtimes);
						$count_subtimes_value = count($subtimes_value);
					}
					if($count_subtimes_value && $item->price_type=='single' || !$count_subtimes_value && $item->price_type=='multi') $cart_item_status = false;
					if($item->price_type=='multi') {
						// // // // // Log::info('&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&');
						Log::info($item->product_id);
						// // // // // Log::info($item->cart_price);
						Log::info($item->stock);
						Log::info($item->duration);
						Log::info($item->subtimes);
						$subtimes = unserialize($item->subtimes);
						if($item->cart_price != (isset($subtimes[$item->duration]) ? $subtimes[$item->duration]['subprice'] : 'NO!')) $cart_item_status = false;
					}
				}
				return $cart_item_status;
			});
			$cart_check_ids = [];
			if($cart_checks->count()) {
				foreach($cart_checks as $cart_check) {
					$cart_check_ids[] = $cart_check->id;
				}
			}
			
			$card_ids_not_exist = [];
			$card_ids_not_exist = array_diff($cart_ids, $cart_check_ids);
			/// INI NANTI DILAKUKAN SAJA KALAU BARANG BISA DIEDIT UNTUK HARGA DAN TYPE DAN LAIN-LAIN NYA		REZA
			
			if(!$carts->count()) {
				$validationRules['item_not_checked'] = 'required';
				$messages['item_not_checked'] = 'Pilih produk terlebih dahulu';
			}
			
			// // // // // Log::info('$carts->count() = '.$carts->count());
			// // // // // Log::info('@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@');
			// // // // // Log::info(print_r($carts->toArray(), true));
			
			$weight_total = $carts->sum('weight');
			
			// // // // // Log::info('weight_total = '.$weight_total);
			
			$check_physic = false;
			$check_type = $carts->where('type_id', 1);
			if($check_type->count()) $check_physic = true;
			// // // // // Log::info('$check_physic = '.$check_physic);
			
			$data_ongkir = session('data_ongkir') ? session('data_ongkir') : [];
			
			// // // // // Log::info('#############################');
			// // // // // Log::info(print_r($data_ongkir, true));
			
			if(!count($data_ongkir) && !$check_physic && $weight_total <= 0) {
				unset($validationRules['shipping_cost']);
				// // // // // Log::info('vvvvvvvvvvvvvvvvvvvv');
			}
			
			$shipping = $request->shipping_cost ?  $request->shipping_cost : '-';
			// // // // // Log::info('shipping = '.$shipping);
			$key = array_search($shipping, array_column($data_ongkir, 'service'));
			if($key !== false) {
				// // // // // Log::info('1111111111111111111111111111111111111111111');
				$success = true;
				$data = $data_ongkir[$key];
				$data_cost_shipping = $data->cost;
				$data_cost_name = $data->name;
				$data_cost_description = $data->description;
				$data_cost_etd = $data->etd;
				$shipping_information = json_encode($data);
			} else {
				// // // // // Log::info('2222222222222222222222222222222222222222222222');
				$success = false;
				$data = null;
				$data_cost_shipping = 0;
				$data_cost_name = '';
				$data_cost_description = '';
				$data_cost_etd = '';
				$shipping_information = '';
				if($carts->count()) $validationRules =  $check_physic ? ['shipping_problem' => 'required'] : [];
				// // // // // Log::info('oooooooooooooooooooooooooooooooo');
				// // // // // Log::info(print_r($validationRules, true));
			}
			$total_shipping = $data_cost_shipping;
			
			// // // // // Log::info('data_cost_name = '.$data_cost_name.' data_cost_shipping = '.$data_cost_shipping);
			// // // // // Log::info('+++++++++++++++++++++++++++++++++++');
			// // // // // Log::info(print_r($validationRules, true));
			if(count($card_ids_not_exist)) {
				$card_ids_not_exist = array_values($card_ids_not_exist);
				$validationRules = ['cart_changed' => 'required'];
				CartProduct::whereIn('id', $card_ids_not_exist)->delete();
				DB::commit();
			}
			$this->validate($request, $validationRules, $messages);
			
            $customer = Customer::findOrFail($request->customer_id);
            $seller = Seller::findOrFail($request->seller_id);
            $last_id = @Transaction::latest('id')->first()->id  ?? 0;
            $code = "CO" . date("YmdHi") . str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT) . $last_id + 1;
			
			
			$total_payment = $carts->sum('total_price') + $total_shipping;

            if (!empty($request->voucher_id)) {
                $voucher = Voucher::findOrFail($request->voucher_id);
            
                // Hitung jumlah voucher yang sudah digunakan
                $count_voucher_used = Transaction::where('voucher_id', $request->voucher_id)->count();
            
                // Hitung total pembayaran dari cart
                // // // // // $total_payment = 0;
                // // // // // foreach ($request->carts as $cart) {
                    // // // // // $get_cart = CartProduct::find($cart['id']);
                    // // // // // $get_product = Product::findOrFail($get_cart->product_id);
                    // // // // // $total_payment += $get_product->price * $get_cart->qty;
                // // // // // }
				
            
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
				
				'shipping_information' => $shipping_information,
				'shipping_cost' => $total_shipping,
				'shipping_name' => $data_cost_name,
				'shipping_description' => $data_cost_description,
				'shipping_etd' => $data_cost_etd,
				
				'subtotal' => $carts->sum('total_price'),
				'total' => $total_payment,
				
                'status' => 3,///1,																							reza-mod
                'note' => $request->note
            ]);

            $n=0; $status_non_digital = 0;
            foreach ($carts as $cart) {
				Log::info('$cart->id = '.$cart->id);
                $get_cart = CartProduct::find($cart->id);
                $get_product = Product::findOrFail($get_cart->product_id);
				
				$variant = [];
				if($get_product->type_id==3 && trim($get_product->subtimes)) {
					$variant = unserialize($get_product->subtimes);
				}

                if($get_product->type_id == 1) $status_non_digital = $status_non_digital + 1;

                //check stock   
                if ($get_product->stock < $get_cart->qty) {
                    throw new Exception("Stock Not Enough", 1);
                } else {
                    $get_product->stock -= $get_cart->qty;
                    $get_product->save();
                }

                $transaction->seller_id = $get_product->seller_id;
                // // // // // $transaction->subtotal += $get_product->price * $get_cart->qty;
                // // // // // $transaction->total += $get_product->price * $get_cart->qty;
                

                TransactionProduct::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $get_cart->product_id,
					'cart_product_type_id' => $get_cart->product_type_id,
					'variant' => $cart->duration_info,
                    'price' => count($variant) ? $cart->cart_price : $get_product->price,
                    'seller_price' => $get_product->seller_price,
                    'admin_cost' => $get_product->admin_cost,
                    'qty' => $get_cart->qty,
                    'total' => (count($variant) ? $cart->cart_price : $get_product->price) * $get_cart->qty,
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
        // // // // // } catch (\Exception $e) {
            // // // // // DB::rollBack();
            // // // // // return response()->json([
                // // // // // 'success' => false,
                // // // // // 'message' => $e->getMessage(),
            // // // // // ], 500);
        // // // // // }
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