<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\SettingUnit;
use App\Models\SettingUnitLog;
class SettingUnitController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SettingUnit::query();
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
        return view('admin.setting.unit.index');
    }

    public function switchStatus(Request $request)
    {
        $setting_unit = SettingUnit::find($request->id);

        if (!$setting_unit) {
            return response()->json(['status' => 400,'text' => 'Tidak ditemukan.']);
        }

        $setting_unit->status = $request->status;
        $setting_unit->save();

        $log  = $this->LogSettingUnit($setting_unit->id, 'Status Change', json_encode($setting_unit));

        return response()->json(['status' => 200,'text' => 'Status berhasil diubah.']);
    }
   
    public function create()
    {
    }

    
    public function store(Request $request)
    {
        
        $validated = $request->validate(
            [
                'code' => 'required|unique:setting_units',
                'name' => 'required|string'
            ],
        );
        
        DB::beginTransaction();
        try {
            $dataSettingUnit = SettingUnit::create($validated);
            
            $log  = $this->LogSettingUnit($dataSettingUnit->id, 'Create', json_encode($dataSettingUnit));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $unit = SettingUnit::findOrFail($id);

        $validated = $request->validate(
            [
                'code' => 'required|unique:setting_units,code,' . $unit->id,
                'name' => 'required|string'
            ],
        );
        DB::beginTransaction();
        try {
            $unit->update($validated);

            $log  = $this->LogSettingUnit($unit->id, 'Update', json_encode($unit));

            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di ubah']);
            ;
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

   
    public function destroy(string $id)
    {
        $unit = SettingUnit::findOrFail($id);

        DB::beginTransaction();
        try {
            $log  = $this->LogSettingUnit($unit->id, 'Delete', json_encode($unit));
            $unit->delete();
            DB::commit();
            return response()->json(['status' => 200, 'text' => 'Data berhasil di hapus']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 400, 'text' => $th->getMessage()]);
        }
    }

    private function LogSettingUnit($id, $activity, $details)
    {
        SettingUnitLog::create([
            'setting_unit_id' => $id,
            'activity' => $activity,
            'note' => $details,
            'user_id' => Auth::id(),
        ]);
    }
}
