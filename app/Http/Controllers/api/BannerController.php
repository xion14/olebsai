<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index () {
        $banner = Banner::first()->image ?? null;

        return response()->json([
            'success'   => true,
            'data'      => $banner,
            'message'   => 'Success get banner'
        ]);
    }
}
