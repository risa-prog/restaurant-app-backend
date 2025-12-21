<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
             [
                'menu_id' => 1,
                'order_id' => 1,
                'price_at_order' => 500,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'menu_id' => 2,
                'order_id' => 1,
                'price_at_order' => 150,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'menu_id' => 2,
                'order_id' => 2,
                'price_at_order' => 550,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'menu_id' => 3,
                'order_id' => 2,
                'price_at_order' => 150,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
