<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SettingCost;

class SettingCostService
{
    /**
     * Menghitung admin_cost berdasarkan seller_price.
     */
    public function countSettingCost($seller_price)
    {
        $admin_cost = SettingCost::where('min_price', '<=', $seller_price)
                                 ->where('max_price', '>=', $seller_price)
                                 ->where('status', 1)
                                 ->first();

        if (!$admin_cost) {
			return [
				'admin_cost_id' => null,
				'admin_cost' => 0,
			];
            return null;
        }

        return [
            'admin_cost_id' => $admin_cost->id,
            'admin_cost' => $admin_cost->cost_value,
        ];
    }

    /**
     * Saat SettingCost diperbarui: update semua produk yang saat ini terhubung.
     */
    public function updateRelatedProducts(SettingCost $settingCost)
    {
        $products = Product::where(function ($query) use ($settingCost) {
            $query->where('admin_cost_id', $settingCost->id)
                  ->orWhereNull('admin_cost_id')
                  ->orWhereBetween('seller_price', [$settingCost->min_price, $settingCost->max_price]);
        })->get();
    
        foreach ($products as $product) {
            // Gunakan seller_price atau fallback ke price
            $effectiveSellerPrice = $product->seller_price ?? $product->price;
    
            if (
                $effectiveSellerPrice >= $settingCost->min_price &&
                $effectiveSellerPrice <= $settingCost->max_price &&
                $settingCost->status == 1
            ) {
                // Masih sesuai range settingCost
                $product->seller_price = $product->seller_price ?? $product->price;
                $product->admin_cost_id = $settingCost->id;
                $product->admin_cost = $settingCost->cost_value;
                $product->price = $effectiveSellerPrice + $settingCost->cost_value;
            } else {
                // Tidak sesuai, cari setting lain
                $newCost = $this->countSettingCost($effectiveSellerPrice);
    
                if ($newCost) {
                    $product->admin_cost_id = $newCost['admin_cost_id'];
                    $product->admin_cost = $newCost['admin_cost'];
                    $product->price = $effectiveSellerPrice + $newCost['admin_cost'];
                } else {
                    $product->admin_cost_id = null;
                    $product->admin_cost = 0;
                    $product->price = $effectiveSellerPrice;
                }
            }
    
            $product->save();
        }
    }
    


    public function assignProductsToNewSettingCost(SettingCost $settingCost)
    {
        if ($settingCost->status != 1) {
            return;
        }

        $products = Product::whereBetween('seller_price', [$settingCost->min_price, $settingCost->max_price])
                            ->get();

        foreach ($products as $product) {
            $product->admin_cost_id = $settingCost->id;
            $product->admin_cost = $settingCost->cost_value;
            $product->price = $product->seller_price + $settingCost->cost_value;
            $product->save();
        }
    }



    /**
     * Saat SettingCost baru dibuat: cari produk yang cocok dan update admin_cost serta id-nya.
     */
    // public function assignProductsToNewSettingCost(SettingCost $settingCost)
    // {
    //     if ($settingCost->status != 1) {
    //         return;
    //     }

    //     $products = Product::whereNull('admin_cost_id')->whereBetween('seller_price', [$settingCost->min_price, $settingCost->max_price])->get();
    
    //     // $products = Product::whereNull('admin_cost_id')
    //     //     ->where(function ($query) use ($settingCost) {
    //     //         $query->whereBetween('seller_price', [$settingCost->min_price, $settingCost->max_price])
    //     //               ->orWhere(function ($q) use ($settingCost) {
    //     //                   $q->whereNull('seller_price')
    //     //                     ->whereBetween('price', [$settingCost->min_price, $settingCost->max_price]);
    //     //               });
    //     //             })
    //     //     ->get();
    
    //     foreach ($products as $product) {
    //         // Jika seller_price kosong, gunakan price sebagai seller_price
    //         $effectiveSellerPrice = $product->seller_price ?? $product->price;
    
    //         $product->seller_price = $product->seller_price ?? $product->price;
    //         $product->admin_cost_id = $settingCost->id;
    //         $product->admin_cost = $settingCost->cost_value;
    //         $product->price = $effectiveSellerPrice + $settingCost->cost_value;
    
    //         $product->save();
    //     }
    // }
    
}
