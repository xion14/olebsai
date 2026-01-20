<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seller;
use App\Models\SellerBanner;
use App\Models\Product;

class SellerController extends Controller
{
    public function get_detail_seller(Request $request)
    {
        try {
            $id = $request->id;
            $data = Seller::find($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public  function get_seller_banner(Request $request)
    {
        try {
            $id = $request->id;
            $data = SellerBanner::where('seller_id', $id)->first();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function get_seller_product(Request $request)
    {
        try {
            $seller_id = $request->seller_id;
            $groupedProducts = [];

            // Ambil data seller dengan produk yang statusnya 2
            $sellers = Seller::whereHas('products', function ($query) use ($seller_id) {
                $query->where('seller_id', $seller_id);
            })->with(['products' => function ($query) {
                $query->where('status', 2);
            }])->get();

            // Kelompokkan produk berdasarkan kategori
            foreach ($sellers as $seller) {
                foreach ($seller->products as $product) {
                    $categoryName = $product->category->name ?? 'Uncategorized'; // Jika kategori tidak ada
                    $groupedProducts[$categoryName][] = $product;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Success get seller product',
                'data' => $groupedProducts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function get_seller_products(Request $request)
    {
        try {
            $seller_id = $request->seller_id;
            $data = Product::where('seller_id', $seller_id)->with(['category', 'seller'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Success get seller products',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
