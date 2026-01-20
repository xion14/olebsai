<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingInformationBar;

class InformationBarController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => SettingInformationBar::first(),
            'message' => 'Information bar retrieved successfully.'
        ]);
    }
}
