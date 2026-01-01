<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request) {
            $query = Menu::query();

            if($request->boolean('is_active')){
                $query->where('is_active', true);
            }

            if($request->get('sort') === 'created_at_desc'){
                $query->orderBy('created_at', 'desc');
            }

            $menus = $query->get();

            return response()->json([
                'data' => $menus
            ], 200);
    }
}
