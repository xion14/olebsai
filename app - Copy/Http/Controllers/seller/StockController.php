<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;


class StockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Auth::id();
    
            $seller = Seller::where('user_id', $user_id)->first();

            if (is_null($seller)) {
                return response()->json(['error' => 'Seller not found'], 404);
            }
    
            $data = Product::where('seller_id', $seller->id)->with(['category', 'unit'])->where('status', 2)->orderBy('name', 'asc')->get();
        
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return '<span>' . ($row->unit->name ?? '-') . '</span>';
                })
                ->rawColumns([ 'unit'])
                ->make(true);
        }
    
        return view('seller.stock.index');
    }
    


    public function export()
    {
        return Excel::download(new StockExport, 'stock_produk.xlsx');
    }

}
