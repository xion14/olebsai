<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use App\Models\Seller;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class SellerController extends Controller
{   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Seller::where('status', 4);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('location', content: function ($row) {
                    return '
                        <span>' . $row->address . ', Kota ' . $row->city . ', Provinsi ' . $row->province . ', ' . $row->country . ' (' . $row->zip . ')</span>
                    ';
                })
                ->addColumn('action', content: function ($row) {
                    return '
                    <form id="delete-form' . $row->id . '" action="' . route('admin.sellers.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a class="btn-edit btn btn-sm btn-warning" data-id="' . $row->id . '">  
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" alt="Reset Password" class="btn-reset-password btn btn-sm btn-primary" data-id="' . $row->id . '">
                            <i class="fas fa-key"></i> 
                        </button>
                    </form>
                    ';
                })
                ->rawColumns(['location', 'action'])
                ->make(true);
        }
        return view('admin.seller.index');
    }
    

    public function confirmationSeller(Request $request){
        if ($request->ajax()) {
            $data = Seller::where('status',1);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('location',content: function ($row){
                    $el = '
                        <span>' . $row->address . ',Kota '. $row->city . ',Provinsi '.$row->province.','.$row->country.'.('.$row->zip.')</span>
                    ';
                    return $el;
                })
                ->addColumn('action', content: function ($row) {
                    
                    $btn = '
                    <button class="btn-reject btn btn-sm btn-danger" data-id="'.$row->id.'"> <i class="fas fa-times"></i></button>
                    <button class="btn-accept btn btn-sm btn-success" data-id="'.$row->id.'"> <i class="fas fa-check"></i></button>
                    ';
                    return $btn;
                })
                ->rawColumns(['location','action'])
                ->make(true);
        }
        return view('admin.seller.confirmation');
    }

    public function failedSeller(Request $request){
        if ($request->ajax()) {
            $data = Seller::where('status',3);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('location',content: function ($row){
                    $el = '
                        <span>' . $row->address . ',Kota '. $row->city . ',Provinsi '.$row->province.','.$row->country.'.('.$row->zip.')</span>
                    ';
                    return $el;
                })
                ->rawColumns(['location'])
                ->make(true);
        }
        return view('admin.seller.failed');
    }

    public function acceptSeller(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);

                $seller->update(['status' => 4]);

                DB::commit();
                return response()->json(['status' => 200, 'text' => 'Seller Diterima']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            }
           
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
     
    }

    public function rejectSeller(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);
                $seller->status = 3;
                if($request->note){
                    $seller->note = $request->note;
                }
                $seller->save();

                

                DB::commit();
    
                return response()->json(['status' => 200, 'text' => 'Seller Ditolak']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            } 
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
      
    }

    public function resetPassword(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $seller = Seller::findOrFail($id);
                $password = $request->password;
                if ($seller->user) {
                    $seller->user->password = Hash::make($password);
                    $seller->user->save(); // Harus save ke model User, bukan Seller
                }
                
                
                DB::commit();

                //send email
                Mail::to($seller->email)->send(new ResetPasswordMail($password , $seller->name));

                // $redirect_url = 'https://api.whatsapp.com/send?phone=62'.$seller->phone.'&text=' . urlencode(
                //     "Halo, {$seller->name}.\n\n".
                //     "Permintaan reset password Anda telah disetujui. Berikut adalah password baru Anda:\n\n".
                //     "*{$password}*\n\n".
                //     "Silakan segera mengganti password ini demi keamanan akun Anda.\n\n".
                //     "Terima kasih.\nSalam,\nAdmin Olebsai"
                // );
                return response()->json(['status' => 200, 'text' => 'Password Berhasil Direset']);
            }
            else{
                return redirect()->back()->withError('Forbidden');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }


    public function getSeller(Request $request){
        $data = Seller::where('status', 4)->get();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di ambil', 'data' => $data]);
    }
       
}
