<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
         
        Role::create([
            'name' => 'super admin',
            'guard_name' => 'admin', 
        ]);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'admin', 
        ]);
        Role::create([
            'name' => 'customer',
            'guard_name' => 'customer', 
        ]);
        Role::create([
            'name' => 'seller',
            'guard_name' => 'seller', 
        ]);
    }
}
