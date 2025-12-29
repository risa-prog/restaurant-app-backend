<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

Route::get('/menus', [MenuController::class, 'index']);
Route::get('/orders',[OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::patch('/orders/{order}', [OrderController::class, 'updateStatus']);
Route::get('/orders/{order}/items', [OrderItemController::class, 'index']);
Route::post('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
