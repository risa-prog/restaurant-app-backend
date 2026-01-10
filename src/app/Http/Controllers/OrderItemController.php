<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderItemController extends Controller
{
    public function index(Order $order) {
        $items = $order->items()->with('menu')->get();
        return response()->json([
            'data' => $items
        ], 200);
    }
}
