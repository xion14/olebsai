<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'code',
        'name',
        'type_id',
        'sub_category_id',
        'category_id',
        'unit_id',
        'stock',
        'seller_price',
        'admin_cost',
        'admin_cost_id',
        'price',
        'slug',
        'description',
        'note',
        'digitals',
        'subtimes',
        'file_1',
        'file_2',
        'file_3',
        'file_4',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'status',
        'weight'
    ];

    public function type()
    {
        return $this->belongsTo(SettingType::class, 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(SettingCategory::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(SettingUnit::class, 'unit_id');
    }

    public function logs(){
        return $this->hasMany(ProductLog::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    
}
