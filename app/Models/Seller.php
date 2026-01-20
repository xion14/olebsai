<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'tax_number',
        'bussiness_number',
        'phone',
        'address',
        'city',
        'province',
        'country',
        'zip',
        'user_id',
        'note',
        'status',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_code'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
