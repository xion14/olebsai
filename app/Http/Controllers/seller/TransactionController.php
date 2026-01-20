<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Http\Controllers\log\TransactionLogController;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\DeliveryTracking;
use App\Models\NotificationAdmin;
use App\Models\NotificationUser;
use App\Models\Voucher;
use Carbon\Carbon;
use App\Models\Product;
use Log;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
		Log::info('wewewewewewe');
        $user = Auth::user();
        $transactions = Transaction::orderBy('created_at', 'desc')->where('status', '=', $request->status)
            ->where('seller_id', '=', $user->seller->id)->get();


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

                    return $ship . '
                        <a class="btn btn-info btn-sm" href="' . route('seller.transactions.show', $transaction->id) . '">
                            <i class="fa fa-eye"></i>
                        </a>
                    ';
                })
                ->rawColumns(['customer', 'action', 'status', 'total' , 'other_cost', 'subtotal'])
                ->make(true);
        }

        return view('seller.transaction.index');
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
            return redirect()->route('seller.transactions')->with('error', 'Transaction not found.');
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



        return view('seller.transaction.show', compact('transaction', 'badge'));
        // dd($transaction->transactionProducts);
    }

    public function report(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::orderBy('created_at', 'desc');
    
        if(!empty($request->start_date) && !empty($request->end_date)){
            $start_date = $request->start_date . ' 00:00:00';
            $end_date = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    
        if(!empty($request->status)){
            $query->where('status', $request->status);
        }
    
        $transactions = $query->where('seller_id', '=', $user->seller->id)->get();
    
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
                ->rawColumns(['customer', 'status', 'total', 'transaction_product'])
                ->make(true);
        }
    
        return view('seller.transaction.report');
    }
    
    public function confirm($id, Request $request){
        try {
           
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status != 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already confirmed',
                ]);
            }

            $shippingCost = $request->shipping_cost;
            $discountShippingCost = 0;
    
            // Cek apakah ada voucher
            if (!empty($transaction->voucher_id) && $transaction->voucher->type == 2) {
                $discountShippingCost = $shippingCost * $transaction->voucher->percentage / 100;
                if ($discountShippingCost > $transaction->voucher->max_discount) {
                    $discountShippingCost = $transaction->voucher->max_discount;
                }

    
                // $calculatedDiscount = $transaction->total * $voucher->value / 100;
        
                // $maxDiscount = $voucher->max_discount ?? $calculatedDiscount;
        
                // OtherCost::create([
                //     'transaction_id' => $transaction->id,
                //     'amount' => "-".$maxDiscount,
                //     'name' => $voucher->name,
                // ]);
                    
                
            }
    
            $transaction->shipping_cost = $shippingCost;
            $transaction->shipping_name = $request->shipping_name;
            $transaction->total = $transaction->subtotal + $transaction->other_cost + $shippingCost - $discountShippingCost;
            $transaction->status = 2;
            $transaction->update();

            $notif = new NotificationAdmin;
            $notif->title = 'Order Confirmation';
            $notif->content = 'Order #' . $transaction->code . ' has been confirmed by seller';
            $notif->type = 'success';
            $notif->url = '/admin/transactions/' . $transaction->id;
            $notif->save();

            $notif = new NotificationUser;
            $notif->user_id = $transaction->customer->user_id;
            $notif->title = 'Order Confirmation';
            $notif->content = 'Order #' . $transaction->code . ' has been confirmed by seller';
            $notif->type = 'success';
            $notif->url = '/order-history';
            $notif->save();

            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Confirm', 'Confirmed by seller');
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
            if ($transaction->status != 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already rejected',
                ]);
            }
            $transaction->note = $request->note;
            $transaction->status = 8;
            $transaction->save();
        
            foreach($transaction->transactionProducts as $transactionProduct){
                $product = Product::find($transactionProduct->product_id);
                $product->stock += $transactionProduct->quantity;
                $product->save();
            }

            $notif = new NotificationAdmin;
            $notif->title = 'Order Rejected';
            $notif->content = 'Order #' . $transaction->code . ' has been rejected by seller';
            $notif->type = 'danger';
            $notif->url = '/admin/transactions/' . $transaction->id;
            $notif->save();

            $notif = new NotificationUser;
            $notif->user_id = $transaction->customer->user_id;
            $notif->title = 'Order Rejected';
            $notif->content = 'Order #' . $transaction->code . ' has been rejected by seller';
            $notif->type = 'danger';
            $notif->url = '/order-history';
            $notif->save();

            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Reject', 'Rejected by seller');
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

    public function packing($id)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            if ($transaction->status != 4) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already packing',
                ]);
            }
            $transaction->status = 5;
            $transaction->save();

            $delivery_tracking = new DeliveryTracking();
            $delivery_tracking->transaction_id = $transaction->id;
            $delivery_tracking->status = 'Sedang Dikemas';
            $delivery_tracking->note = 'Pesanan sedang dikemas oleh penjual';
            $delivery_tracking->save();

            $notif = new NotificationUser;
            $notif->user_id = $transaction->customer->user_id;
            $notif->title = 'Order Packing';
            $notif->content = 'Order #' . $transaction->code . ' has been packing by seller';
            $notif->type = 'info';
            $notif->url = '/order-history';
            $notif->save();

            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Packing', 'Packing by seller');
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success packing transaction',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error packing transaction',
            ]);
        }
    }

    public function delivery($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($id);
            if ($transaction->status != 5) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already delivery',
                ]);
            }
            
            $image = $request->file('shipping_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/delivery/'), $image_name);

            $transaction->status = 6;
            $transaction->shipping_number = $request->shipping_number;
            $transaction->shipping_attachment = $image_name;
            $transaction->save();
            
            $delivery_tracking = new DeliveryTracking();
            $delivery_tracking->transaction_id = $transaction->id;
            $delivery_tracking->status = 'Telah Diserahkan ke Jasa Kirim';
            $delivery_tracking->note = 'Barang Telah diserahkan ke jasa kirim dengan nomor resi ' . $request->shipping_number;
            $delivery_tracking->save();

            $notif = new NotificationUser;
            $notif->user_id = $transaction->customer->user_id;
            $notif->title = 'Order Delivery';
            $notif->content = 'Order #' . $transaction->code . ' has been delivery by seller';
            $notif->type = 'info';
            $notif->url = '/order-history';
            $notif->save();

            $notif = new NotificationAdmin;
            $notif->title = 'Order Delivery';
            $notif->content = 'Order #' . $transaction->code . ' has been delivery by seller';
            $notif->type = 'info';
            $notif->url = '/admin/transactions/' . $transaction->id;
            $notif->save();

            $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Delivery', 'Delivery by seller with shipping number ' . $request->shipping_number);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success delivery transaction',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error delivery transaction',
            ]);
        }
    }
}