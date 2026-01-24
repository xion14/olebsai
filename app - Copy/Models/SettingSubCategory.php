<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSubCategory extends Model
{
    use HasFactory;

    protected $table = 'setting_sub_categories';
	
	protected $fillable = [
        'setting_category_id',
        'name',
        'code',
        'image',
    ];
}
