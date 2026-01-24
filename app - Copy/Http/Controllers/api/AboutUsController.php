<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingAboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        $data = SettingAboutUs::all();
        return response()->json([
            'success' => 'success',
            'data' => $data,
            'message' => 'Data retrieved successfully'
        ]);
    }
}
