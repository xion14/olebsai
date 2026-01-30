<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Seller;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $seller = Seller::where('user_id',Auth::id())->first();

        return view('seller.profile.index',compact('seller'));
    }

  
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'tax_number' => 'required',
                'business_number' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'password' => 'nullable',
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
            $seller = Seller::findOrFail($id);
            $seller->name = $validated['name'];
            $seller->email = $validated['email'];
            $seller->tax_number = $validated['tax_number'];
            $seller->business_number = $validated['business_number'];
            $seller->phone = $validated['phone'];
            $seller->address = $validated['address'];
            $seller->city = $validated['city'];
            $seller->province = $validated['province'];
            $seller->country = $validated['country'];
            $seller->zip = $validated['zip_code'];
            $seller->status = 1;
            $seller->note = NULl;
            $seller->save();

            $user = User::findOrFail($seller->user_id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if($validated['password'])
            {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ]);
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth::id());

            // Verifikasi password lama
            if (!Hash::check($validated['oldPassword'], $user->password)) {
                return response()->json(['status' => 400, 'text' => 'Password lama salah'], 400);
            }
    
            // Update password baru
            $user->password = Hash::make($validated['newPassword']);
            $user->save();
    
            DB::commit();
    
            return response()->json(['status' => 200, 'text' => 'Password berhasil diubah']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'error' => $th->getMessage()]);
        }
    }


    public function addBankAccount(Request $request)
    {
        try{
            DB::BeginTransaction();

            $validated = $request->validate([
                'bank_name' => 'required',
                'bank_account_name' => 'required',
                'bank_account_number' => 'required',
            ]);
            
            $seller = Auth::user()->seller;

            $seller->bank_name = $validated['bank_name'];
            $seller->bank_account_name = $validated['bank_account_name'];
            $seller->bank_account_number = $validated['bank_account_number'];
            $seller->save();

            DB::commit();

            return response()->json(['success' => true,
            'status' => 200, 'text' => 'Data bank berhasil di tambahkan']);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json(['success' => false,
            'status' => 400, 'text' => $th->getMessage()]);
        }
    }

}
