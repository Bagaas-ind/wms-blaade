<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Menampilkan daftar kategori
    public function index()
    {
        // Ambil data terbaru, 10 per halaman
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    // 2. Menampilkan form tambah
    public function create()
    {
        return view('categories.create');
    }

    // 3. Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 4. Form edit (Tidak dipakai jika tidak ada parameter ID)
    public function show(Category $category)
    {
        // Kosongkan saja, kita tidak pakai halaman detail untuk kategori
    }

    // 5. Menampilkan form edit
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 6. Menyimpan perubahan data
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 7. Menghapus data
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}