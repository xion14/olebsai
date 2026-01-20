<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SellerAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Set bahasa Indonesia
        
        $sellers = [];
        $products = [];

        // Pemetaan kategori ke unit_id
        $unitMap = [
            1 => [1, 2], // Makanan & Minuman (Pcs, Kg)
            2 => [1],    // Kerajinan Tangan (Pcs)
            3 => [1],    // Pakaian & Tekstil (Pcs)
            4 => [1],    // Elektronik & Aksesoris (Pcs)
            5 => [1, 3]  // Kosmetik & Kesehatan (Pcs, Liter)
        ];

        // Kategori Produk UMKM dan Daftar Produk dengan Deskripsi
        $categories = [
            1 => ['name' => 'Makanan & Minuman', 'products' => [
                ['name' => 'Keripik Balado', 'desc' => 'Keripik singkong renyah dengan cita rasa pedas manis khas Minang.'],
                ['name' => 'Bakpia Pathok', 'desc' => 'Kue khas Yogyakarta dengan isian kacang hijau lembut dan kulit renyah.'],
                ['name' => 'Pempek Palembang', 'desc' => 'Hidangan ikan tenggiri khas Palembang dengan kuah cuko yang asam dan pedas.'],
                ['name' => 'Kopi Toraja', 'desc' => 'Kopi arabika premium dari Toraja dengan aroma khas dan rasa yang kaya.'],
                ['name' => 'Dodol Betawi', 'desc' => 'Dodol khas Betawi dengan tekstur kenyal dan rasa manis legit.']
            ]],
            2 => ['name' => 'Kerajinan Tangan', 'products' => [
                ['name' => 'Kerajinan Anyaman', 'desc' => 'Anyaman tangan dari bahan alami seperti bambu dan rotan.'],
                ['name' => 'Batik Pekalongan', 'desc' => 'Kain batik khas Pekalongan dengan motif klasik dan elegan.'],
                ['name' => 'Patung Kayu', 'desc' => 'Patung ukiran kayu dari pengrajin lokal, cocok untuk dekorasi rumah.'],
                ['name' => 'Lukisan Tradisional', 'desc' => 'Lukisan etnik dengan nuansa budaya Indonesia yang artistik.'],
                ['name' => 'Aksesoris Etnik', 'desc' => 'Gelang, kalung, dan anting handmade dengan sentuhan budaya nusantara.']
            ]],
            3 => ['name' => 'Pakaian & Tekstil', 'products' => [
                ['name' => 'Batik Solo', 'desc' => 'Kain batik dengan motif klasik khas Solo, cocok untuk pakaian formal.'],
                ['name' => 'Sarung Tenun', 'desc' => 'Sarung tradisional hasil tenunan tangan dengan motif elegan.'],
                ['name' => 'Jaket Kulit Garut', 'desc' => 'Jaket kulit asli dari Garut yang stylish dan tahan lama.'],
                ['name' => 'Kain Ulos', 'desc' => 'Kain tradisional Batak yang sering digunakan dalam acara adat.'],
                ['name' => 'Kaos Lukis', 'desc' => 'Kaos berbahan katun premium dengan desain lukisan tangan unik.']
            ]],
            4 => ['name' => 'Elektronik & Aksesoris', 'products' => [
                ['name' => 'Lampu Hias Unik', 'desc' => 'Lampu dekoratif handmade dari bahan kayu dan rotan.'],
                ['name' => 'Speaker Kayu', 'desc' => 'Speaker portable dengan casing kayu dan suara berkualitas.'],
                ['name' => 'Jam Tangan Kayu', 'desc' => 'Jam tangan eksklusif berbahan kayu dengan desain minimalis.'],
                ['name' => 'Power Bank Batik', 'desc' => 'Power bank dengan motif batik eksklusif yang unik.'],
                ['name' => 'Flashdisk Anyaman', 'desc' => 'Flashdisk dengan casing berbahan anyaman bambu, ringan dan elegan.']
            ]],
            5 => ['name' => 'Kosmetik & Kesehatan', 'products' => [
                ['name' => 'Minyak Kayu Putih', 'desc' => 'Minyak esensial alami yang memberikan efek hangat dan menenangkan.'],
                ['name' => 'Sabun Organik', 'desc' => 'Sabun berbahan alami yang cocok untuk kulit sensitif.'],
                ['name' => 'Masker Herbal', 'desc' => 'Masker wajah dari bahan alami untuk perawatan kulit.'],
                ['name' => 'Lulur Tradisional', 'desc' => 'Lulur tubuh dari rempah-rempah pilihan untuk kulit lebih cerah.'],
                ['name' => 'Essential Oil', 'desc' => 'Minyak aromaterapi yang membantu relaksasi dan meningkatkan mood.']
            ]]
        ];

        for ($i = 0; $i < 20; $i++) {
            $sellerId = $i + 1;
            $userId = $sellerId + 1;
            $sellers[] = [
                'user_id' => $userId,
                'name' => $faker->company,
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->numerify('08##########'),
                'address' => $faker->address,
                'city' => $faker->city,
                'province' => $faker->state,
                'country' => 'Indonesia',
                'zip' => $faker->postcode,
                'status' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $categoryKeys = array_rand($categories, rand(2, 4));
            if (!is_array($categoryKeys)) {
                $categoryKeys = [$categoryKeys];
            }

            foreach ($categoryKeys as $categoryId) {
                $selectedProducts = $categories[$categoryId]['products'];
                shuffle($selectedProducts);

                foreach (array_slice($selectedProducts, 0, rand(1, 3)) as $product) {
                    // Pilih unit_id secara acak berdasarkan kategori
                    $unitIds = $unitMap[$categoryId];
                    $unitId = $unitIds[array_rand($unitIds)];

                    $products[] = [
                        'seller_id' => $sellerId,
                        'code' => strtoupper(Str::random(10)),
                        'name' => $product['name'],
                        'category_id' => $categoryId,
                        'unit_id' => $unitId,
                        'stock' => rand(10, 100),
                        'price' => rand(50000, 500000),
                        'slug' => Str::slug($product['name']),
                        'image_1' => Str::slug($product['name']) . '.jpg',
                        'description' => $product['desc'],
                        'status' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('sellers')->insert($sellers);
        DB::table('products')->insert($products);
    }
}
