<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'delivery_id',
        'status',
    ];
}
