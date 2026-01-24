<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductLog;
use App\Models\SettingUnit;
use App\Models\SettingType;
use App\Models\SettingCategory;
use App\Models\SettingSubCategory;
use App\Models\Seller;
use App\Models\NotificationAdmin;
use App\Services\SettingCostService;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class ProductController extends Controller
{

    protected $adminCostService;

    public function __construct(SettingCostService $adminCostService)
    {
        $this->adminCostService = $adminCostService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Auth::id();
    
            $seller = Seller::where('user_id', $user_id)->first();
            if (is_null($seller)) {
                return response()->json(['error' => 'Seller not found'], 404);
            }
    
            $pageUrl = $request->page_url;
            $routeName = "seller.products";
            $data = Product::where('seller_id', $seller->id)->with(['category', 'unit']);
    
            if (!empty($pageUrl) && $pageUrl == '/seller/my-products') {
                $data = $data->where('status', 2);
                $routeName = "seller.my-products";
            }else{
                $data = $data->where('status', 1);
            }
    
            return DataTables::of($data)
                ->addIndexColumn()
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
                ->addColumn('action', function ($row) use ($pageUrl, $routeName) { // Ambil $pageUrl di sini
                    $images = collect([
                        $row->image_1 ? ("/uploads/product/". $row->image_1) : null,
                        $row->image_2 ? ("/uploads/product/". $row->image_2) : null,
                        $row->image_3 ? ("/uploads/product/". $row->image_3) : null,
                        $row->image_4 ? ("/uploads/product/". $row->image_4) : null,
                    ])->filter()->values();
    
                    $editButton = ($row->status == 3 || $pageUrl == '/seller/my-products')
                        ? '<a class="btn-edit btn btn-sm btn-warning" href="' . route($routeName.'.edit', $row->id) . '">
                            <i class="fas fa-edit"></i>
                        </a>' : '';
    
                    return '
                        <form id="delete-form' . $row->id . '" action="' . route( $routeName.'.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="button" class="btn-view-images btn btn-sm btn-info" 
                                data-images=\'' . htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8') . '\'>
                                <i class="fas fa-images"></i>
                            </button>
                            ' . $editButton . '
                            <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['action', 'status', 'category', 'unit'])
                ->make(true);
        }
    
        return view('seller.product.index');
    }
    


    public function create()
    {
		$dataType = SettingType::all();
        $dataCategory = SettingCategory::all();
        $dataUnit = SettingUnit::all();
        return view('seller.product.create' , compact('dataType','dataCategory','dataUnit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
			'type_id' => 'required|exists:setting_types,id',
            'category_id' => 'required|exists:setting_categories,id',
            'unit_id' => 'required|exists:setting_units,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
			'weight' => 'required|integer',
			
			// // // // // 'file_1' => 'required_unless:type_id,1|max:20480',
            // // // // // 'file_2' => 'nullable|max:20480',
            // // // // // 'file_3' => 'nullable|max:20480',
            // // // // // 'file_4' => 'nullable|max:20480',
			
            'image_1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user_id = Auth::user()->id;

        $validated['seller_id'] = Seller::where('user_id', $user_id)->first()->id;

		$files = ['file_1', 'file_2', 'file_3', 'file_4'];
        $images = ['image_1', 'image_2', 'image_3', 'image_4'];

		$digitals = $request->file('digitals');
        
        DB::beginTransaction();
        try {
			$adminCost = $this->adminCostService->countSettingCost($validated['price']);
			$rand = rand(10,10000);
			$n = 1;
			$digital = [];
			// // // // // foreach ($digitals as $fileField) {
			if($request->type_id != 1) {
				
				if($request->type_id == 3) {
					
					$subtimes = $request->input('subtimes');
					$subprices = $request->input('subprices');
					$subtimes_value = $subprices_value = [];
					if($request->input('subprices')) $count_subprices = count($subprices); else $subprices = [];
					if(count($subprices)) {
						for($x=0; $x<count($subprices); $x++) {
							if(trim($subprices[$x]) && trim($subtimes[$x])) $subtimes_value[] = ['subtime' => trim($subtimes[$x]), 'subprice' => (intval(trim($subprices[$x])) + intval($this->adminCostService->countSettingCost(trim($subprices[$x]))['admin_cost'])), 'subsellerprice' => intval(trim($subprices[$x]))];	
						}
						$validated['subtimes'] = serialize($subtimes_value);
					}
				}

				if(count($digitals)) {
					for($x=0; $x<count($digitals); $x++) {
						
						if ($digitals[$x]) {
							
							$file = $digitals[$x];
							$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
							$extension = $file->getClientOriginalExtension();
							$uniqueFilename = $n.'-'.$rand.'_'.$request->name.rand(10,1000).'_' . time() .'_'.(mt_rand(100000, 999999)).'.' . $extension;

							// Simpan file langsung di public/uploads/product/
							$file->move(public_path('uploads/product'), $uniqueFilename);
							$digital[] = ['name' => $uniqueFilename];
							Log::info('has File');
							// Simpan path ke database atau array validasi
							// // // // // $validated[$fileField] = $uniqueFilename;
							$n++;
						} else Log::info('!!!has File');
						
					}
					$digital_serialize = serialize($digital);
					$validated['digitals'] = $digital_serialize;
				}
			} else Log::info('BBBBBBBBBBBBBBBB');

			// // // // // if(count($digitals)) {
				// // // // // Log::info('count($digitals)');
				
			// // // // // } else Log::info('!!!count($digitals)');
			
			$n = 1;
            foreach ($images as $imageField) {
                if ($request->hasFile($imageField) && $request->file($imageField)->isValid()) {
                    $file = $request->file($imageField);
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $uniqueFilename = $rand.'_'.$request->name.rand(10,1000).'_' . time() .'_'.(mt_rand(100000, 999999)).'.' . $extension;

                    // Simpan file langsung di public/uploads/product/
                    $file->move(public_path('uploads/product'), $uniqueFilename);

                    // Simpan path ke database atau array validasi
                    $validated[$imageField] = $uniqueFilename;
					$n++;
                }
				
            }

            $validated['slug'] = Str::slug($validated['name'] . ' ' . date("ymdHi"));

            // // // // // $adminCost = $this->adminCostService->countSettingCost($validated['price']);

            $validated['seller_price'] = $validated['price'];
            $validated['admin_cost_id'] = $adminCost['admin_cost_id'];
            $validated['admin_cost'] = $adminCost['admin_cost'];
            $validated['price'] = $validated['price'] + $validated['admin_cost'];
			$validated['sub_category_id'] = $request->sub_category_id;
			

            $product = Product::create($validated);

            $notif = new NotificationAdmin;
            $notif->title = 'Add Product';
            $notif->content = 'Product ' . $product->name . ' has been submited by seller';
            $notif->type = 'info';
            $notif->url = '/admin/products/confirmation/';
            $notif->save();

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
		
		$dataType = SettingType::all();
        $dataCategory = SettingCategory::all();
		$dataSubCategory = $product->sub_category_id ? SettingSubCategory::where('setting_category_id', $product->category_id)->get() : null;
		$subtimes = [];
		$subtimes = $product->subtimes ? unserialize($product->subtimes) : [];
		Log::info(print_r($subtimes, true));
		Log::info(print_r($dataSubCategory, true));
        $dataUnit = SettingUnit::all();
		$digitals = [];
		$digitals = $product->digitals ? unserialize($product->digitals) : [];
		// // // // // echo '<pre>';
		// // // // // print_r($product);
		// // // // // die();
        return view('seller.product.edit' , compact('product', 'digitals', 'subtimes', 'dataType','dataCategory', 'dataSubCategory', 'dataUnit'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data

        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
			'type_id' => 'required|exists:setting_types,id',
            'category_id' => 'required|exists:setting_categories,id',
            'unit_id' => 'required|exists:setting_units,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
			'file_1' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_2' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_3' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_4' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
		
		$validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
			'type_id' => 'required|exists:setting_types,id',
            'category_id' => 'required|exists:setting_categories,id',
            'unit_id' => 'required|exists:setting_units,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
			'file_1' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_2' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_3' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'file_4' => 'sometimes|nullable|file|mimes:pdf,docx,jpeg,jpg,png|max:20480',
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
		
		if($validator->errors()->all()) {
			// // // // // foreach($validator->errors()->all() as $error) {
				// // // // // $errors .= $error;
			// // // // // }
			return response()->json(['message'=>$validator->errors()->all()], 403);
		}
                        
		
        $validated['slug'] = Str::slug($validated['name'] . ' ' . date("ymdHi"));
    
        $product = Product::findOrFail($id);
        
        $status = $request->status;
        if ($request->basePath != '/seller/my-products') {
            $status = 1; 
        } else {
            $status = $product->status; 
        }
        //check admin cost
        $adminCost = $this->adminCostService->countSettingCost($validated['price']);
    
        $product->seller_price = $validated['price'];
        $product->admin_cost_id = $adminCost['admin_cost_id'];
        $product->admin_cost = $adminCost['admin_cost'];
        $product->price = $validated['price'] + $adminCost['admin_cost'];
		$product->sub_category_id = $request->sub_category_id;
    
        $product->status = intval($status);
        
        // // // // // $product->update($request->except(['image_1', 'image_2', 'image_3', 'image_4', 'status']));
    
		$files = ['file_1', 'file_2', 'file_3', 'file_4'];
        $images = ['image_1', 'image_2', 'image_3', 'image_4'];
		
		$rand = rand(10,10000);
		$n = 1;

		$digitals = $request->file('digitals');
		$file_digitals = $request->input('file_digitals');
		Log::info(print_r($file_digitals, true));

		$digital = [];
		// // // // // foreach ($digitals as $fileField) {
		for($x=0; $x<count($file_digitals); $x++) {
			if ($request->file('digitals_'.$x)) {
				
				$file = $request->file('digitals_'.$x);
				$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$extension = $file->getClientOriginalExtension();
				$uniqueFilename = $n.'-'.$rand.'_'.$request->name.rand(10,1000).'_' . time() .'_'.(mt_rand(100000, 999999)).'.' . $extension;

				// Simpan file langsung di public/uploads/product/
				$file->move(public_path('uploads/product'), $uniqueFilename);
				$digital[] = ['name' => $uniqueFilename];
				Log::info('has File');
				// Simpan path ke database atau array validasi
				// // // // // $validated[$fileField] = $uniqueFilename;
				$n++;
			} else {
				if($request->input('file_digitals_'.$x) != 'value') {
					$digital[] = ['name' => $file_digitals[$x]];///$request->input('file_digitals_'.$x);
				}
			}
		}
		
		Log::info('============================');
		Log::info(print_r($digital, true));

		if(count($digital)) {
			Log::info('count($digitals)');
			$digital_serialize = serialize($digital);
			$validated['digitals'] = $digital_serialize;
		} else {
			$validated['digitals'] = $product->digitals;			/// ini gk akan pernah dieksekusi dlm kasus algoritma ini
			Log::info('!!!count($digitals)');
		}
		
		
		if($request->type_id == 3) {
			$subtimes = $request->input('subtimes');
			$subprices = $request->input('subprices');
			if($request->input('subprices')) $count_subprices = count($subprices); else $subprices = [];
			if($request->input('subtimes')) $count_subtimes = count($subtimes); else $subtimes = [];
			Log::info('count($subtimes) = '.count($subtimes));
			$subtimes_value = [];
			if(count($subtimes)) {
				for($x=0; $x<count($subtimes); $x++) {
					if(trim($subprices[$x]) && trim($subtimes[$x])) $subtimes_value[] = ['subtime' => trim($subtimes[$x]), 'subprice' => (intval(trim($subprices[$x])) + intval($this->adminCostService->countSettingCost(trim($subprices[$x]))['admin_cost'])), 'subsellerprice' => intval(trim($subprices[$x]))];
				}
			}
			$request->request->set('subtimes', serialize($subtimes_value));
		}
		

		$n = 1;
        foreach ($images as $imageField) {
            if ($request->hasFile($imageField) && $request->file($imageField)->isValid()) {
                $file = $request->file($imageField);
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $uniqueFilename = $n.'-'.$rand.'_'.$request->name.rand(10,1000).'_' . time() .'_'.(mt_rand(100000, 999999)).'.' . $extension;

                $file->move(public_path('uploads/product'), $uniqueFilename);

                // // // // // $validated[$imageField] = $uniqueFilename;
				$product->{$imageField} = $uniqueFilename;
				$n++;
            }
        }
		
		$product->digitals = $validated['digitals'];
		$product->update($request->except(['image_1', 'image_2', 'image_3', 'image_4', 'status']));
		// // // // // $product->update($request->except(['image_1', 'image_2', 'image_3', 'image_4', 'status']));
    
        $product->save();

        $log = $this->LogProduct($product->id, 'Update', json_encode($product));
    
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
