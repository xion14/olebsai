<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SellerWithdraw;
use App\Models\SellerBalance;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Str;


class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SellerWithdraw::orderBy('id', 'DESC');

            if(!empty($request->start_date) && !empty($request->end_date)){
                $start_date = $request->start_date . ' 00:00:00';
                $end_date = $request->end_date . ' 23:59:59';
                $data = $data->whereBetween('created_at', [$start_date, $end_date]);
            }

            if(!empty($request->seller_id)){
                $data = $data->where('seller_id', $request->seller_id);
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('seller', function ($row) {
                    return $row->seller->name;
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
                    } else if ($data->status == '3'){
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
                ->rawColumns(['seller','action','amount','created_at','success_at','status'])
                ->make(true);
        }
        return view('admin.withdraw.index');
    }

    public function reject(Request $request){
        try{
            DB::beginTransaction();
            $withdraw = SellerWithdraw::where('id', $request->id)->first();
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
            $withdraw = SellerWithdraw::where('id', $request->id)->first();
    
            $balanceIn = SellerBalance::where('seller_id', $withdraw->seller_id)
                                      ->where('type', 'in')
                                      ->sum('amount');
            $balanceOut = SellerBalance::where('seller_id', $withdraw->seller_id)
                                        ->where('type', 'out')
                                        ->sum('amount');
    
            $availableBalance = $balanceIn - $balanceOut;
    
            // Check if the seller has enough balance
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
            $NewBalanceOut = new SellerBalance();
            $NewBalanceOut->withdraw_id = $withdraw->id;
            $NewBalanceOut->seller_id = $withdraw->seller_id;
            $NewBalanceOut->amount = $withdraw->amount;
            $NewBalanceOut->type = 'out';
            $NewBalanceOut->save();
    
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
