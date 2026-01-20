<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Seller;
use App\Models\User;
use App\Models\NotificationAdmin;


use Carbon\Carbon;
use App\Mail\AccountVerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use App\Services\VerifiedCodeService;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->verifiedCodeService = new VerifiedCodeService();
    }


    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'tax_number' => 'required',
                'business_number' => 'required',
                'phone' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
                'address' => 'required'
            ],
        );

        // save
        DB::beginTransaction();
        try {
            // Seller
            $seller = new Seller();
            $seller->name = $validated['name'];
            $seller->username = $validated['username'];
            $seller->email = $validated['email'];
            $seller->tax_number = $validated['tax_number'];
            $seller->business_number = $validated['business_number'];
            $seller->phone = $validated['phone'];
            $seller->address = $validated['address'];
            $seller->city = $validated['city'];
            $seller->province = $validated['province'];
            $seller->country = $validated['country'];
            $seller->zip = $validated['zip_code'];
            $seller->save();
            // User
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $user->role = 4;
            $user->save();
            // userid
            $seller->update(['user_id' => $user->id]);

            $notif = new NotificationAdmin;
            $notif->title = 'Registration Seller';
            $notif->content = 'Seller ' . $seller->name . ' has been registered';
            $notif->type = 'info';
            $notif->url = '/admin/sellers/confirmation/';
            $notif->save();
            $kode = $this->verifiedCodeService->generateCode("register", $user->id);

            Mail::to($user->email)->send(new AccountVerificationCodeMail($kode , $user->email , $user->name));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Pendaftaran berhasil, silahkan login']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
