<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryTracking;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
            'status' => 'required',
            'note' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $data = DeliveryTracking::create($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Data has been saved successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
