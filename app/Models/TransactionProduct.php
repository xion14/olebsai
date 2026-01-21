<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'transaction_id',
        'product_id',
        'cart_product_type_id',
        'variant',
        'seller_price',
        'admin_cost',
        'price',
        'qty',
        'total'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): HasOneThrough
    {
        return $this->hasOneThrough(Seller::class, Product::class, 'id', 'id', 'product_id', 'seller_id');
    }
}
