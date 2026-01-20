<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $item_per_page = $request->item_per_page ?? 25;
        $products = Product::where('status', 2)->orderBy('name', 'asc');

        if (!empty($request->search)) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        if (!empty($request->category_id)) {
            $products->where('category_id', $request->category_id);
        }

        if (!empty($request->unit_id)) {
            $products->where('unit_id', $request->unit_id);
        }

        if (!empty($request->seller_id)) {
            $products->where('seller_id', $request->seller_id);
        }

        if (!empty($request->product_ids)) {
            $products->whereIn('id', $request->product_ids);
        }

        $products = $products->paginate($item_per_page);

        return response()->json([
            'data' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'seller', 'unit'])->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
		
		if($product->type_id==3) {
			$product_subs = $product->subtimes ? unserialize($product->subtimes) : [];
			if(count($product_subs)) $product->price = $product_subs[0]['subprice'];
		}

        return response()->json([
            'success'   => true,
            'data'      => $product,
            'message'   => 'Success get product'
        ]);
    }

    public function bestSeller(Request $request)
    {
        $item_per_page = 6;
        $products = Product::with(['category', 'seller'])
            ->where('status', 2)
            ->orderBy('total_sells', 'desc')
            ->orderBy('name', 'asc')
            ->limit($item_per_page)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Success get best seller'
        ]);
    }

    public function searchRecomendation(Request $request)
    {
        $query = $request->input('query');

        if (strlen($query) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Failed get search recomendation'
            ]);
        }

        $products = Product::where('name', 'like', "%$query%")
            ->where('status', 2)
            ->where('stock', '>', 0)
            ->orderBy('total_sells', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Success get search recomendation'
        ]);
    }

    public function shop(Request $request)
    {
        $search = $request->input('search', '');
        $categories = $request->input('categories', []);
        $item_per_page = $request->input('item_per_page', 20);

        $products = Product::with(['category', 'seller'])->where('stock', '>', 0)->where('status', 2);

        if ($search) {
            $products->where('name', 'like', '%' . $search . '%');
        }

        if (count($categories) > 0) {
            $products->whereHas('category', function ($query) use ($categories) {
                $query->whereIn('slug', $categories);
            });
        }

        $products = $products->paginate($item_per_page);

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Success get shop products'
        ]);
    }

    public function recomendation(Request $request)
    {
        $product = Product::find($request->product_id);
        $item_per_page = 6;
        $products = Product::with(['category', 'seller'])
            ->whereNotIn('id', [$product->id])
            ->where('status', 2)
            ->where('category_id', $product->category_id)
            ->orderBy('total_sells', 'desc')
            ->orderBy('name', 'asc')
            ->limit($item_per_page)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Success get product recomendation'
        ]);
    }
}
