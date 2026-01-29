<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SettingContactAdmin;
use Illuminate\Support\Facades\Auth;
use Log;

class SettingContactAdminController extends Controller
{
    public function index () {
        $data = SettingContactAdmin::first();
        $admin_priviledge_id = Auth::user()->admin_priviledge;
        Log::info('admin_priviledge_id =====> '.$admin_priviledge_id);
        return view('admin.setting.contact-admin.index', compact('data'));
    }

    public function update (Request $request) {
        $data = SettingContactAdmin::first();
		
        $data->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
}
