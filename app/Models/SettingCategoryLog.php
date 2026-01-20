<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCategoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_category_id' ,
        'activity',
        'note' ,
        'user_id' ,
    ];
}
