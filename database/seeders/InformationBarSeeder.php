<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingInformationBar;

class InformationBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingInformationBar::truncate();
        SettingInformationBar::create([
            'text' => 'This is an information bar.',
        ]);
    }
}
