<?php

namespace Database\Seeders;

use App\Models\{Siswa,User};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'buyung',
            'email' => 'buyung@buyung.buyung',
            'password' => Hash::make('buyung'), // Default password
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'abimanyu',
            'email' => 'abimanyu@abimanyu.abimanyu',
            'password' => Hash::make('abimanyu'),
            'email_verified_at' => now(),
            'is_guru' => true,
        ]);

        User::create([
            'name' => 'galuh',
            'email' => 'galuh@galuh.galuh',
            'password' => Hash::make('galuh'),
            'email_verified_at' => now(),
            'is_guru' => true,
        ]);

        $user1 = User::create([
            'name' => 'setiawan',
            'email' => 'setiawan@setiawan.setiawan',
            'password' => Hash::make('setiawan'),
            'email_verified_at' => now(),
            'is_siswa' => true,
        ]);
        
        Siswa::create([
            'user_id' => $user1->id, // Use the $user1 instance to get the id
            'school'  => 'SMA',
            'phone'   => '081234567890',
            'status'  => 1,
        ]);
        
        $user2 = User::create([
            'name' => 'Hendrik',
            'email' => 'hendrik@hendrik.hendrik',
            'password' => Hash::make('hendrik'),
            'email_verified_at' => now(),
        ]);
        
        Siswa::create([
            'user_id' => $user2->id, // Use the $user2 instance to get the id
            'school'  => 'SMA',
            'phone'   => '081234567890',
            'status'  => 0,
        ]);
        
        $user3 = User::create([
            'name' => 'Petrik',
            'email' => 'petrik@petrik.petrik',
            'password' => Hash::make('petrik'),
            'email_verified_at' => now(),
        ]);
        
        Siswa::create([
            'user_id' => $user3->id, // Use the $user3 instance to get the id
            'school'  => 'SMA',
            'phone'   => '081234567890',
            'status'  => 0,
        ]);   
    }
}
