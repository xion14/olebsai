<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SellerWithdraw;
use App\Models\SellerBalance;
use App\Models\NotificationAdmin;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SellerWithdraw::where('seller_id', Auth::user()->seller->id)->orderBy('id', 'DESC');

            if(!empty($request->start_date) && !empty($request->end_date)){
                $start_date = $request->start_date . ' 00:00:00';
                $end_date = $request->end_date . ' 23:59:59';
                $data = $data->whereBetween('created_at', [$start_date, $end_date]);
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
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
                        $el = '<span class="badge badge-warning">Canceled</span>';
                    } else if ($data->status == '3') {
                        $el = '<span class="badge badge-warning">Canceled</span>';
                    } else if ($data->status == '4') {
                        $el = '<button type="button" class="btn-rejected badge badge-danger border-0" data-note="'.$data->note_reject.'" data-toggle="modal" data-target="#rejectNote">Rejected</button>';
                    }
                    return $el;
                })            
                ->addColumn('action', function ($data) {
                    if ($data->status == 1) {
                        $el = '
                            <button type="button" class="btn-cancel btn btn-sm btn-danger" data-id="' . $data->id . '">
                                <i class="fas fa-ban"></i>
                            </button>
                        ';
                        return $el;
                    }

                    if ($data->status == 2) {
                        // Pastikan `$data->images` aman untuk digunakan di atribut HTML
                        $imageUrl = asset('/uploads/withdraw/' . $data->image);
                
                        return '
                            <button type="button" class="btn-view-images btn btn-sm btn-info" 
                                    data-image="'.$imageUrl.'">
                                <i class="fas fa-images"></i>
                            </button>
                        ';
                    }
                })
                ->rawColumns(['action','amount','created_at','success_at','status'])
                ->make(true);
        }
        return view('seller.withdraw.index');
    }

    public function store (Request $request)
    {
        try{
            DB::beginTransaction();
            $amount = $request->amount;
            $note = $request->note;
            $seller = Auth::user()->seller;
            $balanceIn = SellerBalance::where('seller_id', $seller->id)->where('type', 'in')->sum('amount');
            $balanceOut = SellerBalance::where('seller_id', $seller->id)->where('type', 'out')->sum('amount');
            $balance = $balanceIn - $balanceOut;
            
            if($balance < $amount){
                DB::rollBack();
                return response()->json(['success' => false,'status' => 'error', 'message' => 'Insufficient balance'], 400);
            }

            $last_id = @SellerWithdraw::latest('id')->first()->id  ?? 0;
            $code = "WD" . date("YmdHi") . str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT) . $last_id + 1;

            $withdraw = new SellerWithdraw();
            $withdraw->code = $code;
            $withdraw->note = $note;
            $withdraw->seller_id = $seller->id;
            $withdraw->amount = $request->amount;
            $withdraw->save();

            $notif = new NotificationAdmin;
            $notif->title = 'Withdrawal Request';
            $notif->content = 'Withdrawal request from seller ' . $seller->name . ' with amount Rp ' . number_format($request->amount, 0, ',', '.');
            $notif->type = 'info';
            $notif->url = '/admin/withdraw';
            $notif->save();            

            DB::commit();
            return response()->json([
            'success' => true,
            'data' => $withdraw,
            'status' => 'success', 
            'message' => 'Withdrawal successful']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Error withdraw','success' => false,'status' => 'error']);
        }
    }

    public function cancel (Request $request)
    {
        try{
            $withdraw = SellerWithdraw::where('status', '1')->where('id', $request->id)->first();
            $withdraw->status = 3;
            $withdraw->save();

            $notif = new NotificationAdmin;
            $notif->title = 'Withdrawal Cancel';
            $notif->content = 'Withdrawal Cancel from seller ' . $withdraw->seller->name . ' with amount Rp ' . number_format($withdraw->amount, 0, ',', '.');
            $notif->type = 'danger';
            $notif->url = '/admin/withdraw';
            $notif->save();  

            return response()->json(['success' => true,'status' => 'success', 'message' => 'Withdrawal canceled']);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error cancel withdrawal','success' => false,'status' => 'error'], 400);
        }
    }

    public function checkBalance(Request $request)
    {
        try{
            $seller = Auth::user()->seller;

            if($seller->bank_name == null){
                return response()->json([
                'success' => false,
                'message' => 'Bank name is empty',
                'status' => 'error'
                ], 400);
            }

            $balanceIn = SellerBalance::where('seller_id', $seller->id)->where('type', 'in')->sum('amount');
            $balanceOut = SellerBalance::where('seller_id', $seller->id)->where('type','out')->sum('amount');
            $balance = $balanceIn - $balanceOut;
            
            return response()->json(['success' => true,'message' => 'Balance checked','status' => 'success', 'balance' => $balance]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error check balance','success' => false,'status' => 'error']);
        }
    }
    
    
        
        
}
