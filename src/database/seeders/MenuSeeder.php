<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => '焼き魚定食',
                'description' => '新鮮な魚を香ばしく焼き上げたヘルシー定食です。',
                'price' => 1100,
                'image_url' => '0adpDSC_1872.jpg',
                'is_active' => true,
            ],
            [
               'name' => 'スタミナ定食',
                'description' => 'ニンニクと野菜たっぷりのスタミナ満点定食です。',
                'price' => 1200,
                'image_url' => 'adpDSC_6896.jpg',
                'is_active' => true,
            ],
            [
                'name' => '焼肉定食',
                'description' => 'タレで味付けした牛肉を香ばしく焼き上げた定食です。',
                'price' => 1500,
                'image_url' => 'adpTER-1087.jpg',
                'is_active' => true,
            ],
            [
                'name' => '味噌カツ定食',
                'description' => 'ジューシーな豚カツに特製味噌ダレをかけた定食です。',
                'price' => 1200,
                'image_url' => '0adpDSC_7887.jpg',
                'is_active' => true,
            ],
        ];
        
        foreach ($menus as $menu) {
            $sourceImage = public_path("seed-images/{$menu['image_url']}");
            $destPath = "menus/{$menu['image_url']}";
            
            Storage::disk('public')->putFileAs('menus', $sourceImage, $menu['image_url']);

            Menu::create([
                'name' => $menu['name'],
                'description' => $menu['description'],
                'price' => $menu['price'],
                'image_url' => $destPath,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
