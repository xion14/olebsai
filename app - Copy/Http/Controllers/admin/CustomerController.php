<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;
use App\Models\Customer;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;


class CustomerController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Customer::where('status', 1);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('action', content: function ($row) {
                    return '
                    <form id="delete-form' . $row->id . '" action="' . route('admin.customers.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a class="btn-edit btn btn-sm btn-warning" data-id="' . $row->id . '">  
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" class="btn-disable btn btn-sm btn-danger" data-id="' . $row->id . '">
                            <i class="fas fa-ban"></i>
                        </button>
                         <button type="button" alt="Reset Password" class="btn-reset-password btn btn-sm btn-primary" data-id="' . $row->id . '">
                            <i class="fas fa-key"></i> 
                        </button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.customer.index');
    }

    public function disabled(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::where('status', 9);
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('action', content: function ($row) {
                    return '
                    <form id="delete-form' . $row->id . '" action="' . route('admin.customers.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a class="btn-edit btn btn-sm btn-warning" data-id="' . $row->id . '">  
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" class="btn-active btn btn-sm btn-success" data-id="' . $row->id . '">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.customer.disabled');
    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.show', compact('customer'));
    }


    public function enable(string $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($id);
            $customer->update([
                'status' => 1,
            ]);
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Customer berhasil di aktifkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function disable(string $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($id);
            $customer->update([
                'status' => 9,
            ]);
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Customer berhasil di nonaktifkan']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function resetPassword(Request $request,string $id){
        try{
            DB::beginTransaction();
            if($request->ajax()){
                $customer = Customer::findOrFail($id);
                // $password = Str::random(8);
                $password = $request->password;
                if ($customer->user) {
                    $customer->user->password = Hash::make($password);
                    $customer->user->save(); // Harus save ke model User, bukan customer
                }
                
                //send email
                try{
                    Mail::to($customer->email)->send(new ResetPasswordMail($password , $customer->name));
                    DB::commit();
                    return response()->json(['status' => 200, 'text' => 'Password Berhasil Direset']);
                }catch(\Exception $e){
                    DB::rollBack();
                    return response()->json(['status' => 400, 'text' => $e->getMessage()]);
                }             
            }
            else{
                return redirect()->back()->withError('Forbidden');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $e->getMessage()]);
        }
    }

    public function getCustomer(Request $request){
        $data = Customer::where('status', 1)->get();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di ambil', 'data' => $data]);
    }
}