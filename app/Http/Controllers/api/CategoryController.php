<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SettingCategory;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = SettingCategory::orderBy('name', 'asc');

        if (!empty($request->search)) {
            $categories->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $categories->get();
        
        return response()->json([
            'success'   => true,
            'data'      => $categories,
            'message'   => 'Success get categories'
        ]);
    }

    public function getCategoryWithProducts(Request $request)
    {
        $categories = SettingCategory::orderBy('code', 'asc')->get();

        $result = [];

        foreach ($categories as $category) {
            // Ambil maksimal 6 produk yang cocok dengan kategori ini
            $products = Product::with('seller')
                ->where('category_id', $category->id)
                ->where('stock', '>', 0)
                ->where('status', 2)
                ->orderBy('total_sells', 'desc')
                ->limit(6)
                ->get();

            // Tempel ke data category (pakai append atau bikin key baru)
            $category->setRelation('products', $products);

            $result[] = $category;
        }

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Success get categories with up to 6 products each'
        ]);
    }
}
