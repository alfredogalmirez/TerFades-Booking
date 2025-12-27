<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'name' => 'Haircut',
                'duration_minutes' => 30,
                'price' => 150.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
             [
                'name' => 'Beard Trim',
                'duration_minutes' => 15,
                'price' => 80.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
             [
                'name' => 'Haircut + Shampoo',
                'duration_minutes' => 45,
                'price' => 220.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
