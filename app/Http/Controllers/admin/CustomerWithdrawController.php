<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomerWithdraw;
use App\Models\CustomerBalance;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Str;


class CustomerWithdrawController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CustomerWithdraw::orderBy('id', 'DESC');

            if(!empty($request->start_date) && !empty($request->end_date)){
                $start_date = $request->start_date . ' 00:00:00';
                $end_date = $request->end_date . ' 23:59:59';
                $data = $data->whereBetween('created_at', [$start_date, $end_date]);
            }

            if(!empty($request->customer_id)){
                $data = $data->where('customer_id', $request->customer_id);
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->customer->name;
                })
                ->addColumn('amount', function ($row) {
                    return 'Rp ' . number_format($row->amount, 0, ',', '.');
                })
                ->addColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('success_at', function ($data) {
                    return $data->success_at ? Carbon::parse($data->success_at)->format('d-m-Y H:i:s') : '-';
                })
                ->addColumn('status', function($data) {
                    $el = '';

                    if($data->status == '1') {
                        $el = '<span class="badge badge-info">Waiting Admin</span>';
                    } else if ($data->status == '2') {
                        $el = '<span class="badge badge-success">Approved</span>';
                    } else if ($data->status == '3') {
                        $el = '<button type="button" class="btn-rejected badge badge-danger border-0" data-note="'.$data->note_reject.'" data-toggle="modal" data-target="#rejectNote">Rejected</button>';
                    }
                    return $el;
                })           
                ->addColumn('action', function ($data) {
                    if ($data->status == 1) {
                        return '
                            <button type="button" class="btn-reject btn btn-sm btn-danger" data-id="' . $data->id . '">
                                <i class="fas fa-ban"></i>
                            </button>
                
                            <button type="button" class="btn-accept btn btn-sm btn-success" data-id="' . $data->id . '">
                                <i class="fas fa-check"></i>
                            </button>
                        ';
                    }
                
                    if ($data->status == 2) {
                        $imageUrl = asset('/uploads/withdraw/' . $data->image);
                
                        return '
                            <button type="button" class="btn-view-images btn btn-sm btn-info" 
                                    data-image="'.$imageUrl.'">
                                <i class="fas fa-images"></i>
                            </button>
                        ';
                    }
                })
                ->rawColumns(['customer','action','amount','created_at','success_at','status'])
                ->make(true);
        }
        return view('admin.customer-withdraw.index');
    }

    public function reject(Request $request){
        try{
            DB::beginTransaction();
            $withdraw = CustomerWithdraw::where('id', $request->id)->first();
            $withdraw->note_reject = $request->note;
            $withdraw->status = 3;
            $withdraw->save();
            
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $withdraw,
                'message' => 'Withdrawal rejected'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error reject withdrawal'
            ]);
        }
    }


    
    public function accept(Request $request){
        try {
            DB::beginTransaction();
    
            // Check balance
            $auth_user = Auth::user();
            $withdraw = CustomerWithdraw::where('id', $request->id)->first();
    
            $balanceIn = CustomerBalance::where('customer_id', $withdraw->customer_id)
                                      ->where('type', 'in')
                                      ->sum('amount');
            $balanceOut = CustomerBalance::where('customer_id', $withdraw->customer_id)
                                        ->where('type', 'out')
                                        ->sum('amount');
    
            $availableBalance = $balanceIn - $balanceOut;
    
            // Check if the customer has enough balance
            if ($availableBalance < $withdraw->amount) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Insufficient balance'], 400);
            }
    
            // Handle file upload
            $uniqueFilename = null;
            if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
                $file = $request->file('proof');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                
                // Remove spaces and create a unique filename
                $safeFilename = Str::slug($filename, '_');
                $uniqueFilename = $safeFilename . '_' . time() . '.' . $extension;
    
                // Save the file
                $file->move(public_path('uploads/withdraw'), $uniqueFilename);
            }
    
            // Update withdrawal record
            $withdraw->success_at = Carbon::now();
            $withdraw->approval_by = $auth_user->id;
            $withdraw->image = $uniqueFilename; 
            $withdraw->status = 2;
            $withdraw->save();
    
            // Update balance
            $balanceIn = new CustomerBalance();
            $balanceIn->customer_withdraw_id = $withdraw->id;
            $balanceIn->customer_id = $withdraw->customer_id;
            $balanceIn->amount = $withdraw->amount;
            $balanceIn->type = 'out';
            $balanceIn->save();
    
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $withdraw,
                'message' => 'Withdrawal accepted'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    

}
