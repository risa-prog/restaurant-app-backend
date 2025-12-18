<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('menus')->insert([
             [
                'name' => 'ハンバーガー',
                'description' => '小ぶりだけどジューシーな定番バーガー。',
                'price' => 500,
                'image_url' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'チーズバーガー',
                'description' => 'とろけるチーズが魅力。',
                'price' => 550,
                'image_url' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'コーラ',
                'description' => 'さっぱり爽快、セットでどうぞ。',
                'price' => 150,
                'image_url' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
