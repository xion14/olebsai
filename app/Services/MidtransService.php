<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

use Carbon\Carbon;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // public function createTransaction($order)
    // {
    //     $otherCosts = $order->other_cost;

    //     foreach ($otherCosts as $other_cost) {
    //         $order->total += $order->total + $other_cost->amount;
    //     }

    //     $itemDetails = $order->transactionProducts->map(function ($item) {
    //         return [
    //             'id' => $item->id,
    //             'price' => $item->price,
    //             'quantity' => $item->qty,
    //             'name' => $item->product->name,
    //         ];
    //     });
    //     $params = [
    //        'invoice_number' => $order->code,
    //        'due_date' => Carbon::now()->addHours(24)->toDateTimeString(),
    //        'invoice_date' => Carbon::now()->toDateTimeString(),
    //        'customer_details' => [
    //            'name' => $order->customer->name,
    //            'email' => $order->customer->email,
    //            'phone' => $order->customer->phone,
    //        ],
    //        'payment_type' => 'payment_link',
    //        'reference' => $order->code,
    //        'transaction_details' => [
    //             'order_id' => $order->code,
    //             'gross_amount' => $order->total
    //        ],      
    //        'item_details' => $itemDetails,  
    //        'amount' => [
    //            'total' => $order->total,
    //            'ongkir' => $order->other_cost,
               
    //        ],
    //        'notificationUrl' => 'https://yourcustomurl.com/midtrans-callback'
           
    //     ];

    //     return Snap::getSnapToken($params);
    // }

    public function createTransaction($order)
    {
        $totalOtherCosts = collect(); // Ubah jadi Collection
        $shippingCost = collect(); // Ubah jadi Collection
    
        if ($order->other_costs->isNotEmpty()) {
            $totalOtherCosts = $order->other_costs->map(function ($cost) {
                return [
                    'id' => '-',
                    'name' => $cost->name,
                    'price' => $cost->amount,
                    'quantity' => 1
                ];
            });
        }
    
        if ($order->shipping_cost > 0) {
            $shippingCost = collect([
                [
                    'id' => '-',
                    'name' => 'Shipping Cost',
                    'price' => $order->shipping_cost,
                    'quantity' => 1,
                ]
            ]);
        }
    
        // Detail item transaksi
        $itemDetails = $order->transactionProducts->map(function ($item) {
            return [
                'id' => "-",
                'price' => $item->price,
                'quantity' => $item->qty,
                'name' => $item->product->name,
            ];
        });
    
        // Menggabungkan itemDetails dan totalOtherCosts
        $itemDetails = $itemDetails->merge($totalOtherCosts)->merge($shippingCost);
    
        // Calculate gross amount
        $grossAmount = $order->transactionProducts->sum(function ($item) {
            return $item->price * $item->qty;
        }) + $totalOtherCosts->sum('price') + $shippingCost->sum('price');
    
        // Data transaksi
        $params = [
            'invoice_number' => $order->code,
            'due_date' => Carbon::now()->addHours(24)->toDateTimeString(),
            'invoice_date' => Carbon::now()->toDateTimeString(),
            'customer_details' => [
                'name' => $order->customer->name,
                'email' => $order->customer->email,
                'phone' => $order->customer->phone,
            ],
            'payment_type' => 'payment_link',
            'reference' => $order->code,
            'transaction_details' => [
                'order_id' => $order->code,
                'gross_amount' => $grossAmount, // Include the calculated total
            ],
            'item_details' => $itemDetails->toArray(),
            'notificationUrl' => 'https://yourcustomurl.com/midtrans-callback'
        ];
    
        // Return the Snap token directly if needed
        return Snap::getSnapToken($params);
    }
    
    
    
}
