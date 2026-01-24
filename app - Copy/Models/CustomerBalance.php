<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBalance extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function withdraw(){
        return $this->belongsTo(CustomerWithdraw::class);
    }

    public function customer_withdraw(){
        return $this->belongsTo(CustomerWithdraw::class, 'customer_withdraw_id');
    }
}