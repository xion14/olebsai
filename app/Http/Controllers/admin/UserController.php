<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
class UserController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            $index = 1;
            return DataTables::of(source: $data)
                ->addColumn('no', function () use (&$index) {
                    return $index++;
                })
                ->addIndexColumn()
                ->addColumn('action', content: function ($row) {
                    
                    $btn = '
                    <form id="delete-form' . $row->id . '" action="' . route('admin.setting.units.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <a class="btn-edit btn btn-sm btn-warning" data-id="' . $row->id . '" data-email="' . $row->email . '" data-phone="' . $row->phone . '" data-name="' . $row->name . '">  
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn-delete btn btn-sm btn-danger" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                    </button>
                    </form>
                    ';
                    if($row->id != 1){
                        return $btn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.user.index');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'required'
            ],
        );

        // save
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $user->save();

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
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
        $user = User::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'nullable'
            ],
        );

        // save
        DB::beginTransaction();
        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            if($validated['password']){
            $user->password = Hash::make($validated['password']);
            }
            $user->save();

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {
            // UnitLog::create([
            //     'unit_id' => $unit->id,
            //     'activity' => 'Delete',
            //     'details' => json_encode($unit),
            //     'user_id' => Auth::id(),
            //     'name' => Auth::user()->name
            // ]);
            $user->delete();
            DB::commit();
            return response()->json(['status' => 200,'text' => 'Data berhasil di hapus']);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
