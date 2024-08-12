<?php

namespace Database\Seeders;

use App\Models\Bimbel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BimbelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bimbel::create([
            'title'         =>  'Matematika',
            'description'   =>  'Class matematika',
            'harga'         =>  75000,
            'day_start'     =>  1,
            'day_end'       =>  3,
            'time_start'    =>  '14:00',
            'time_end'      =>  '16:00',
        ]);

        Bimbel::create([
            'title'         =>  'Fisika',
            'description'   =>  'Class fisika',
            'harga'         =>  100000,
            'day_start'     =>  4,
            'day_end'       =>  6,
            'time_start'    =>  '14:00',
            'time_end'      =>  '16:30',
        ]);

        Bimbel::create([
            'title'         =>  'Laravel 11',
            'description'   =>  'Class laravel versi 11',
            'harga'         =>  200000,
            'day_start'     =>  1,
            'day_end'       =>  5,
            'time_start'    =>  '08:00',
            'time_end'      =>  '10:00',
        ]);
    }
}
