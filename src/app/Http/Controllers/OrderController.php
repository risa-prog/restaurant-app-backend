<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'tableNumber' => 'required|integer',
            'items' => 'required|array|min: 1',
            'items.*.menuId' => 'required|integer|exists:menus,id',
            'items.*.quantity' => 'required|integer|min: 1',   
        ]);

        try{
        DB::transaction(function () use ($validated){
            $order = Order::create([
                'table_number' => $validated['tableNumber'],
            ]);

            $total = 0;

            foreach($validated['items'] as $item) {
                $menu = Menu::findOrFail($item['menuId']);
                OrderItem::create([
                    'menu_id' => $menu->id,
                    'order_id' => $order->id,
                    'price_at_order' => $menu->price,
                    'quantity' => $item['quantity'],
                ]);
                 $total += $menu->price * $item['quantity'];
            }
                $order->update(['total_price' => $total]);
            });

            return response()->json([
                    'message' => '注文が完了しました'
                ], 201);
        }catch(\Throwable $e) {
             Log::error($e);
             return response()->json([
            'message' => '注文の作成に失敗しました'
        ], 500);
        }
    }   
}