<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['product', 'user']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('note', 'like', '%' . $request->search . '%')
                  ->orWhereHas('product', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();
        
        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'filters' => $request->only(['search', 'start_date', 'end_date']),
        ]);
    }

    public function create()
    {
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

        if ($request->type == 'out' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi! Sisa stok saat ini: ' . $product->stock])->withInput();
        }

        Transaction::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        if ($request->type == 'in') {
            $product->increment('stock', $request->quantity);
        } else {
            $product->decrement('stock', $request->quantity);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diproses! Stok telah diperbarui.');
    }
}