<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAboutUs extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'title', 'subtitle', 'image', 'is_deleteable'];
    public $timestamps = true;
}
