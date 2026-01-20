<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordCodeMail;
use App\Services\VerifiedCodeService;
use App\Models\VerificationCode;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->verifiedCodeService = new VerifiedCodeService();

    }
    public function index()
    {
        return view('request-reset-password');
    }
    
    public function request_code(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user_id = $user->id;

            $checkAttempFailed = $this->verifiedCodeService->checkAttempFailed("reset_password", $user_id);

            if ($checkAttempFailed['status'] == false) {
                return response()->json([
                    'success' => false,
                    'status' => 500,
                    'text' => $checkAttempFailed['message']
                ]);
            }


            $kode = $this->verifiedCodeService->generateCode("reset_password", $user_id);
            Mail::to($request->email)->send(new ResetPasswordCodeMail($kode, $request->email , $user->name));
            return response()->json([
                'status' => 200,
                'text' => 'Kode berhasil dikirim',
                'data' => $user
            ]);
        }
    }

    public function reset_view()
    {
        return view('reset-password');
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:6',
        ]);

        $isValidCode =  VerificationCode::where('code', $request->code)
        ->where('user_id', $request->user_id)
        ->where('type', 'reset_password')
        ->latest()
        ->first();

        if ($isValidCode === false) {
            return response()->json([
                'status' => 400,
                'text' => 'Kode tidak valid',
            ]);
        }

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 200,
            'text' => 'Password berhasil direset. Silakan login dengan password baru.',
        ]);
    }

    public function verification_email($user_id)
    {
        $time_left = $this->verifiedCodeService->checkTimeLimit($user_id);

        return view('verification-code', compact('user_id', 'time_left'));
    }
}
