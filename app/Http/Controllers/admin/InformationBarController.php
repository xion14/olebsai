<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingInformationBar;

class InformationBarController extends Controller
{
    public function index()
    {
        $information = SettingInformationBar::first();
        return view('admin.information-bar.index', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = SettingInformationBar::find($id);
        $information->update($request->all());
        return redirect()->route('admin.information-bar.index')->with('success', 'Information Bar updated successfully');
    }
}
