<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CustomerAddress;

class CustomerAddressController extends Controller
{

    public  function index(Request $request)
    {
        try {
            $CustomerAddress = CustomerAddress::where('customer_id', $request->customer_id)->orderBy('active', 'asc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
	
	public function active(Request $request)
    {
        try {
            $CustomerAddress = CustomerAddress::where('customer_id', $request->customer_id)->where('active', 'yes')->get();
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'customer_id'   => 'required',
                'name'          => 'required',
                'phone'         => 'required',
                'road'          => 'required',
                'city'          => 'required',
                'province'      => 'required',
                'zip_code'      => 'required',
                'address'       => 'required',
				'active'		=> 'required',
            ]);
			
			if($request->active=='yes') {
				CustomerAddress::where('active', 'yes')->update(['active' => 'no']);
			}

            $CustomerAddress = CustomerAddress::create([
                'customer_id'   => $request->customer_id,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'road'          => $request->road_text,
				'district_id'   => $request->road,
                'city'          => $request->city_text,
				'city_id'       => $request->city,
                'province'      => $request->province_text,
				'province_id'   => $request->province,
                'zip_code'      => $request->zip_code,
                'address'       => $request->address,
				'active'       	=> $request->active
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'customer_id'   => 'required',
                'name'          => 'required',
                'phone'         => 'required',
                'road'          => 'required',
                'city'          => 'required',
                'province'      => 'required',
                'zip_code'      => 'required',
                'address'       => 'required',
				'active'		=> 'required'
            ]);
			
			if($request->active=='yes') {
				CustomerAddress::where('active', 'yes')->update(['active' => 'no']);
			}

            $CustomerAddress = CustomerAddress::findOrFail($id);
            $CustomerAddress->update([
                'customer_id'   => $request->customer_id,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'road'          => $request->road_text,
				'district_id'   => $request->road,
                'city'          => $request->city_text,
				'city_id'       => $request->city,
                'province'      => $request->province_text,
				'province_id'   => $request->province,
                'zip_code'      => $request->zip_code,
                'address'       => $request->address,
				'active'       	=> $request->active
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $CustomerAddress = CustomerAddress::findOrFail($id);
            $CustomerAddress->delete();
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $CustomerAddress
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
