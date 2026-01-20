<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $root = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@olebsai.com',
            'password' => bcrypt('12345'),
            'phone' => '088888888',
            'role' => 1,
        ]);

        $role = Role::where('name', 'super admin')->where('guard_name', 'admin')->first();
        $root->assignRole($role);

   

        $sellerRole = Role::where('name', 'seller')->where('guard_name', 'seller')->first();
        
        $faker = Faker::create('id_ID'); // Menggunakan lokal Indonesia
        
        for ($i = 1; $i <= 20; $i++) {
            // Buat nama khas Indonesia
            $fullName = $faker->firstName . ' ' . $faker->lastName;
        
            // Buat email yang lebih lokal
            $emailUsername = Str::slug($fullName, '.'); // Ubah nama jadi format email
            $emailDomains = 'olebsai.com';
            $email = strtolower($emailUsername . rand(10, 99) . '@' . $emailDomains);
        
            // Buat akun user
            $dummySeller = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => bcrypt('12345'),
                'phone' => $faker->numerify('08##########'), // Format nomor Indonesia
                'role' => 4,
            ]);
        
            $dummySeller->assignRole($sellerRole);
        }
        
    }
}