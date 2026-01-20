<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingAboutUs;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingAboutUs::truncate();
        $data = [
            [
                'key' => 'main',
                'title' => 'Belanja barang tradisional di Olebsai',
                'subtitle' => 'Rasakan keindahan budaya, beli barang tradisional sekarang',
                'image' => 'banner_about_1.jpg',
                'is_deleteable' => false,
            ],
            [
                'key' => 'about',
                'title' => 'Tingkatkan koleksi Anda dengan barang-barang tradisional unik',
                'subtitle' => 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.',
                'image' => null,
                'is_deleteable' => false
            ],
            [
                'key' => 'mission',
                'title' => 'Kami ingin membentuk dan memajukan usaha lokal di Indonesia',
                'subtitle' => 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.',
                'image' => 'content_about.jpg',
                'is_deleteable' => false
            ],
            [
                'key' => 'impact',
                'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'subtitle' => 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.',
                'image' => 'content_about_1.jpg',
                'is_deleteable' => true,            
            ],
            [
                'key' => 'impact',
                'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'subtitle' => 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.',
                'image' => 'content_about_2.jpg',
                'is_deleteable' => true,            
            ],
            [
                'key' => 'impact',
                'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'subtitle' => 'Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan usaha lokal.',
                'image' => 'content_about_3.jpg',
                'is_deleteable' => true,            
            ]
        ];

        SettingAboutUs::insert($data);
    }
}
