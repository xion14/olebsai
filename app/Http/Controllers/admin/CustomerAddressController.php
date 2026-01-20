<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomerAddress;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;


class CustomerAddressController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $CustomerAddress = CustomerAddress::where('customer_id', $request->customer_id)->get();
    
            return DataTables::of($CustomerAddress)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <button type="button" class="btn btn-warning btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editAddressModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('admin.customers.addresses.index'); // Pastikan ada file Blade untuk tampilan
    }
    

    public function show ($id){
        try {
            $CustomerAddress = CustomerAddress::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    public function update(Request $request){
        if($request->ajax()){
                try{
                    DB::beginTransaction();
                    $request->validate([
                        'id'            => 'required',
                        'name'          => 'required',
                        'phone'         => 'required',
                        'road'          => 'required',
                        'city'          => 'required',
                        'province'      => 'required',
                        'zip_code'      => 'required',
                        'address'       => 'required'
                    ]);
        
                    $CustomerAddress = CustomerAddress::findOrFail($request->id);
                    $CustomerAddress->update([
                        'name'          => $request->name,
                        'phone'         => $request->phone,
                        'road'          => $request->road,
                        'city'          => $request->city,
                        'province'      => $request->province,
                        'zip_code'      => $request->zip_code,
                        'address'       => $request->address
                    ]);
        
                    DB::commit();   
        
                    return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
                }catch(\Exception $e){
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
            }

        }

    public function destroy(Request $request){
        if($request->ajax()){
            try{
                DB::beginTransaction();
                $CustomerAddress = CustomerAddress::findOrFail($request->id);
                $CustomerAddress->delete();
                DB::commit();
                return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus', 'success' => true]);
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
       
    }
}

