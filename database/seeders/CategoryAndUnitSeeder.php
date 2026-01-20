<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryAndUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori UMKM
        $categories = [
            ['name' => 'Makanan & Minuman', 'image' => 'makanan.png'],
            ['name' => 'Kerajinan Tangan', 'image' => 'kerajinan.png'],
            ['name' => 'Pakaian & Tekstil', 'image' => 'pakaian.png'],
            ['name' => 'Elektronik & Aksesoris', 'image' => 'elektronik.png'],
            ['name' => 'Kosmetik & Kesehatan', 'image' => 'kosmetik.png']
        ];

        // Data unit produk
        $units = [
            'Pcs', 'Kg', 'Liter', 'Pack', 'Dus'
        ];

        // Insert ke tabel setting_categories
        $categoryData = [];
        foreach ($categories as $index => $category) {
            $categoryData[] = [
                'code' => 'CAT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT), // Kode unik (CAT001, CAT002, ...)
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'image' => $category['image'],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert ke tabel setting_units
        $unitData = [];
        foreach ($units as $index => $unit) {
            $unitData[] = [
                'code' => 'UNIT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT), // Kode unik (UNIT001, UNIT002, ...)
                'name' => $unit,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('setting_categories')->insert($categoryData);
        DB::table('setting_units')->insert($unitData);
    }
}
