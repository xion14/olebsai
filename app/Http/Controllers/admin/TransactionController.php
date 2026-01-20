<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\log\TransactionLogController;

use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\NotificationUser;
use App\Models\NotificationSeller;
use App\Models\Product;
use App\Models\CustomerBalance;


use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::orderBy('created_at', 'desc')->where('status', '=', $request->status)->get();


        if ($request->ajax()) {
            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('seller', function ($transaction) {
                    return $transaction->transactionProducts->first()->product->seller->name;
                })
                ->addColumn('customer', function ($transaction) {
                    return $transaction->customer->name;
                })
                ->addColumn('other_cost', function ($transaction) {
                    return $transaction->other_costs->sum('amount');
                })
                ->addColumn('subtotal', function ($transaction) {
                    return $transaction->total;
                })
                ->addColumn('total', function ($transaction) {
                    return $transaction->total + $transaction->other_costs->sum('amount');
                })

                ->addColumn('status', function ($row) {
                    $statusMap = [
                        1 => [
                            'text' => 'Waiting Seller',
                            'class' => 'badge-secondary', // Abu-abu
                            'description' => 'Menunggu penjual untuk mengonfirmasi pesanan.'
                        ],
                        2 => [
                            'text' => 'Waiting Admin',
                            'class' => 'badge-warning', // Kuning
                            'description' => 'Pesanan telah dikonfirmasi oleh penjual dan menunggu persetujuan admin.'
                        ],
                        3 => [
                            'text' => 'Waiting Payment',
                            'class' => 'badge-info', // Biru Muda
                            'description' => 'Pesanan sudah disetujui, menunggu pembayaran dari pelanggan.'
                        ],
                        4 => [
                            'text' => 'Paid',
                            'class' => 'badge-teal', // Hijau Tosca
                            'description' => 'Pembayaran telah berhasil dilakukan, menunggu proses pengemasan.'
                        ],
                        5 => [
                            'text' => 'On Packing',
                            'class' => 'badge-primary', // Biru
                            'description' => 'Pembayaran telah diterima, pesanan sedang dikemas oleh penjual.'
                        ],
                        6 => [
                            'text' => 'On Delivery',
                            'class' => 'badge-warning', // Ungu
                            'description' => 'Pesanan telah dikirim dan sedang dalam perjalanan ke pelanggan.'
                        ],
                        7 => [
                            'text' => 'Received',
                            'class' => 'badge-success', // Hijau
                            'description' => 'Pesanan telah diterima oleh pelanggan.'
                        ],
                        8 => [
                            'text' => 'Cancelled',
                            'class' => 'badge-danger', // Merah
                            'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'
                        ],
                        9 => [
                    'text' => 'Expired', 
                    'class' => 'badge-danger', // Merah
                    'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'
                ],
                
            ];

                    $status = $statusMap[$row->status] ?? [
                        'text' => 'Unknown',
                        'class' => 'badge-dark', // Hitam
                        'description' => 'Status tidak dikenali, silakan hubungi admin.'
                    ];

                    $badge = '<span class="badge ' . $status['class'] . '" title="' . $status['description'] . '">' . $status['text'] . '</span>';

                    return [
                        'formatted' => '<span class="d-inline-flex align-items-center">' . $badge . '</span>',
                        'raw_status' => $row->status // Untuk logika filtering
                    ];
                })
                ->addColumn('action', function ($transaction) {
                    $ship = '';
                    
                    // On Delivery Status
                    if ($transaction->status == 6) {
                        $ship = '
                        <button class="btn btn-warning btn-sm btn-tracking" data-id="'.$transaction->id.'" data-shipping_number="'.$transaction->shipping_number.'">
                            <i class="fa fa-truck"></i>
                        </button>';
                    }

                    if ($transaction->status == 4|| $transaction->status == 5 || $transaction->status == 6 || $transaction->status == 7 ) {
                        //return
                        $ship = '
                        <button class="btn btn-warning btn-sm btn-return" data-id="'.$transaction->id.'">
                            <i class="fa fa-undo"></i>
                        </button>';
                    }
                    //     <a class="btn btn-warning btn-sm" href="' . route('admin.transactions.return', $transaction->id) . '">
                    //         <i class="fa fa-undo"></i>
                    //     </a>
                    //     ';
                    // }   


                    return $ship . '
                        <a class="btn btn-info btn-sm" href="' . route('admin.transactions.show', $transaction->id) . '">
                            <i class="fa fa-eye"></i>
                        </a>
                    ';

                })
                ->rawColumns(['customer', 'action', 'status', 'total' , 'other_cost' , 'subtotal'])
                ->make(true);
        }

        return view('admin.transaction.index');
    }

    public function show($id)
    {
        $transaction = Transaction::with([
            'transactionProducts.product',
            'customer',
            'customerAddress',
            'other_costs',
            'delivery_tracking',
            'seller',
            'voucher',
        ])->find($id);

        if (!$transaction) {
            return redirect()->route('admin.transactions')->with('error', 'Transaction not found.');
        }
        $statusMap = [
            1 => [
                'text' => 'Waiting Seller',
                'class' => 'badge-secondary', // Abu-abu
                'description' => 'Menunggu penjual untuk mengonfirmasi pesanan.'
            ],
            2 => [
                'text' => 'Waiting Admin',
                'class' => 'badge-warning', // Kuning
                'description' => 'Pesanan telah dikonfirmasi oleh penjual dan menunggu persetujuan admin.'
            ],
            3 => [
                'text' => 'Waiting Payment',
                'class' => 'badge-info', // Biru Muda
                'description' => 'Pesanan sudah disetujui, menunggu pembayaran dari pelanggan.'
            ],
            4 => [
                'text' => 'Paid',
                'class' => 'badge-teal', // Hijau Tosca
                'description' => 'Pembayaran telah berhasil dilakukan, menunggu proses pengemasan.'
            ],
            5 => [
                'text' => 'On Packing',
                'class' => 'badge-primary', // Biru
                'description' => 'Pembayaran telah diterima, pesanan sedang dikemas oleh penjual.'
            ],
            6 => [
                'text' => 'On Delivery',
                'class' => 'badge-warning', // Ungu
                'description' => 'Pesanan telah dikirim dan sedang dalam perjalanan ke pelanggan.'
            ],
            7 => [
                'text' => 'Received',
                'class' => 'badge-success', // Hijau
                'description' => 'Pesanan telah diterima oleh pelanggan.'
            ],
            8 => [
                'text' => 'Cancelled',
                'class' => 'badge-danger', // Merah
                'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'
            ],
            9 => [
                'text' => 'Expired', 
                'class' => 'badge-danger', // Merah
                'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'
            ],
        ];

        $status = $statusMap[$transaction->status] ?? [
            'text' => 'Unknown',
            'class' => 'badge-dark', // Hitam
            'description' => 'Status tidak dikenali, silakan hubungi admin.'
        ];

        $badge = '<span class="ml-3 badge ' . $status['class'] . '" title="' . $status['description'] . '">' . $status['text'] . '</span>';



        return view('admin.transaction.show', compact('transaction', 'badge'));
    }

    public function report(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::orderBy('created_at', 'desc');

        if(!empty($request->seller_id)){
            $query->where('seller_id', $request->seller_id);
        }
    
        if(!empty($request->start_date) && !empty($request->end_date)){
            $start_date = $request->start_date . ' 00:00:00';
            $end_date = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    
        if(!empty($request->status)){
            $query->where('status', $request->status);
        }
    
        $transactions = $query->get();
    
        if ($request->ajax()) {
            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('seller', function ($transaction) {
                    return $transaction->transactionProducts->first()->product->seller->name;
                })
                ->addColumn('customer', function ($transaction) {
                    return $transaction->customer->name;
                })
                ->addColumn('total', function ($transaction) {
                    return $transaction->total;
                })
                ->addColumn('transaction_product', function ($transaction) {
                    return '<ul>' . implode('', $transaction->transactionProducts->map(function ($product) {
                        return '<li>' . $product->product->name . ' (Qty: ' . $product->qty . ')</li>';
                    })->toArray()) . '</ul>';
                })
                ->addColumn('status', function ($row) {
                    $statusMap = [
                        1 => ['text' => 'Waiting Seller', 'class' => 'badge-secondary', 'description' => 'Menunggu penjual untuk mengonfirmasi pesanan.'],
                        2 => ['text' => 'Waiting Admin', 'class' => 'badge-warning', 'description' => 'Pesanan telah dikonfirmasi oleh penjual dan menunggu persetujuan admin.'],
                        3 => ['text' => 'Waiting Payment', 'class' => 'badge-info', 'description' => 'Pesanan sudah disetujui, menunggu pembayaran dari pelanggan.'],
                        4 => ['text' => 'Paid', 'class' => 'badge-teal', 'description' => 'Pembayaran telah berhasil dilakukan, menunggu proses pengemasan.'],
                        5 => ['text' => 'On Packing', 'class' => 'badge-primary', 'description' => 'Pembayaran telah diterima, pesanan sedang dikemas oleh penjual.'],
                        6 => ['text' => 'On Delivery', 'class' => 'badge-warning', 'description' => 'Pesanan telah dikirim dan sedang dalam perjalanan ke pelanggan.'],
                        7 => ['text' => 'Received', 'class' => 'badge-success', 'description' => 'Pesanan telah diterima oleh pelanggan.'],
                        8 => ['text' => 'Cancelled', 'class' => 'badge-danger', 'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'],
                        9 => ['text' => 'Expired', 'class' => 'badge-danger', 'description' => 'Pesanan dibatalkan oleh pelanggan atau sistem.'],
                    ];
                    $status = $statusMap[$row->status] ?? ['text' => 'Unknown', 'class' => 'badge-dark', 'description' => 'Status tidak dikenali, silakan hubungi admin.'];
                    $badge = '<span class="badge ' . $status['class'] . '" title="' . $status['description'] . '">' . $status['text'] . '</span>';
                    return ['formatted' => '<span class="d-inline-flex align-items-center">' . $badge . '</span>', 'raw_status' => $row->status];
                })
                ->rawColumns(['seller', 'customer', 'status', 'total', 'transaction_product'])
                ->make(true);
        }
    
        return view('admin.transaction.report');
    }


    public function confirm($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            if ($transaction->status != 2) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already confirmed',
                ]);
            }
            $transaction->status = 3;
            $transaction->save();

            $notification = new NotificationUser;
            $notification->user_id = $transaction->customer->id;
            $notification->title = 'Order Confirmed';
            $notification->content = 'Order #' . $transaction->code . ' has been confirmed by admin';
            $notification->type = 'success';
            $notification->url = '/order-history';
            $notification->save();

            $notification_seller = new NotificationSeller;
            $notification_seller->user_id = $transaction->seller->user_id;
            $notification_seller->title = 'Order Confirmed';
            $notification_seller->content = 'Order #' . $transaction->code . ' has been confirmed by admin';
            $notification_seller->type = 'success';
            $notification_seller->url = '/seller/transactions/' . $transaction->id;

            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Confirm', 'Confirmed by admin');
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success confirm transaction',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error confirm transaction',
            ]);
        }
    }



    public function reject($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            $transaction->note = $request->note;
            $transaction->status = 8;
            $transaction->save();

            foreach($transaction->transactionProducts as $transactionProduct){
                $product = Product::find($transactionProduct->product_id);
                $product->stock += $transactionProduct->quantity;
                $product->save();
            }

            $notification = new NotificationUser;
            $notification->user_id = $transaction->customer->id;
            $notification->title = 'Order Rejected';
            $notification->content = 'Order #' . $transaction->code . ' has been rejected by admin';
            $notification->type = 'danger';
            $notification->url = '/order-history';
            $notification->save();

            $notification_seller = new NotificationSeller;
            $notification_seller->user_id = $transaction->seller->user_id;
            $notification_seller->title = 'Order Rejected';
            $notification_seller->content = 'Order #' . $transaction->code . ' has been rejected by admin';
            $notification_seller->type = 'danger';
            $notification_seller->url = '/seller/transactions/' . $transaction->id;
            $notification_seller->save();
            
            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Reject', 'Rejected by admin');
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success reject transaction',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error reject transaction',
            ]);
        }
    }

    public function returnTransaction($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            $transaction->note = $request->note;
            $transaction->status = 8;
            $transaction->save();
            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Return', 'Return by admin');

            foreach($transaction->transactionProducts as $transactionProduct){
                $product = Product::find($transactionProduct->product_id);
                $product->stock += $transactionProduct->quantity;
                $product->save();
            }

            $notification = new NotificationUser;
            $notification->user_id = $transaction->customer->id;
            $notification->title = 'Order Returned';
            $notification->content = 'Order #' . $transaction->code . ' has been returned by admin';
            $notification->type = 'error';
            $notification->url = '/order-history';
            $notification->save();

            $notification_seller = new NotificationSeller;
            $notification_seller->user_id = $transaction->seller->user_id;
            $notification_seller->title = 'Order Returned';
            $notification_seller->content = 'Order #' . $transaction->code . ' has been returned by admin';
            $notification_seller->type = 'error';
            $notification_seller->url = '/seller/transactions/' . $transaction->id;
            $notification_seller->save();

            $customerBalance = new CustomerBalance;
            $customerBalance->customer_id = $transaction->customer_id;
            $customerBalance->transaction_id = $transaction->id;
            $customerBalance->customer_withdraw_id = null;
            $customerBalance->amount = $transaction->total + $transaction->other_costs->sum('amount');
            $customerBalance->type = 'in';
            $customerBalance->save();


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success return transaction',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error return transaction',
                'data' => $e
            ]);
        }
    }
}
