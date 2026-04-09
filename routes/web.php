<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

Route::get('/test-policy', function () {
    $product = Product::first();

    if (!$product) {
        return "DATA PRODUCT KOSONG";
    }

    if (Auth::user()->can('delete', $product)) {
        return "BOLEH HAPUS";
    } else {
        return "TIDAK BOLEH";
    }
})->middleware('auth');

Route::get('/export-product', function () {
    if (!Gate::allows('export-product')) {
        abort(403);
    }

    return "Export berhasil!";
})->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/about', [AboutController::class, 'index'])
    ->middleware(['auth'])
    ->name('about');

require __DIR__.'/auth.php';
