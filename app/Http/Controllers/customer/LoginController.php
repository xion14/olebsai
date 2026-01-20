<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\VerifiedCodeService;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->verifiedCodeService = new VerifiedCodeService();
    }
    public function index()
    {
        if (session('customer_already_login')) {
            return redirect('/');
        }

        if (Auth::check()) {
            return redirect('/');
        }

        return view('customer.login.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Start Session
     */
    public function start_session(Request $request)
    {
        session([
            'user_id' => $request->user_id,
            'customer_id' => $request->id,
            'email_customer' => $request->email,
            'name_customer' => $request->name,
            'phone_customer' => $request->phone,
            'gender_customer' => $request->gender,
            'birthday_customer' => $request->birthday,
            'code_customer' => $request->code,
			'customer_address' => (md5(uniqid(rand(), true)).substr(md5(time()), 0, 16)),
            'customer_already_login' => true
        ]);
        return redirect('/');
    }

    /**
     * End Session
     */
    public function end_session(Request $request)
    {
        session()->flush();
        return redirect('/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login')->with('message', 'Terimakasih telah menggunakan olebsai');
    }

    public function verification_email($user_id)
    {
        $time_left = $this->verifiedCodeService->checkTimeLimit($user_id);

        return view('verification-code', compact('user_id', 'time_left'));
    }
}