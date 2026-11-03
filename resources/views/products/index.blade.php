<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        + Tambah Produk
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">SKU</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Produk</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Kategori</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Supplier</th>
                                <th class="py-3 px-4 border-b text-right text-sm font-semibold text-gray-600">Harga</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Stok</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b font-mono text-sm">{{ $product->sku }}</td>
                                <td class="py-3 px-4 border-b font-medium">{{ $product->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $product->category->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $product->supplier ? $product->supplier->name : '-' }}</td>
                                <td class="py-3 px-4 border-b text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b text-center">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data produk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>