<?php

namespace App\Services;

use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerifiedCodeService
{
    public function __construct()
    {
        $this->code = new VerificationCode();
    }

    public function generateCode($type, $user_id)
    {
        $code = rand(100000, 999999);
        $this->code->type = $type;
        $this->code->code = $code;
        $this->code->expired_at = Carbon::now()->addMinutes(5);
        $this->code->user_id = $user_id;
        $this->code->status = 0;
        $this->code->save();        
        return $code;
    }

    public function checkCode($type , $code, $user_id)
    {
        try{
            DB::beginTransaction();
            $verifiedCode = VerificationCode::where('code', $code)
            ->where('user_id', $user_id)
            ->where('type', $type)
            ->latest()
            ->first();

        if ($verifiedCode) {

            if ($verifiedCode->status == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kode verifikasi telah digunakan.'
                ]);
            }
            
            if ($verifiedCode->expired_at < Carbon::now()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kode verifikasi telah kedaluwarsa.'
                ]);
            }

            $verifiedCode->status = 1;
            $verifiedCode->save();

            DB::commit();
            return true;
        }else{
            
            $lastCode = VerificationCode::where('user_id', $user_id)
            ->where('type', $type)
            ->latest()
            ->first();

            $lastCode->is_false = true;
            $lastCode->save();

            DB::commit();
            return response()->json([
                'status' => false,
                'message' => 'Kode verifikasi tidak valid.'
            ]);
        }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function checkAttempFailed($type, $user_id)
    {
        $now = now();
    
        // Ambil verifikasi terakhir yang berhasil
        $lastSuccess = VerificationCode::where('user_id', $user_id)
            ->where('type', $type)
            ->where('is_false', false)
            ->orderBy('created_at', 'desc')
            ->first();
    
        // Ambil semua percobaan gagal setelah berhasil terakhir
        $failedAttemptsQuery = VerificationCode::where('user_id', $user_id)
            ->where('type', $type)
            ->where('is_false', true);
    
        if ($lastSuccess) {
            $failedAttemptsQuery->where('created_at', '>', $lastSuccess->created_at);
        }
    
        $failedAttempts = $failedAttemptsQuery->orderBy('created_at', 'asc')->get();
        $count = $failedAttempts->count();
    
        if ($count >= 3) {
            $thirdAttempt = $failedAttempts[2]; // Percobaan ke-3
            $afterThird = $failedAttempts->slice(3); // Semua setelah ke-3
    
            // Cek apakah waktu sekarang masih dalam limit 30 menit setelah percobaan ke-3
            if ($now->lessThan($thirdAttempt->created_at->addMinutes(30))) {
                return [
                    'status' => false,
                    'message' => 'Terlalu banyak percobaan gagal. Coba lagi setelah 30 menit.',
                    'retry_at' => $thirdAttempt->created_at->addMinutes(30),
                ];
            }
    
            // Kalau sudah lewat 30 menit tapi masih ada percobaan salah lagi → kena 12 jam
            if ($afterThird->count() > 0) {
                $latestFail = $afterThird->last();
                $limit = $latestFail->created_at->addHours(12);
    
                if ($now->lessThan($limit)) {
                    return [
                        'status' => false,
                        'message' => 'Terlalu banyak percobaan gagal. Coba lagi setelah 12 jam.',
                        'retry_at' => $limit,
                    ];
                }
            }
        }
    
        return ['status' => true]; // Masih boleh lanjut
    }
    


    public function checkTimeLimit($user_id)
    {
        $verifiedCode = VerificationCode::where('user_id', $user_id)
            ->where('type', 'register')
            ->where('expired_at', '>=', Carbon::now())
            ->latest() 
            ->first();
    
        if ($verifiedCode) {
            $now = Carbon::now();
            $diffInSeconds = $now->diffInSeconds(Carbon::parse($verifiedCode->expired_at), false);
            return $diffInSeconds;
        }
    
        return 0;
    }
    
    
}