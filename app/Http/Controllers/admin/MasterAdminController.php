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

    public function create()
    {
        if (Auth::user()->role != 1) abort(403);
        return view('admin.master.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role != 1) abort(403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'role' => 'required|integer|in:1,2,5,6,7'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role']
        ]);

        return response()->json(['status'=>200, 'text'=>'Admin ditambahkan', 'user'=>$user]);
    }

    public function updateMenuMap(Request $request)
    {
        if (Auth::user()->role != 1) abort(403);
        try {
            $incomingMenu = $request->input('menu', []);
            $existing = $this->loadMenuMap();
            $newMap = [];
            foreach ($existing as $key => $roles) {
                $incoming = $incomingMenu[$key] ?? [];
                $newMap[$key] = array_values(array_map('intval', (array)$incoming));
            }
            $this->saveMenuMap($newMap);
            return response()->json(['status'=>200,'text'=>'Menu-role mapping diperbarui']);
        } catch (\Throwable $e) {
            \Log::error('menu_map_save_error', ['msg'=>$e->getMessage()]);
            return response()->json(['status'=>400,'text'=>'Gagal menyimpan mapping: '.$e->getMessage()], 400);
        }
    }

    private function loadMenuMap()
    {
        $default = config('menu_roles', []);
        if (Storage::exists('menu_roles.json')) {
            $json = json_decode(Storage::get('menu_roles.json'), true);
            if (is_array($json)) {
                return array_merge($default, $json);
            }
        }
        return $default;
    }

    private function saveMenuMap(array $map)
    {
        Storage::disk('local')->put('menu_roles.json', json_encode($map, JSON_PRETTY_PRINT));
    }
}
