<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 1: // Admin
                case 2: // Admin lainnya
                    return redirect()->intended('admin/dashboard')->with('success', 'Welcome to Olebsai Admin');
                case 5: // Admin Register / SKPD
                    return redirect()->intended('admin/register/dashboard')->with('success', 'Selamat datang, Admin Register');
                case 6: // Admin User
                    return redirect()->intended('admin/user/dashboard')->with('success', 'Selamat datang, Admin User');
                case 7: // Admin Konsumen
                    return redirect()->intended('admin/consumer/dashboard')->with('success', 'Selamat datang, Admin Konsumen');
                case 4: // Seller
                    if($user->email_verified_at == null){
                        $user_id = $user->id;
                        return view('verification-code', compact('user_id'));
                    }else{
                        return redirect()->intended('seller/dashboard')->with('success', 'Welcome to Olebsai Seller');
                    }
                default: // Role lain
                    Auth::logout();
                    return redirect('/login')->with('danger', 'Silahkan Login Kembali');
            }
        }
    
        return back()->with('danger', 'E-mail atau password tidak sesuai!');
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect('/seller/login')->with('success', 'Logout Success');
    }
}
