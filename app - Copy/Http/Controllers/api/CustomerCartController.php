<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\CartProduct;
use Log;

use Illuminate\Support\Facades\DB;

class CustomerCartController extends Controller
{
    public function index(Request $request)
    {

        try {
            $request->validate([
                'customer_id' => 'required',
            ]);

            $cart = CartProduct::with(['seller','product', 'customer'])
                    ->where('customer_id', $request->customer_id)
                    ->get();
					
			Log::info(print_r($cart, true));

            return response()->json([
                'data' => $cart,
                'success' => true,
                'text' => 'Success get cart'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'text' => $th->getMessage()
            ]);
        }
    }
    // public function index(Request $request)
    // {

    //     try {
    //         $request->validate([
    //             'customer_id' => 'required',
    //         ]);

    //        // group by seller name
    //        $cart = CartProduct::where('customer_id', $request->customer_id)
    //        ->with('product')
    //        ->with('product.seller')
    //        ->get()
    //        ->groupBy('product.seller.name');

    //         return response()->json([
    //             'data' => $cart,
    //             'success' => true,
    //             'text' => 'Success get cart'
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'text' => $th->getMessage()
    //         ]);
    //     }
    // }



    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'customer_id' => 'required',
                'product_id' => 'required',
                'qty' => 'required',
            ]);
           
			$price_type = 'single'; $duration = ''; $index_selected = 0;
			$product = Product::with(['category', 'seller', 'unit'])->where('id', $request->product_id)->first();
			$status_check_multi = false;
			$request->request->set('product_type_id', $product->type_id);
			if($product->type_id==3) {
				$subtimes = $product->subtimes ? unserialize($product->subtimes) : [];
				if(count($subtimes)) {
					$request->validate([
						'customer_id' => 'required',
						'product_id' => 'required',
						'qty' => 'required',
						// // // // // 'duration' => 'required'
					]);
					
					Log::info('duration = '.$request->duration);
					$index_selected = $request->duration;
					if(array_key_exists($index_selected, $subtimes)) {
						$status_check_multi = true;
						$price_type = 'multi'; 
						$request->request->set('price_type', $price_type);
						$price = $subtimes[$index_selected]['subprice'];
						$duration = $subtimes[$index_selected]['subtime'];
						$request->request->set('price', $price);
						$request->request->set('duration_info', $duration);
						$request->request->set('detail', serialize($subtimes[$index_selected]));
					} else {
						return response()->json([
							'success' => false,
							'text' => 'Duration not valid'
						]);
					}
				}
			}
			
			if($status_check_multi) {
				$cart = CartProduct::where('customer_id', $request->customer_id)
                                ->where('product_id', $request->product_id)->where('duration', $index_selected)
                                ->first();
			} else {
				$cart = CartProduct::where('customer_id', $request->customer_id)
                                ->where('product_id', $request->product_id)
                                ->first();
			}
			
			
                            
            //check stock
            $qty = ($request->qty + @$cart->qty);
            if (!$this->checkStock($request->product_id, $qty)) {
                return response()->json([
                    'success' => false,
                    'text' => 'Stock not enough'
                ]);
            }

			// // // // // Log::info('$cart->price_type = '.$cart->price_type);
			// // // // // Log::info('$price_type = '.$price_type);
			// // // // // Log::info('$cart->duration = '.$cart->duration);
			// // // // // Log::info('$index_selected = '.$index_selected);

            if ($cart != null) {
				if(($cart->price_type == $price_type && $price_type=='single') || ($cart->price_type == $price_type && $price_type=='multi' && $cart->duration == $index_selected)) {
					$cart->update([
						'qty' => $qty
					]);
				} else {
					CartProduct::create($request->all());
				}
            } else {
                CartProduct::create($request->all());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'text' => 'Success add cart'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'text' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
			Log::info('zzzzzzzzzzzzzzzzzzz');
            DB::beginTransaction();
            $request->validate([
                'customer_id' => 'required',
                'product_id' => 'required',
                'qty' => 'required',
            ]);

            //check stock
            if (!$this->checkStock($request->product_id, $request->qty)) {
                return response()->json([
                    'success' => false,
                    'text' => 'Stock not enough'
                ]);
            }

            $cart = CartProduct::find($id);
            $cart->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'text' => 'Success update cart'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'text' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            CartProduct::find($id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'text' => 'Success delete cart'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'text' => $th->getMessage()
            ]);
        }
    }

    private function checkStock($product_id, $qty)
    {
        $product = Product::find($product_id);
        if ($product->stock < $qty) {
            return false;
        }
        return true;
    }
}