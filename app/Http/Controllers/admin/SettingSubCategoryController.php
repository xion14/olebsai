<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SettingCategory;
use App\Models\SettingSubCategory;
use App\Models\SettingCategoryLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$setting_categories = SettingCategory::pluck('name', 'id');
        if ($request->ajax()) {
            $data = SettingSubCategory::select('setting_sub_categories.id as id', 'setting_categories.id as pid', 'setting_categories.code as pcode', 'setting_categories.name as pname', 'setting_sub_categories.code as code', 'setting_sub_categories.name as name', 'setting_sub_categories.image as image', 'setting_sub_categories.status as status')
			->leftJoin('setting_categories', 'setting_categories.id', '=', 'setting_sub_categories.setting_category_id' )->get();
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $el = '
                    <label class="switch"> 
                        <input type="checkbox" class="switch-status" data-id="' . $row->id . '" ' . ($row->status ? 'checked' : '') . '>
                        <span class="slider round"></span>
                    </label> ';
                    $el .= $row->status ? 'Active' : 'Inactive';
                    return $el;
                })
                ->addColumn('action', content: function ($row) {
                    $btn = '
                    <form id="delete-form' . $row->id . '" action="' . route('admin.setting.units.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <a class="btn-edit btn btn-sm btn-warning" data-pid="' . $row->pid . '" data-pcode="' . $row->pcode . '" data-pname="' . $row->pname . '" data-id="' . $row->id . '" data-code="' . $row->code . '" data-name="' . $row->name . '">  
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                    </button>
                    </form>
                    ';
                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.setting.sub-category.index', compact('setting_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
		// // // // // $validated = $request->validate(
            // // // // // [
				// // // // // 'setting_category_id' => 'required|integer|exists:setting_categories,id',
                // // // // // 'code' => 'required|unique:setting_categories',
                // // // // // 'name' => 'required|string',
                // // // // // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            // // // // // ],
        // // // // // );
		
		
		$validationRules = [
				'setting_category_id' => 'required|integer|exists:setting_categories,id',
                'code' => 'required|unique:setting_categories',
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
			];
			
		$messages = [
					'setting_category_id.required' => 'The Category Name field is required',
					'setting_category_id.integer' => 'The Category Name field is missing',
					'setting_category_id.exists' => 'The Category Name field is not existing',
			];
			
		$this->validate($request, $validationRules, $messages);
		
		$validated = $request->validate(
            [
				'setting_category_id' => 'required|integer|exists:setting_categories,id',
                'code' => 'required|unique:setting_categories',
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
        );
		
		
        $count = 0;
        $getLastId = SettingSubCategory::latest('id')->first();
        if ($getLastId) {
            $count = $getLastId->id;
        } 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $count + 1 . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sub_category'), $filename);
            $validated['image'] =  $filename;
        }
        
        DB::beginTransaction();
        try {
            $dataCategory = SettingSubCategory::create([
                ...$validated,
                'slug' => Str::slug($validated['name'] . ' ' . date("ymdHi"))    
            ]);
            // // // // // $log  = $this->LogSettingCategory($dataCategory->id, 'Create', json_encode($dataCategory));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => '$th->getMessage()']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // // // // // $validated = $request->validate(
            // // // // // [
                // // // // // 'code' => 'required|unique:setting_categories,code,' . $id,
                // // // // // 'name' => 'required|string',
                // // // // // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            // // // // // ],
        // // // // // );
		
		$validationRules = [
				'setting_category_id' => 'required|integer|exists:setting_categories,id',
                'code' => 'required|unique:setting_categories,code,' . $id,
                'name' => 'required|string',
                'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
			];
			
		$messages = [
					'setting_category_id.required' => 'The Category Name field is required',
					'setting_category_id.integer' => 'The Category Name field is missing',
					'setting_category_id.exists' => 'The Category Name field is not existing',
			];
			
		$this->validate($request, $validationRules, $messages);
		
		$validated = $request->validate(
            [
				'setting_category_id' => 'required|integer|exists:setting_categories,id',
                'code' => 'required|unique:setting_categories,code,' . $id,
                'name' => 'required|string',
                'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
        );

        $category = SettingSubCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $category->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sub_category'), $filename);
            $validated['image'] =  $filename;
        }
        
        DB::beginTransaction();
        try {
            $validated['slug'] = Str::slug($validated['name'] . ' ' . date("ymdHi"));
            $category->update($validated);
            // // // // // $log  = $this->LogSettingCategory($category->id, 'Update', json_encode($category));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = SettingSubCategory::findOrFail($id);
        // // // // // $log  = $this->LogSettingCategory($category->id, 'Delete', json_encode($category));
        $category->delete();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus']);
    }
}
