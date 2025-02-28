<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

Route::apiResource('orders', OrderController::class);
Route::post('orders/{order}/approve', [OrderController::class, 'approve']);
