<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'birthday',
        'gender',
        'user_id',
        'address_status',
        'status',
        'wallet',
        'image_user_profile',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_code'
    ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fileDownload(): Attribute
    {
        return Attribute::make(
            get: fn($image_user_profile) => url('/storage/customer/' . $image_user_profile),
        );
    }
}