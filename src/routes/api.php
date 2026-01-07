<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{menu}', [MenuController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order}/items', [OrderItemController::class, 'index']);

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/menus', [MenuController::class, 'store']);
    Route::patch('/menus/{menu}', [MenuController::class, 'updateMenu']);
    
    Route::get('/orders', [OrderController::class, 'index']);
    Route::patch('/orders/{order}', [OrderController::class, 'updateStatus']);
});

