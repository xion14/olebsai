<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'percentage',
        'max_discount',
        'minimum_transaction',
        'quota',
        'start_date',
        'expired_date',
        'status',
        'user_created',
    ];
}
