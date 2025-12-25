<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderItemController extends Controller
{
    public function index(Order $order) {
        try{
            $items = $order->items()->with('menu')->get();
            return response()->json([
                'data' => $items
            ], 200);
        }catch(\Throwable $e){
            Log::error($e);

            return response()->json([
                'message' => 'サーバーエラーです'
            ], 500);
        }
    }
}
