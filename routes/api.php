<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login', [AuthController::class, 'getToken']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute yang butuh token API (Auth Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Route Product yang butuh auth
    Route::get('/product', [ProductController::class, 'index']); // Tambah ini
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']); // Tambah ini
    Route::delete('/product/{id}', [ProductController::class, 'destroy']); // Tambah ini
    
    // Route Category (yang sudah dibuat sebelumnya)
    Route::apiResource('category', CategoryController::class); 
});


// Rute publik (tanpa token)
Route::get('/product/{id}', [ProductController::class, 'show']);