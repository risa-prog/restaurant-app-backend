<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
