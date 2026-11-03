<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController; // Tambahan untuk Kategori
use App\Http\Controllers\SupplierController; // Tambahan untuk Supplier

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // --- Bawaan Laravel Breeze (JANGAN DIHAPUS) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- Tambahan Kita (Sistem Gudang) ---
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
});

require __DIR__.'/auth.php';