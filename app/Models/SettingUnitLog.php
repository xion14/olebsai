<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingUnitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_unit_id' ,
        'activity',
        'note' ,
        'user_id'
    ];

}
