<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SettingCategory;
use App\Models\SettingCategoryLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SettingCategory::query();
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
                    <a class="btn-edit btn btn-sm btn-warning" data-id="' . $row->id . '" data-code="' . $row->code . '" data-name="' . $row->name . '">  
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
        return view('admin.setting.category.index');
    }

    public function switchStatus(Request $request)
    {
        $setting_category = SettingCategory::find($request->id);

        if (!$setting_category) {
            return response()->json(['status' => 400,'text' => 'Tidak ditemukan.']);
        }

        $setting_category->status = $request->status;
        $setting_category->save();

        $log  = $this->LogSettingCategory($setting_category->id, 'Status Change', json_encode($setting_category));

        return response()->json(['status' => 200,'text' => 'Status berhasil diubah.']);
    }
   
    public function create()
    {
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'code' => 'required|unique:setting_categories',
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
        );
        $count = 0;
        $getLastId = SettingCategory::latest('id')->first();
        if ($getLastId) {
            $count = $getLastId->id;
        } 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $count + 1 . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/category'), $filename);
            $validated['image'] =  $filename;
        }
        
        DB::beginTransaction();
        try {
            $dataCategory = SettingCategory::create([
                ...$validated,
                'slug' => Str::slug($validated['name'] . ' ' . date("ymdHi"))    
            ]);
            $log  = $this->LogSettingCategory($dataCategory->id, 'Create', json_encode($dataCategory));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'code' => 'required|unique:setting_categories,code,' . $id,
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
        );

        $category = SettingCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $category->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/category'), $filename);
            $validated['image'] =  $filename;
        }
        
        DB::beginTransaction();
        try {
            $validated['slug'] = Str::slug($validated['name'] . ' ' . date("ymdHi"));
            $category->update($validated);
            $log  = $this->LogSettingCategory($category->id, 'Update', json_encode($category));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        $category = SettingCategory::findOrFail($id);
        $log  = $this->LogSettingCategory($category->id, 'Delete', json_encode($category));
        $category->delete();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus']);
    }


    private function LogSettingCategory($id, $activity, $details)
    {
        SettingCategoryLog::create([
            'setting_category_id' => $id,
            'activity' => $activity,
            'note' => $details,
            'user_id' => Auth::id(),
        ]);
    }

}
