<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Exports\AdminStockExport;
use Maatwebsite\Excel\Facades\Excel;


class StockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
    
            $data = Product::with(['category', 'unit'])->where('status', 2)->orderBy('name', 'asc')->get();
        
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('seller', function ($row) {
                    return '<span>' . ($row->seller->name ?? '-') . '</span>';
                })
                ->addColumn('unit', function ($row) {
                    return '<span>' . ($row->unit->name ?? '-') . '</span>';
                })
                ->rawColumns(['seller','unit'])
                ->make(true);
        }
    
        return view('admin.stock.index');
    }
    


    public function export()
    {
        return Excel::download(new AdminStockExport, 'stock_produk.xlsx');
    }

}
