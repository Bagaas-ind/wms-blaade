<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil riwayat beserta nama produk dan nama user yang input
        $transactions = Transaction::with(['product', 'user'])->latest()->paginate(10);
        
        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        // Mengirim data produk untuk pilihan di dropdown
        return Inertia::render('Transactions/Create', [
            'products' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        // LOGIKA WMS: Cek stok jika barang keluar
        if ($request->type == 'out' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi! Sisa stok saat ini: ' . $product->stock])->withInput();
        }

        // 1. Simpan riwayat transaksi
        Transaction::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(), // Otomatis mencatat siapa yang login
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        // 2. Update stok di tabel produk
        if ($request->type == 'in') {
            $product->increment('stock', $request->quantity); // Stok nambah
        } else {
            $product->decrement('stock', $request->quantity); // Stok ngurang
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diproses! Stok telah diperbarui.');
    }
}