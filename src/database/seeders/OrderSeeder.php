<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'table_number' => 1,
                'status' => 'pending',
                'total_price' => 1100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'table_number' => 2,
                'status' => 'completed',
                'total_price' => 2700,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
