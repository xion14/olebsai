<?php

namespace App\Http\Controllers\api;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerBalance;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\SettingCategory;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function cardData (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => [
                'totalCustomer' => Customer::count(),
                'totalSeller' => Seller::count(),
                'totalTransaction' => Transaction::count(),
                'totalSellerConfirm' => Seller::where('status', 1)->count(),
                'totalAdminConfirm' => Transaction::where('status', 2)->count(),
                'totalWaitingPayment' => Transaction::where('status', 3)->count(),
                'totalPaymentDone' => Transaction::where('status', 4)->count(),
                'totalPacking' => Transaction::where('status', 5)->count(),
                'totalOnDelivery' => Transaction::where('status', 6)->count(),
                'totalReceived' => Transaction::where('status', 7)->count(),
                'totalCancelled' => Transaction::where('status', 8)->count(),
                'totalUser' => User::count(),
                'totalProduct' => Product::where('status', 2)->count(),
                'totalProductConfirm' => Product::where('status', 1)->count(),
            ]
        ]);   
    }

    public function adminCardData(Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => [
                'totalCustomer' => Customer::count(),
                'totalSeller' => Seller::count(),
                'totalUser' => User::count(),
                'totalProduct' => Product::where('status', 2)->count(),
                'totalTransaction' => Transaction::count(),
                'totalCategory' => SettingCategory::count(),
                'totalProductConfirm' => Product::where('status', 1)->count(),
                'totalSellerConfirm' => Seller::where('status', 1)->count(),
                'totalAdminConfirm' => Transaction::where('status', 2)->count(),
            ]
        ]);
    }

    public function getBalanceInfoSeller(Request $request){

        $seller_id = $request->seller_id;
        $seller_balances = SellerBalance::where('type','in')->where('seller_id',$seller_id)->get();
        $seller_withdraw = SellerBalance::where('type','out')->where('seller_id',$seller_id)->get();
        
        $total_seller_balance = 0;
        $total_seller_withdraw = 0;

        foreach ($seller_balances as $balance) {
            $total_seller_balance += $balance->amount;
        }
        foreach ($seller_withdraw as $withdraw) {
            $total_seller_withdraw += $balance->amount;
        }

        $formatted_total_seller_balance = number_format($total_seller_balance, 0, ',', '.');
        $formatted_total_seller_withdraw = number_format($total_seller_withdraw, 0, ',', '.');
        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => [
                'totalSellerBalance' => $formatted_total_seller_balance,
                'totalSellerWithdraw' => $formatted_total_seller_withdraw
            ]
        ]);   
    }

    public function getBalanceInfoAdmin(Request $request) {
        $seller_balances = SellerBalance::where('type','in')->get();
        $seller_withdraw = SellerBalance::where('type','out')->get();
        
        $total_seller_balance = 0;
        $total_seller_withdraw = 0;

        foreach ($seller_balances as $balance) {
            $total_seller_balance += $balance->amount;
        }
        foreach ($seller_withdraw as $withdraw) {
            $total_seller_withdraw += $balance->amount;
        }

        $formatted_total_seller_balance = number_format($total_seller_balance, 0, ',', '.');
        $formatted_total_seller_withdraw = number_format($total_seller_withdraw, 0, ',', '.');
        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => [
                'totalSellerBalance' => $formatted_total_seller_balance,
                'totalSellerWithdraw' => $formatted_total_seller_withdraw
            ]
        ]); 
    }

    public function getTransactionInfoSeller(Request $request) {
        
        $seller_id = $request->seller_id;
        $transaction = Transaction::with('customer')->where('seller_id',$seller_id)->limit(5)->latest()->get()->map(function ($row) {
            
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

            
            $status = '<span class="d-inline-flex align-items-center">' . $badge . '</span>';

            return [
                'customer' => $row->customer,
                'status' => $status,
                'created_at' => Carbon::parse($row->created_at)->format('d-m-Y H:i'),
                'total' => 'Rp.'.number_format($row->total, 0, ',', '.'),
            ];
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => $transaction
        ]);
    }

    public function getProductConfirmationAdmin(Request $request) {
        $product = Product::with(['seller','category'])->where('status', 1)->latest()->limit(5)->get()->map(function ($row) {
            return [
                'seller' => $row->seller,
                'code' => $row->code,
                'name' => $row->name,
                'category' => $row->category,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => $product
        ]);
    }

    public function getSellerConfirmation(Request $request) {
        $seller = Seller::where('status',1)->latest()->limit(5)->get()->map(function ($row) {
            return [
                'name' => $row->name,
                'email' => $row->email,
                'phone' => $row->phone,
                'location' => $row->address.",".$row->city.",".$row->province.",".$row->country,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Success get card data',
            'data' => $seller
        ]);

    }

    public function TransactionStatistic(Request $request) {
        $type = $request->type;
        $month = $request->month; // Format: YYYY-MM

        $query = Transaction::query();

        // Validasi & filter bulan menggunakan Carbon
        if (!empty($month)) {
            try {
                $startDate = Carbon::parse($month . '-01')->startOfMonth();
                $endDate = Carbon::parse($month . '-01')->endOfMonth();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid month format. Use YYYY-MM.',
                ], 400);
            }
        }

        if ($type == 'admin') {
            return response()->json([
                'success' => true,
                'message' => 'Success get transaction statistic',
                'data' => [
                    'totalTransactionWaitingSeller' => (clone $query)->where('status', 1)->count(),
                    'totalTransactionWaitingAdmin' => (clone $query)->where('status', 2)->count(),
                    'totalTransactionWaitingPayment' => (clone $query)->where('status', 3)->count(),
                    'totalTransactionPaid' => (clone $query)->where('status', 4)->count(),
                    'totalTransactionWaitingPacking' => (clone $query)->where('status', 5)->count(),
                    'totalTransactionWaitingDelivery' => (clone $query)->where('status', 6)->count(),
                    'totalTransactionReceived' => (clone $query)->where('status', 7)->count(),
                    'totalTransactionCanceled' => (clone $query)->where('status', 8)->count(),
                    'totalTransactionExpired' => (clone $query)->where('status', 9)->count(),
                    'totalTransaction' => (clone $query)->count(),
                ]
            ]);
        }

        if ($type == 'seller') {
            $query->where('seller_id', Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Success get transaction statistic',
                'data' => [
                    'totalTransactionWaitingSeller' => (clone $query)->where('status', 1)->count(),
                    'totalTransactionWaitingAdmin' => (clone $query)->where('status', 2)->count(),
                    'totalTransactionWaitingPayment' => (clone $query)->where('status', 3)->count(),
                    'totalTransactionPaid' => (clone $query)->where('status', 4)->count(),
                    'totalTransactionWaitingPacking' => (clone $query)->where('status', 5)->count(),
                    'totalTransactionWaitingDelivery' => (clone $query)->where('status', 6)->count(),
                    'totalTransactionReceived' => (clone $query)->where('status', 7)->count(),
                    'totalTransactionCanceled' => (clone $query)->where('status', 8)->count(),
                    'totalTransactionExpired' => (clone $query)->where('status', 9)->count(),
                    'totalTransaction' => (clone $query)->count(),
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid type parameter. Use admin or seller.',
        ], 400);
    }


    public function balanceGraphPerDate(Request $request)
    {
        $month = $request->month; // Format: YYYY-MM

        if (!$month) {
            return response()->json([
                'success' => false,
                'message' => 'Month parameter is required',
            ], 400);
        }

        try {
            $startDate = Carbon::parse($month . '-01')->startOfMonth(); // Mulai bulan
            $endDate = $startDate->copy()->endOfMonth(); // Akhir bulan
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid month format. Use YYYY-MM.',
            ], 400);
        }

        $list_date = [];
        $currentDate = $startDate->copy(); // Salin agar tidak mengubah `startDate`

        while ($currentDate->lte($endDate)) { // Loop sampai akhir bulan
            $balance = SellerBalance::where('type', 'in')->whereDate('created_at', $currentDate->toDateString())
                ->sum('amount');

            $list_date[] = [
                'date' => $currentDate->toDateString(), // Format YYYY-MM-DD
                'balance' => $balance
            ];

            $currentDate->addDay(); // Tambah 1 hari
        }

        return response()->json([
            'success' => true,
            'message' => 'Success get balance graph per date',
            'data' => $list_date
        ]);
    }


    public function withdrawGraphPerDate(Request $request)
    {
        $month = $request->month;

        if (!$month) {
            return response()->json([
                'success' => false,
                'message' => 'Month parameter is required',
            ], 400);
        }

        try {
            $startDate = Carbon::parse($month . '-01')->startOfMonth(); // Mulai bulan
            $endDate = $startDate->copy()->endOfMonth(); // Akhir bulan
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid month format. Use YYYY-MM.',
            ], 400);
        }

        $list_date = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $withdraw = SellerBalance::where('type', 'out')->whereDate('created_at', $currentDate->toDateString())
                ->sum('amount');

            $list_date[] = [
                'date' => $currentDate->toDateString(),
                'withdraw' => $withdraw
            ];

            $currentDate->addDay();
        }

        return response()->json([
            'success' => true,
            'message' => 'Success get withdraw graph per date',
            'data' => $list_date
        ]);
    }


    public function RevenueVsOrder(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year; // Default tahun ini
        $list_data = [];

        // Loop dari Januari (1) sampai Desember (12)
        for ($month = 1; $month <= 12; $month++) {
            // Tentukan rentang tanggal dari awal hingga akhir bulan
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            if ($request->type == 'admin') {
                $totalRevenue = Transaction::where('status', '7')->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('total'); // Sesuaikan dengan kolom pendapatan

                $totalSales = Transaction::where('status', '7')->whereBetween('created_at', [$startDate, $endDate])
                    ->count(); // Jumlah total transaksi sebagai sales

                // Simpan data ke array
                $list_data[] = [
                    'month' => $startDate->format('F'), // Nama bulan (e.g., January, February)
                    'sales' => $totalSales,
                    'revenue' => $totalRevenue,
                ];
            }

            if ($request->type == 'seller') {
                $totalRevenue = Transaction::where('seller_id', auth()->user()->seller->id)->where('status', '7')->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('total'); // Sesuaikan dengan kolom pendapatan

                $totalSales = Transaction::where('seller_id', auth()->user()->seller->id)->where('status', '7')->whereBetween('created_at', [$startDate, $endDate])
                    ->count(); // Jumlah total transaksi sebagai sales

                // Simpan data ke array
                $list_data[] = [
                    'month' => $startDate->format('F'), // Nama bulan (e.g., January, February)
                    'sales' => $totalSales,
                    'revenue' => $totalRevenue,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Success get revenue vs order per month',
            'data' => $list_data
        ]);
    }


    public function topProduct(Request $request)
    {
        $type = $request->type; // Bisa 'admin' atau 'seller'
        $filter = $request->filter; // Bisa 'today', 'this_week', 'this_month', 'this_year'

        // Tentukan rentang tanggal berdasarkan filter yang dipilih
        $startDate = null;
        $endDate = Carbon::now();

        switch ($filter) {
            case 'today':
                $startDate = Carbon::now()->startOfDay();
                break;
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                break;
        }

        // Query produk terlaris
        $query = TransactionProduct::select('product_id')
            ->selectRaw('SUM(qty) as total_sold') // Hitung total quantity terjual
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->where('status', 7); // Hanya transaksi dengan status 7

                // Jika ada filter waktu, tambahkan kondisi tanggal
                if ($startDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            });

        // Jika tipe seller, filter berdasarkan seller yang login
        if ($type == 'seller') {
            $query->whereHas('product', function ($query) {
                $query->where('seller_id', Auth::id()); // Produk hanya milik seller yang login
            });
        }

        $topProducts = $query->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5) // Ambil 5 produk terbanyak
            ->with('product:id,name,seller_id') // Ambil informasi produk (nama dan seller)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Success get top 5 products',
            'filter' => $filter,
            'data' => $topProducts
        ]);
    }
}
