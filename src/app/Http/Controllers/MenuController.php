<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index() {
        try{
            $menus = Menu::all();

            return response()->json([
                'data' => $menus
            ], 200);

        }catch(\Exception $e){

            Log::error($e);

            return response()->json([
                'message' => 'サーバーエラーです'
            ], 500);
        }
    }
}
