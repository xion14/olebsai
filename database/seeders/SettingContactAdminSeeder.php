<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingContactAdmin;

class SettingContactAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingContactAdmin::truncate();
        
        $data = [
            [
                'key' => 'admin_contact',
                'name' => 'Admin',
                'contact' => '81392460980'
            ]
        ];

        SettingContactAdmin::insert($data);
    }
}
