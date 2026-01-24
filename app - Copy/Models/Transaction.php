<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'customer_address_id',
        'voucher_id',
        'code',
		'subtotal',
        'other_cost',
        'shipping_information',
		'shipping_cost',
		'shipping_name',
        'shipping_description',
        'shipping_etd',
        'shipping_received',
        'total',
        'status',
        'note',
    ];

    public function products()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function other_costs()
    {
        return $this->hasMany(OtherCost::class, 'transaction_id');
    }

    public function delivery_tracking()
    {
        return $this->HasMany(DeliveryTracking::class);
    }

    public function voucher()
    {
        return $this->BelongsTo(Voucher::class);
    }
}
