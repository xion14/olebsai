<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductLog;
use App\Models\SettingUnit;
use App\Models\SettingCategory;
use App\Models\Seller;
use App\Models\NotificationSeller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::where('status', 2)->with(['category', 'unit', 'seller']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('seller', function ($row) {
                    return '<span>' . ($row->seller->name ?? '-') . '</span>';
                })
                ->addColumn('category', function ($row) {
                    return '<span>' . ($row->category->name ?? '-') . '</span>';
                })
                ->addColumn('unit', function ($row) {
                    return '<span>' . ($row->unit->name ?? '-') . '</span>';
                })
                ->addColumn('status', function ($row) {
                    $statusText = $row->status == 1 ? 'Waiting Approval' : ($row->status == 2 ? 'Approved' : 'Rejected');
                    $badgeClass = $row->status == 1 ? 'badge-warning' : ($row->status == 2 ? 'badge-success' : 'badge-danger');
                
                    $logs = $row->logs ? $row->logs->map(function ($log) {
                        return [
                            'user_name' => $log->user->name ?? 'Unknown',
                            'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                            'activity' => $log->activity,
                            'note' => $log->note ?? '-',
                        ];
                    }) : [];
                
                    $logsJson = htmlspecialchars(json_encode($logs), ENT_QUOTES, 'UTF-8');
                
                    $badge = '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                
                    $infoButton = 
                        '<button class="btn btn-info btn-sm btn-log rounded-circle ml-1" data-logs=\'' . $logsJson . '\'>
                            <i class="fas fa-info-circle"></i>
                        </button>' 
                       ;
                
                    return '<span class="d-inline-flex align-items-center">' . $badge . $infoButton . '</span>';
                })
                
                ->addColumn('action', function ($row) {
                    $images = collect([
                        $row->image_1 ? ("/uploads/product/". $row->image_1) : null,
                        $row->image_2 ? ("/uploads/product/". $row->image_2) : null,
                        $row->image_3 ? ("/uploads/product/". $row->image_3) : null,
                        $row->image_4 ? ("/uploads/product/". $row->image_4) : null,

                        
                    ])->filter()->values();

                    $approveButton = $row->status == 1 ? ' <button type="button" class="btn-approve btn btn-sm btn-success" data-id="' . $row->id . '">
                                <i class="fas fa-check"></i> Approve
                            </button>' : '';

                    $rejectButton = $row->status == 1 ? ' <button type="button" class="btn-reject btn btn-sm btn-warning" data-id="' . $row->id . '">
                                <i class="fas fa-times"></i> Reject
                            </button>' : '';

                    return '
                        <form id="delete-form' . $row->id . '" action="' . route('admin.products.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="button" class="btn-view-images btn btn-sm btn-info" 
                                data-images=\'' . htmlspecialchars($images, ENT_QUOTES, 'UTF-8') . '\'>
                                <i class="fas fa-images"></i>
                            </button> 
                            ' . $approveButton . '
                            ' . $rejectButton . '

                            <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                               <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['seller', 'action', 'status', 'category', 'unit'])
                ->make(true);
        }
      

        return view('admin.product.index');
    }

    public function confirmation(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::where('status', 1)->with(['category', 'unit', 'seller']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('seller', function ($row) {
                    return '<span>' . ($row->seller->name ?? '-') . '</span>';
                })
				->addColumn('type', function ($row) {
                    return '<span>' . ($row->type->name ?? '-') . '</span>';
                })
                ->addColumn('category', function ($row) {
                    return '<span>' . ($row->category->name ?? '-') . '</span>';
                })
                ->addColumn('unit', function ($row) {
                    return '<span>' . ($row->unit->name ?? '-') . '</span>';
                })
                ->addColumn('status', function ($row) {
                    $statusText = $row->status == 1 ? 'Waiting Approval' : ($row->status == 2 ? 'Approved' : 'Rejected');
                    $badgeClass = $row->status == 1 ? 'badge-warning' : ($row->status == 2 ? 'badge-success' : 'badge-danger');
                
                    $logs = $row->logs ? $row->logs->map(function ($log) {
                        return [
                            'user_name' => $log->user->name ?? 'Unknown',
                            'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                            'activity' => $log->activity,
                            'note' => $log->note ?? '-',
                        ];
                    }) : [];
                
                    $logsJson = htmlspecialchars(json_encode($logs), ENT_QUOTES, 'UTF-8');
                
                    $badge = '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                
                    $infoButton = 
                        '<button class="btn btn-info btn-sm btn-log rounded-circle ml-1" data-logs=\'' . $logsJson . '\'>
                            <i class="fas fa-info-circle"></i>
                        </button>' 
                       ;
                
                    return '<span class="d-inline-flex align-items-center">' . $badge . $infoButton . '</span>';
                })
                
                ->addColumn('action', function ($row) {
                    $images = collect([
                        $row->image_1 ? ("/uploads/product/". $row->image_1) : null,
                        $row->image_2 ? ("/uploads/product/". $row->image_2) : null,
                        $row->image_3 ? ("/uploads/product/". $row->image_3) : null,
                        $row->image_4 ? ("/uploads/product/". $row->image_4) : null,

                        
                    ])->filter()->values();

                    $approveButton = $row->status == 1 ? ' <button type="button" class="btn-approve btn btn-sm btn-success" data-id="' . $row->id . '">
                                <i class="fas fa-check"></i> Approve
                            </button>' : '';

                    $rejectButton = $row->status == 1 ? ' <button type="button" class="btn-reject btn btn-sm btn-warning" data-id="' . $row->id . '">
                                <i class="fas fa-times"></i> Reject
                            </button>' : '';

                    return '
                        <form id="delete-form' . $row->id . '" action="' . route('admin.products.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="button" class="btn-view-images btn btn-sm btn-info" 
                                data-images=\'' . htmlspecialchars($images, ENT_QUOTES, 'UTF-8') . '\'>
                                <i class="fas fa-images"></i>
                            </button> 
                            ' . $approveButton . '
                            ' . $rejectButton . '

                            <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                               <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['seller', 'action', 'type', 'status', 'category', 'unit'])
                ->make(true);
        }
      

        return view('admin.product.confirmation');
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->status = 2; // Approved
            $product->save();

            $notification_seller = new NotificationSeller;
            $notification_seller->user_id = $product->seller->user_id;
            $notification_seller->title = 'Product Approved';
            $notification_seller->content = 'Product #' . $product->code . ' ('. $product->name .') has been approved by admin';
            $notification_seller->type = 'success';
            $notification_seller->url = '/seller/products/';
            $notification_seller->save();

            $log = $this->LogProduct($product->id, 'Approve', json_encode($product));
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $product,
                'text' => 'Product approved successfully!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Product approved failed!',
                'text' => 'Product approved failed!'
            ]);
        }
    }

    public function reject(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = 3; // Rejected
        $product->save();

        $log = $this->LogProduct($product->id, 'Reject', $request->note);

        return response()->json([
            'success' => 'Product rejected successfully!',
            'text' => 'Product rejected successfully!'
        ]);
    }



    public function create()
    {
        $dataCategory = SettingCategory::all();
        $dataUnit = SettingUnit::all();
        return view('seller.product.create' , compact('dataCategory','dataUnit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:setting_categories,id',
            'unit_id' => 'required|exists:setting_units,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            // 'note' => 'nullable|string',
            'image_1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'status' => 'required|boolean'
        ]);
        $user_id = Auth::user()->id;

        $validated['seller_id'] = Seller::where('user_id', $user_id)->first()->id;

        if ($request->hasFile('image_1')) {
            $validated['image_1'] = $request->file('image_1')->store('products', 'public');
        }
        if ($request->hasFile('image_2')) {
            $validated['image_2'] = $request->file('image_2')->store('products', 'public');
        }
        if ($request->hasFile('image_3')) {
            $validated['image_3'] = $request->file('image_3')->store('products', 'public');
        }
        if ($request->hasFile('image_4')) {
            $validated['image_4'] = $request->file('image_4')->store('products', 'public');
        }

        DB::beginTransaction();
        try {
            $product = Product::create($validated);
            $log  = $this->LogProduct($product->id, 'Create', json_encode($product));
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
        
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $dataCategory = SettingCategory::all();
        $dataUnit = SettingUnit::all();
        return view('seller.product.edit' , compact('product','dataCategory','dataUnit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:setting_categories,id',
            'unit_id' => 'required|exists:setting_units,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $request->status = 1;
        $product = Product::findOrFail($id);
        $product->update($request->except(['image_1', 'image_2', 'image_3', 'image_4']));

        // Proses upload gambar jika ada
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $path = $request->file($imageField)->store('products', 'public');
                $product->$imageField = $path;
            }
        }

        $product->save();

        $log  = $this->LogProduct($product->id, 'Update', json_encode($product));

        return response()->json(['message' => 'Product updated successfully!'], 200);
    }



    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            $log  = $this->LogProduct($product->id, 'Delete', json_encode($product));
            $product->delete();
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    private function LogProduct($id, $activity, $details)
    {
        $log = new ProductLog();
        $log->user_id = Auth::user()->id;
        $log->product_id = $id;
        $log->activity = $activity;
        $log->note = $details;
        $log->save();
    }

    
    
}
