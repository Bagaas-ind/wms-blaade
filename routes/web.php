<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Transaction;

// ... (kode rute lainnya)

Route::get('/dashboard', function () {
    // Data untuk Grafik 7 Hari
    $weekly = collect(range(6, 0))->map(function ($i) {
        $d = now()->subDays($i);
        return [
            'label' => $d->translatedFormat('D'),
            'total' => \App\Models\Transaction::whereDate('created_at', $d)->count(),
        ];
    });

    return Inertia::render('Dashboard', [
        'totalProducts' => \App\Models\Product::count(),
        'totalCategories' => \App\Models\Category::count(),
        'totalSuppliers' => \App\Models\Supplier::count(),
        'totalTransactions' => \App\Models\Transaction::count(),
        'lowStockProducts' => \App\Models\Product::whereColumn('stock', '<=', 'min_stock')->take(5)->get(),
        // Tambahan baru:
        'weeklyTransactions' => $weekly,
        'recentTransactions' => \App\Models\Transaction::with('product')->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // SISTEM GUDANG (Wajib ada semua)
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    
    // INI YANG BIKIN MENU TRANSAKSI BISA DIKLIK
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
});

require __DIR__.'/auth.php';