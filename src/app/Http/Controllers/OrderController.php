<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('items.menu')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $orders,
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'tableNumber' => 'required|integer',
            'items' => 'required|array|min: 1',
            'items.*.menuId' => 'required|integer|exists:menus,id',
            'items.*.quantity' => 'required|integer|min: 1',   
        ]);

        $order = DB::transaction(function () use ($validated){
            $createdOrder = Order::create([
                'table_number' => $validated['tableNumber'],
            ]);

            $total = 0;

            foreach($validated['items'] as $item) {
                $menu = Menu::find($item['menuId']);
                OrderItem::create([
                    'menu_id' => $menu->id,
                    'order_id' => $createdOrder->id,
                    'price_at_order' => $menu->price,
                    'quantity' => $item['quantity'],
                ]);
                 $total += $menu->price * $item['quantity'];
            }

            $createdOrder->update(['total_price' => $total]);

            return $createdOrder;
        });

        return response()->json([
            'message' => '注文が完了しました',
            'order_id' => $order->id
        ], 201);
    }
    
    public function updateStatus(Request $request, Order $order) {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'message' => '注文ステータスを更新しました',
            'data' => $order,
        ], 200);
    }
}