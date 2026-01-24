<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vouchers = Voucher::latest()->get();
    
            return DataTables::of($vouchers)
                ->addIndexColumn()
                ->editColumn('type', fn ($row) => $row->type == 0 ? 'Product Discount' : 'Shipping Discount')
                ->editColumn('percentage', fn ($row) => $row->percentage ? number_format($row->percentage, 0) . '%' : '-')
                ->editColumn('max_discount', fn ($row) => $row->max_discount ? 'Rp' . number_format($row->max_discount, 0, ',', '.') : '-')
                ->editColumn('minimum_transaction', fn ($row) => $row->minimum_transaction ? 'Rp' . number_format($row->minimum_transaction, 0, ',', '.') : '-')
                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Non Active</span>';
                })
                ->addColumn('validity', function ($row) {
                    $start = \Carbon\Carbon::parse($row->start_date)->format('d M Y H:i');
                    $end = \Carbon\Carbon::parse($row->expired_date)->format('d M Y H:i');
                    return "$start - $end";
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" 
                                class="btn btn-sm btn-warning btn-edit" 
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '"
                                data-type="' . $row->type . '"
                                data-percentage="' . $row->percentage . '"
                                data-max_discount="' . $row->max_discount . '"
                                data-minimum_transaction="' . $row->minimum_transaction . '"
                                data-quota="' . $row->quota . '"
                                data-status="' . $row->status . '"
                                data-start_date="' . $row->start_date . '"
                                data-expired_date="' . $row->expired_date . '"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <button type="button" 
                                class="btn btn-sm btn-danger btn-delete" 
                                data-id="' . $row->id . '"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    
        return view('admin.vouchers.index');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'max_discount' => 'required|numeric|min:0',
            'minimum_transaction' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'expired_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $voucher = Voucher::create([
            'name' => $request->name,
            'type' => $request->type,
            'percentage' => $request->percentage,
            'max_discount' => $request->max_discount,
            'minimum_transaction' => $request->minimum_transaction,
            'quota' => $request->quota,
            'start_date' => $request->start_date,
            'expired_date' => $request->expired_date,
            'status' => $request->status,
            'user_created' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'text' => 'Voucher created successfully']);
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'max_discount' => 'required|numeric|min:0',
            'minimum_transaction' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'expired_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $voucher->update([
            'name' => $request->name,
            'type' => $request->type,
            'percentage' => $request->percentage,
            'max_discount' => $request->max_discount,
            'minimum_transaction' => $request->minimum_transaction,
            'quota' => $request->quota,
            'start_date' => $request->start_date,
            'expired_date' => $request->expired_date,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'text' => 'Voucher updated successfully']);
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return response()->json(['success' => true, 'message' => 'Voucher deleted successfully']);
    }
}
