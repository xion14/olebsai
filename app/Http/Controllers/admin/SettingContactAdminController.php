<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SettingContactAdmin;

class SettingContactAdminController extends Controller
{
    public function index () {
        $data = SettingContactAdmin::first();
        return view('admin.setting.contact-admin.index', compact('data'));
    }

    public function update (Request $request) {
        $data = SettingContactAdmin::first();
        $data->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }
}
