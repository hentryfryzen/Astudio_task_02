<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

Route::post('/orders', [OrderController::class, 'createOrder']);
Route::get('/orders', [OrderController::class, 'getAllOrders']);
Route::get('/orders/{id}', [OrderController::class, 'getOrder']);
Route::put('/orders/{id}/approval', [OrderController::class, 'processApproval']);
Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);
