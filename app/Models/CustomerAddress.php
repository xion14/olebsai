<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'road',
        'city',
        'province',
        'zip_code',
        'address',
		'province_id',
		'city_id',
		'district_id',
        'active'
    ];
}
