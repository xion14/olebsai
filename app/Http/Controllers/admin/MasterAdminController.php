<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasterAdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 1) abort(403);
        $users = User::whereIn('role', [1,2,5,6,7]) // admin variants
                    ->orderBy('name')
                    ->get(['id','name','email','role']);
        $roles = [
            1 => 'Super Admin',
            2 => 'Admin',
            5 => 'Admin Register',
            6 => 'Admin User',
            7 => 'Admin Konsumen'
        ];
        $menuMap = $this->loadMenuMap();
        return view('admin.master.admins', compact('users','roles','menuMap'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role != 1) abort(403);
        $validated = $request->validate([
            'role' => 'required|integer|in:1,2,5,6,7'
        ]);
        $user = User::findOrFail($id);
        $user->role = $validated['role'];
        $user->save();

        return response()->json(['status'=>200,'text'=>'Role diperbarui']);
    }

    public function updateMenuMap(Request $request)
    {
        if (Auth::user()->role != 1) abort(403);

        $data = $request->validate([
            'menu' => 'required|array',
            'menu.*' => 'array'
        ]);

        $menu = [];
        foreach ($data['menu'] as $key => $roles) {
            $menu[$key] = array_map('intval', $roles);
        }
        $this->saveMenuMap($menu);

        return response()->json(['status'=>200,'text'=>'Menu-role mapping diperbarui']);
    }

    private function loadMenuMap()
    {
        if (Storage::exists('menu_roles.json')) {
            $json = json_decode(Storage::get('menu_roles.json'), true);
            if (is_array($json)) return $json;
        }
        return config('menu_roles', []);
    }

    private function saveMenuMap(array $map)
    {
        Storage::put('menu_roles.json', json_encode($map, JSON_PRETTY_PRINT));
    }
}
