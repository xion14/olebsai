<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\SellerBanner;

class HomeAndAllProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function homePage()
    {

        return view('seller.home_and_product.homepage');
    }

    /**
     * Display a listing of the resource.
     */
    public function allProductSeller($username)
    {
        $seller = Seller::where('username', $username)->first();
        if (!$seller) {
            return redirect()->back()->with('error', 'Seller not found');
        }

        $seller_banners = SellerBanner::where('seller_id', $seller->id)->get();
        return view('seller.home_and_product.all_product', [
            'seller' => $seller,
            'seller_banners' => $seller_banners
        ]);
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
