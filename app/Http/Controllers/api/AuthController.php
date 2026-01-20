<?php

namespace App\Http\Controllers\api;

use App\Mail\AccountVerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Services\VerifiedCodeService;
use Carbon\Carbon;

use Log;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->verifiedCodeService = new VerifiedCodeService();
    }



    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'text' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if (!$user->customer) {
                    return response()->json([
                        'status' => 403,
                        'text' => 'Akun tidak memiliki data pelanggan'
                    ], 403);
                }

                if ($user->customer->status == 9) {
                    return response()->json([
                        'status' => 403,
                        'text' => 'Akun anda telah dinonaktifkan'
                    ], 403);
                }

                if ($user->email_verified_at == null) {
                    return response()->json([
                        'status' => 403,
                        'data' => $user,
                        'text' => 'Akun anda belum diverifikasi'
                    ]);
                }

				// // // // // session([
					
					// // // // // 'customer_id' => $user->customer->id,
					
				// // // // // ]);
				
				// // // // // $request->session()->put('logincode', '33333');
				// // // // // Log::info('$request->session()->put666666');
				
                return response()->json([
                    'status' => 200,
                    'text' => 'Login berhasil',
                    'data' => $user->customer
                ], 200);
            }

            return response()->json([
                'status' => 401,
                'text' => 'E-mail atau password tidak sesuai!'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'text' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => 200, 'text' => 'Logout Success']);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 3,
            ]);

            $customer = Customer::create([
                'code' => uniqid(),
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'status' => 1
            ]);

            $kode = $this->verifiedCodeService->generateCode("register", $user->id);

            Mail::to($user->email)->send(new AccountVerificationCodeMail($kode, $user->email, $user->name));

            DB::commit();

            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan', 'data' => $customer]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'text' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($id);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'wallet' => $request->wallet,
            ]);
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah', 'data' => $customer]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            if (!$customer) {
                return response()->json(['status' => 404, 'text' => 'Data tidak ditemukan']);
            }

            return response()->json(['status' => 200, 'text' => 'Data berhasil di ambil', 'data' => $customer]);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function validate_code(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required',
                'user_id' => 'required',
                'type' => 'required',
            ]);

            $isValidCode = $this->verifiedCodeService->checkCode($validated['type'], $validated['code'], $validated['user_id']);

            if ($isValidCode === true) {
                $user = User::find($validated['user_id']);
                if ($user) {
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }

                if ($validated['type'] == "register") {
                    return response()->json([
                        'status' => 200,
                        'data' => $user->customer,
                        'role' => $user->role
                    ], 200);
                }

                return response()->json([
                    'status' => 200,
                    'text' => 'Email berhasil diverifikasi',
                    'data' => $user
                ]);
            }

            return response()->json([
                'status' => 400,
                'text' => 'Kode tidak valid atau telah kedaluwarsa atau telah digunakan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'text' => $e->getMessage()
            ]);
        }
    }

    public function resend_code(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required',
                'type' => 'required',
            ]);

            $checkAttempFailed = $this->verifiedCodeService->checkAttempFailed($validated['type'], $validated['user_id']);

            if ($checkAttempFailed['status'] == false) {
                return response()->json([
                    'status' => 500,
                    'text' => $checkAttempFailed['message']
                ]);
            }

            $kode = $this->verifiedCodeService->generateCode($validated['type'], $validated['user_id']);

            Mail::to(User::find($validated['user_id'])->email)->send(new AccountVerificationCodeMail($kode, User::find($validated['user_id'])->email, User::find($validated['user_id'])->name));

            return response()->json([
                'status' => 200,
                'text' => 'Kode berhasil dikirim ulang'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'text' => $e->getMessage()
            ]);
        }
    }

    public function update_image_profile(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($id);

            if ($request->hasFile('image_user_profile')) {
                $imageProfile = $request->file('image_user_profile');
                $imageName = $imageProfile->hashName();

                // hapus data yang lama
                if ($customer->image_user_profile) {
                    $oldImagePath = public_path('uploads/customer/' . basename($customer->image_user_profile));
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }

                $imageProfile->move(public_path('uploads/customer'), $imageName);
                $customer->image_user_profile = $imageName;
            }

            $customer->save();
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Image profile berhasil diubah', 'data' => $customer]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function add_bank_account(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'status' => 500,
                    'text' => 'Customer not found'
                ]);
            }

            $customer->update([
                'bank_name' => $request->bank_name,
                'bank_account_name' => $request->bank_account_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_code' => $request->bank_code
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'status' => 200,
                'text' => 'Bank account berhasil di tambahkan',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'status' => 400,
                'text' => $e->getMessage()
            ]);
        }
    }
}