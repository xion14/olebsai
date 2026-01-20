<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Models\SettingAboutUs;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SettingAboutUs::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-warning btn-edit" 
                            data-id="' . $row->id . '" 
                            data-key="' . $row->key . '" 
                            data-title="' . e($row->title) . '" 
                            data-image="' . e($row->image) . '" 
                            data-subtitle="' . e($row->subtitle) . '" 
                            data-link="' . e($row->link) . '"
                        >
                            <i class="fas fa-edit"></i>
                        </button>'
                        
                        . ($row->is_deleteable ? '
                        <button class="btn btn-danger btn-delete" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>' : '');
                })
                
                ->addColumn('image', function ($row) {
                    return '
                        <img src="' . '/uploads/aboutus/' . $row->image . '" width="100" height="100" class="img-thumbnail img-popup" data-url="' . asset('uploads/aboutus/' . $row->image) . '">
                    ';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('admin.about-us.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $image_name = time() . '.' . $image->extension();
        $image->move(public_path('uploads/aboutus'), $image_name);

        SettingAboutUs::create([
            'key' => $request->key,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $image_name,
            'is_deleteable' => true,
        ]);

        return response()->json(['status' => 200, 'text' => 'Data added successfully']);
    }
    
    public function show(string $id)
    {
        //
    }
    
    public function edit(string $id)
    {
        //
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'key' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $aboutus = SettingAboutUs::find($id);
        $aboutus->title = $request->title;
        $aboutus->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('uploads/aboutus'), $image_name);
            $aboutus->image = $image_name;
        }

        $aboutus->save();

        return response()->json(['status' => 200, 'text' => 'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
