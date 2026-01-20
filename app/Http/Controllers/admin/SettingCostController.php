<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingCost;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\SettingCostService;

class SettingCostController extends Controller
{
    protected $adminCostService;

    public function __construct(SettingCostService $adminCostService)
    {
        $this->adminCostService = $adminCostService;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SettingCost::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-edit" data-id="' . $row->id . '" data-min_price="' . $row->min_price . '" data-max_price="' . $row->max_price . '" data-cost_value="' . $row->cost_value . '" data-status="' . $row->status . '">Edit</a>';
                    // $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">Delete</a>';                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.setting.cost.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'min_price' => 'required|numeric|min:0',
        'max_price' => 'required|numeric|min:0|gte:min_price',
        'cost_value' => 'required|numeric|min:0',
        'status' => 'required|in:0,1',
    ]);

    // Cek jika ada data yang irisan
    $overlap = SettingCost::where(function ($query) use ($request) {
        $query->whereBetween('min_price', [$request->min_price, $request->max_price])
              ->orWhereBetween('max_price', [$request->min_price, $request->max_price])
              ->orWhere(function ($query) use ($request) {
                  $query->where('min_price', '<=', $request->min_price)
                        ->where('max_price', '>=', $request->max_price);
              });
    })->exists();

    if ($overlap) {
        return response()->json([
            'success' => false,
            'text' => 'Rentang harga yang diberikan tumpang tindih dengan data lain.',
        ], 400);
    }

    $settingCost = SettingCost::create([
        'min_price' => $request->min_price,
        'max_price' => $request->max_price,
        'cost_value' => $request->cost_value,
        'status' => $request->status,
    ]);

    $this->adminCostService->assignProductsToNewSettingCost($settingCost);

    return response()->json([
        'success' => true,
        'text' => 'Data created successfully!',
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'min_price' => 'required|numeric|min:0',
        'max_price' => 'required|numeric|min:0|gte:min_price',
        'cost_value' => 'required|numeric|min:0',
        'status' => 'required|in:0,1',
    ]);

    // Cek jika ada data yang irisan, kecuali data yang sedang diupdate
    $overlap = SettingCost::where(function ($query) use ($request, $id) {
        $query->whereBetween('min_price', [$request->min_price, $request->max_price])
              ->orWhereBetween('max_price', [$request->min_price, $request->max_price])
              ->orWhere(function ($query) use ($request) {
                  $query->where('min_price', '<=', $request->min_price)
                        ->where('max_price', '>=', $request->max_price);
              });
    })
    ->where('id', '!=', $id) // Exclude the current record from the check
    ->exists();

    if ($overlap) {
        return response()->json([
            'success' => false,
            'text' => 'Rentang harga yang diberikan tumpang tindih dengan data lain.',
        ], 400);
    }

    $settingCost = SettingCost::findOrFail($id);

    $settingCost->update([
        'min_price' => $request->min_price,
        'max_price' => $request->max_price,
        'cost_value' => $request->cost_value,
        'status' => $request->status,
    ]);
    
    $this->adminCostService->updateRelatedProducts($settingCost);

    return response()->json([
        'success' => true,
        'text' => 'Data updated successfully!',
    ]);
}


    public function destroy($id)
    {
        $settingCost = SettingCost::findOrFail($id);
        $settingCost->delete();

        return response()->json([
            'text' => 'Data deleted successfully!',
        ]);
    }

}
