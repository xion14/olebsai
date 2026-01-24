<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;

use App\Models\Banner;
class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-warning btn-edit" 
                            data-id="' . $row->id . '" 
                            data-title="' . e($row->title) . '" 
                            data-link="' . e($row->link) . '"
                        >
                            <i class="fas fa-edit"></i>
                        </button>'
                        
                        . '
                        <button class="btn btn-danger btn-delete" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                })
                
                ->addColumn('image', function ($row) {
                    return '
                        <img src="' . '/uploads/banner/' . $row->image . '" width="100" height="100" class="img-thumbnail img-popup" data-url="' . asset('images/' . $row->image) . '">
                    ';
                })
                ->addColumn('status', function ($row) {
                    $statusClass = $row->status == 1 ? 'badge-success' : 'badge-danger';
                    $statusText = $row->status == 1 ? 'Active' : 'Inactive';
                
                    return '<span class="badge ' . $statusClass . '">' . $statusText . '</span>';
                })
                
                
                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }
        return view('admin.banner.index');
    }
    

    public function store(Request $request){
        try {
            DB::beginTransaction();
       
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $check_banner = Banner::count();
            if ($check_banner > 0) {
                return response()->json(['status' => 400, 'text' => 'Banner already exist']);
            }
            $input = $request->all();
            if ($image = $request->file('image')) {
                $destinationPath = public_path('uploads/banner/');
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = $profileImage;
            }
            Banner::create($input);
            DB::commit();
            return response()->json(['status' => false, 'text' => 'Data berhasil di simpan', 'success' => true]);
        }catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => 'Data gagal di simpan', 'success' => false]);
        }

    }

    public function update(Request $request, $id){
        try {
            DB::beginTransaction();
            $request->validate([
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $input = $request->all();
            if ($image = $request->file('image')) {
                $destinationPath = public_path('uploads/banner/');
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = $profileImage;
            }else{
                unset($input['image']);
            }
            Banner::find($id)->update($input);
            DB::commit();
             return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah','success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 400, 'text' => 'Data gagal di ubah', 'success' => false]);
        }   
    }

    public function destroy($id){
        DB::beginTransaction();
        Banner::find($id)->delete();
        DB::commit();
        return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus' , 'success' => true]);
    }

}
