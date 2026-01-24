<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBanner extends Model
{
    use HasFactory;

    protected $fillable = [
    'seller_id',
    'title',
    'image',
    'subtitle',
    'link',
    'description',
    'status'
    ];
}
