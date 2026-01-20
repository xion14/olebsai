<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\CustomerAddress;
use DB;
use Log;

class RajaOngkirController extends Controller
{
    protected $key;
    protected $endpoint;
	
	public function __construct() {
		$this->key = env('RAJAONGKIR_API_KEY');
		$this->endpoint = env('RAJAONGKIR_ENDPOINT');
	}
	
	public function get_provinces() {
		try {
			$url = $this->endpoint.'destination/province';
			// // // // // $client = new Client();
			$client = new \GuzzleHttp\Client(['verify' => false]);
			$guzzleResponse = $client->get(
					$url, [
					'headers' => [
						'Content-Type' => 'application/json',
						'Accept'		=> 'application/json',
						'key' 			=> $this->key
					],
				]);
			if ($guzzleResponse->getStatusCode() == 200) {
				$response = json_decode($guzzleResponse->getBody(),true);
				
				$provinces = DB::table('provinces')->select('id', 'name')->get();
				$response['data'] = $provinces->toArray();
				
				return response()->json([
					'success' => true,
					'data' => $response['data'],
					'message' => 'Provinces proceed successfully',
				], 200);
			}
			
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
	
	// // // // // public function get_cities(Request $request) {
	public function get_cities(Request $request) {
		try {
			$request->validate([
                'province_id' => 'required',
            ]);
			$province_id = $request->province_id;
			$url = $this->endpoint."destination/city/".$province_id;
			// // // // // $client = new Client();
			$client = new \GuzzleHttp\Client(['verify' => false]);
			$guzzleResponse = $client->get(
					$url, [
					'headers' => [
						'Content-Type' => 'application/json',
						'Accept'		=> 'application/json',
						'key' 			=> $this->key
					],
				]);
			if ($guzzleResponse->getStatusCode() == 200) {
				$response = json_decode($guzzleResponse->getBody(),true);
				
				// // // // // foreach ($response['data'] as &$data) {
					// // // // // // Add the new key-value pair to the current inner array
					// // // // // $data['province_id'] = $province_id;
				// // // // // }
				// // // // // unset($data);
				
				// // // // // DB::table('cities')->insert($response['data']);
				
				$cities = DB::table('cities')->select('id', 'name', 'province_id')->where('province_id', $province_id)->get();
				$response['data'] = $cities->toArray();

				return response()->json([
					'success' => true,
					'data' => $response['data'],
					'message' => 'Cities proceed successfully',
				], 200);
			}
			
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
	
	public function get_districts(Request $request) {
		
		try {
			$city_id = $request->city_id;
			$url = $this->endpoint."destination/district/".$city_id;
			// // // // // $client = new Client();
			$client = new \GuzzleHttp\Client(['verify' => false]);
			$guzzleResponse = $client->get(
					$url, [
					'headers' => [
						// // // // // 'Content-Type' => 'application/json',
						// // // // // 'Accept'		=> 'application/json',
						'key' 			=> $this->key
					],
				]);
			if ($guzzleResponse->getStatusCode() == 200) {
				$response = json_decode($guzzleResponse->getBody(),true);
				
				// // // // // foreach ($response['data'] as &$data) {
					// // // // // // Add the new key-value pair to the current inner array
					// // // // // $data['city_id'] = $city_id;
				// // // // // }
				// // // // // unset($data);
				
				// // // // // DB::table('districts')->insert($response['data']);
				
				$districts = DB::table('districts')->select('id', 'name', 'city_id')->where('city_id', $city_id)->get();
				$response['data'] = $districts->toArray();
				
				return response()->json([
					'success' => true,
					'data' => $response['data'],
					'message' => 'Districts proceed successfully',
				], 200);
			}
			
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
	
	
	
	
	public function check_costs(Request $request) {
		
		// // // // // die('>>>'.(session('customer_id')));
		try {
			$cart = CartProduct::select('cart_products.customer_id as customer_id', 'cart_products.product_id as product_id',
					'cart_products.qty as qty', 'products.stock as stock', 'products.weight as weight')
					->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                    ->where('customer_id', $request->customer_id)
					->where('products.stock', '>=', 'cart_products.qty')
                    ->get();	
			
			if(!$cart->count()) {
				return response()->json([
					'success' => false,
					'data' => $cart,
					'message' => 'Cart or stock empty',
				], 200);
			}
			
			$customerAddress = CustomerAddress::where('customer_id', $request->customer_id)->where('active', 'yes')->get();
			if(!$customerAddress->count()) {
				return response()->json([
					'success' => false,
					'data' => $customerAddress,
					'message' => 'Please set your main address first !',
				], 200);
			}
			
			$cart_weight_total = $cart->sum('weight');

			$curl = curl_init();

			$post_data = array(
				'origin' 			=> env('RAJAONGKIR_ORIGIN'),
				'destination' 		=> $customerAddress[0]->district_id,
				'weight'			=> $cart_weight_total,
				'courier'			=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion'
			);
			
			$post_body = http_build_query($post_data);
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
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
			
			if($response->data == null) {
				$success = false;
			} else $success = true;
			
			return response()->json([
				'success' => $success,
				'data' => $response->data,
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
		
		
		
		

		// // // // // $postData = json_encode([
			// // // // // 'CalculateRequestV2.Origin' 			=> 17486,
			// // // // // 'CalculateRequestV2.destination' 		=> 17588,
			// // // // // 'weight'								=> 1000,
			// // // // // 'courier'			=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion:anteraja:pos:ncs:rex:rpx:sentral:star:wahana:dse'
		// // // // // ]);
		// // // // // $url = 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost';///$this->endpoint."calculate/domestic-cost";

		// // // // // $ch = curl_init();

		// // // // // // Set cURL options
		// // // // // curl_setopt($ch, CURLOPT_URL, $url);
		// // // // // curl_setopt($ch, CURLOPT_POST, true); // Specifies a POST request
		// // // // // // // // // // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // The POST data
		// // // // // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
		// // // // // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// // // // // // Set the HTTP headers as an array of "Key: Value" strings
		// // // // // $headers = [
			// // // // // 'Content-Type: application/json', // Inform the server the body is JSON
			// // // // // 'key: 8SVVIgTDfe1d31d3bd5da45dyc7I6CsV', // Example of an auth token header
			
		// // // // // ];
		// // // // // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// // // // // // Execute the cURL request
		// // // // // $response = curl_exec($ch);

		// // // // // // Check for errors
		// // // // // if (curl_errno($ch)) {
			// // // // // echo 'cURL error: ' . curl_error($ch);
		// // // // // }

		// // // // // // Close the cURL session
		// // // // // curl_close($ch);

		// // // // // // Process the response
		// // // // // echo $response;


		
		
		// // // // // try {
			// // // // // $cart = CartProduct::select('cart_products.customer_id as customer_id', 'cart_products.product_id as product_id',
					// // // // // 'cart_products.qty as qty', 'products.stock as stock', 'products.weight as weight')
					// // // // // ->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
                    // // // // // ->where('customer_id', $request->customer_id)
					// // // // // ->where('products.stock', '>=', 'cart_products.qty')
                    // // // // // ->get();
					
					
			
			// // // // // if(!$cart->count()) {
				// // // // // return response()->json([
					// // // // // 'success' => false,
					// // // // // 'data' => $cart,
					// // // // // 'message' => 'Cart or stock empty',
				// // // // // ], 200);
			// // // // // }
			
			// // // // // $customerAddress = CustomerAddress::where('customer_id', $request->customer_id)->where('active', 'yes')->get();
			// // // // // if(!$customerAddress->count()) {
				// // // // // return response()->json([
					// // // // // 'success' => false,
					// // // // // 'data' => $customerAddress,
					// // // // // 'message' => 'Please set your main address first !',
				// // // // // ], 200);
			// // // // // }
			
			// // // // // $cart_weight_total = $cart->sum('weight');
			// // // // // // // // // // die('>>>'.$customerAddress[0]->district_id.' $cart_weight_total = '.$cart_weight_total);
			// // // // // $url = $this->endpoint."calculate/domestic-cost";
			// // // // // // // // // // $client = new Client();
			// // // // // $client = new \GuzzleHttp\Client(['verify' => false]);
			// // // // // $guzzleResponse = $client->post(
					// // // // // $url, [
					// // // // // 'headers' => [
						// // // // // 'Content-Type'	 	=> 'application/json',
						// // // // // 'Accept'			=> 'application/json',
						// // // // // 'key' 				=> '8SVVIgTDfe1d31d3bd5da45dyc7I6CsV'///$this->key
					// // // // // ],
					// // // // // 'json' => [ 
						// // // // // 'origin' 			=> 31555,
						// // // // // 'destination' 		=> 68423,
						// // // // // 'weight'			=> 1000,
						// // // // // 'courier'			=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion'
					// // // // // ],
					// // // // // // // // // // 'body' => json_encode([
						// // // // // // // // // // 'origin' 			=> 31555,
						// // // // // // // // // // 'destination' 		=> 68423,
						// // // // // // // // // // 'weight'			=> 1000,
						// // // // // // // // // // 'courier'			=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion'
					// // // // // // // // // // ]),
					// // // // // // // // // // 'form_params' => [
						// // // // // // // // // // 'origin' 		=> 31555,
						// // // // // // // // // // 'destination'   => 68423,///$customerAddress[0]->district_id,
						// // // // // // // // // // 'weight'		=> $cart_weight_total,
						// // // // // // // // // // 'courier'		=> 'jne:sicepat:ide:sap:jnt:ninja:tiki:lion',
					// // // // // // // // // // ]
				// // // // // ]);
			// // // // // if ($guzzleResponse->getStatusCode() == 200) {
				// // // // // $response = json_decode($guzzleResponse->getBody(),true);
				
				// // // // // return response()->json([
					// // // // // 'success' => true,
					// // // // // 'data' => $response['data'],
					// // // // // 'message' => 'Shipping costs proceed successfully',
				// // // // // ], 200);
			// // // // // }
			
		// // // // // } catch (RequestException $e) {
			// // // // // return response()->json([
				// // // // // 'success' => false,
				// // // // // 'message' => $e->getMessage(),
			// // // // // ], 500);
		// // // // // } catch(Exception $e){
			// // // // // return response()->json([
				// // // // // 'success' => false,
				// // // // // 'message' => $e->getMessage(),
			// // // // // ], 500);
		// // // // // }
		
	}
}
