<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price_type',
        'price',
        'detail',
        'duration',
        'duration_info',
        'customer_id',
        'qty',
        'checked'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seller(): HasOneThrough
    {
        return $this->hasOneThrough(Seller::class, Product::class, 'id', 'id', 'product_id', 'seller_id');
    }

}
