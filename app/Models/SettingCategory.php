<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'code',
        'image',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
