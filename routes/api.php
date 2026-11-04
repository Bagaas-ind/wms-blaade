<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RackController;
use App\Http\Controllers\OutboundController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// TAMBAHKAN ROUTE KITA DI SINI
Route::get('/racks', [RackController::class, 'index']);
Route::get('/outbound/{id}/picking-list', [OutboundController::class, 'generatePickingList']);