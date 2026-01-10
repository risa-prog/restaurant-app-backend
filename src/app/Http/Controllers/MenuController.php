<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request) {
        $query = Menu::query();

        if($request->boolean('is_active')){
            $query->where('is_active', true);
        }

        if($request->get('sort') === 'created_at_desc'){
            $query->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc'); 
        }

        $menus = $query->get();

        $menus->transform(function ($menu){
            $menu->image_url = $menu->image_url ? asset('/storage/' . $menu->image_url) : null;
            return $menu;
        });

        return response()->json([
            'data' => $menus
        ], 200);
    }

    public function show(Menu $menu) {
        $image_url = $menu->image_url ? asset('storage/' . $menu->image_url) : null;
       return response()->json([
        'data' => $menu,
        'image_url' => $image_url,
       ]);
    }

    public function store(Request $request) {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:1',
                'is_active' => 'required|in:0,1',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:10240', 
            ], [
                'name.required' => '名前を入力してください',
                'name.string' => '名前は文字列で入力してください',
                'name.max' => '名前は255文字以内で入力してください',
                'price.required' => '価格を入力してください',
                'price.numeric' => '価格は数字で入力してください',
                'price.min' => '価格は1円以上で入力してください',
                'is_active.required' => '状態を指定してください',
                'is_active.boolean' => '状態が不正です',
                'description.string' => '説明は文字列で入力してください',
                'description.max' => '説明は255文字以内で入力してください',
                'image.image' => '画像ファイルをアップロードしてください',
                'image.max' => '画像サイズは10MB以内にしてください',
            ]);
        }catch(ValidationException $e){
                return response()->json([
                    'message' => '入力エラーです',
                    'errors' => $e->errors(),
                ], 422);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'name' => $validated['name'],
            'price' => (int) $validated['price'],
            'is_active' => (bool) $validated['is_active'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imagePath,
        ]);

        return response()->json([
            'message' => 'メニューを作成しました',
        ], 201);
    }

    public function updateMenu(Menu $menu, Request $request) {
         try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:1',
                'is_active' => 'required|in:0,1',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:10240', 
                'remove_image' => 'nullable|boolean',
            ], [
                'name.required' => '名前を入力してください',
                'name.string' => '名前は文字列で入力してください',
                'name.max' => '名前は255文字以内で入力してください',
                'price.required' => '価格を入力してください',
                'price.numeric' => '価格は数字で入力してください',
                'price.min' => '価格は1円以上で入力してください',
                'is_active.required' => '状態を指定してください',
                'is_active.in' => '状態が不正です',
                'description.string' => '説明は文字列で入力してください',
                'description.max' => '説明は255文字以内で入力してください',
                'image.image' => '画像ファイルをアップロードしてください',
                'image.max' => '画像サイズは10MB以内にしてください',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'message' => '入力エラーです',
                'errors' => $e->errors(),
            ], 422);
        }

        $imagePath = $menu->image_url; 

        if ($request->hasFile('image')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete($menu->image_url);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        if ($request->boolean('remove_image') && !$request->hasFile('image')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete($menu->image_url);
            }
            $imagePath = null;
        }

        $menu->update([
            'name' => $validated['name'],
            'price' => (int) $validated['price'],
            'is_active' => (bool) $validated['is_active'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imagePath ?? null,
        ]);

        return response()->json([
                'message' => 'メニューを更新しました',
        ], 200);
    }
}
