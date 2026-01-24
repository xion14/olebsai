<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($slug)
    {
		
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

		$type_id = $product->type_id;
        $product_id = $product->id;
        $seller_id = $product->seller_id;
        $customer_id = session('customer_id');
		$product_subs = $product->subtimes ? unserialize($product->subtimes) : [];
		$type = $product->type_id != 0 ? $product->type->name : 'General';

        if (!$product_id) {
            abort(404, 'Product not found');
        }

        return view('customer.product.detail', compact('type', 'slug', 'product_id', 'type_id', 'product_subs', 'customer_id', 'seller_id'));
    }
}
