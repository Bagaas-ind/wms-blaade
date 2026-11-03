<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController; // Tambahan untuk Kategori
use App\Http\Controllers\SupplierController; // Tambahan untuk Supplier
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

Route::get('/dashboard', function () {
    $totalKategori = Category::count();
    $totalSupplier = Supplier::count();
    $totalProduk = Product::count();
    
    return view('dashboard', compact('totalKategori', 'totalSupplier', 'totalProduk'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // --- Bawaan Laravel Breeze (JANGAN DIHAPUS) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- Tambahan Kita (Sistem Gudang) ---
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class); // <-- TAMBAHKAN INI
});

require __DIR__.'/auth.php';