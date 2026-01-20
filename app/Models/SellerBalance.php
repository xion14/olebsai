<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBalance extends Model
{
    use HasFactory;

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function withdraw(){
        return $this->belongsTo(SellerWithdraw::class);
    }
}
