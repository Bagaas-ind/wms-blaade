<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Ringkasan Sistem Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card Kategori -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border-l-4 border-blue-500 p-6">
                    <div class="text-gray-500 text-sm font-medium">Total Kategori</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalKategori }}</div>
                </div>
                
                <!-- Card Supplier -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border-l-4 border-green-500 p-6">
                    <div class="text-gray-500 text-sm font-medium">Total Supplier</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalSupplier }}</div>
                </div>

                <!-- Card Produk -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border-l-4 border-orange-500 p-6">
                    <div class="text-gray-500 text-sm font-medium">Total Produk</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalProduk }}</div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600">Ini adalah sistem manajemen gudang (Warehouse Management System). Silakan gunakan menu di atas untuk mengelola Kategori, Supplier, Produk, dan Transaksi.</p>
            </div>
        </div>
    </div>
</x-app-layout>