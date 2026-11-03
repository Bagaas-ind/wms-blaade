<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import JsBarcode from 'jsbarcode';

defineProps({ products: Object });

const deleteProduct = (id) => {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        router.delete(route('products.destroy', id));
    }
};

onMounted(() => {
    const barcodes = document.querySelectorAll('.barcode-svg');
    barcodes.forEach((el) => {
        JsBarcode(el, el.dataset.code, {
            format: "CODE128",
            lineColor: "#000", // Barcode tetap hitam agar bisa discan
            width: 1.5,
            height: 40,
            displayValue: true,
            fontSize: 12,
            background: "#ffffff" // Barcode background putih
        });
    });
});
</script>

<template>
    <Head title="Manajemen Produk" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">Manajemen Produk</h2>
        </template>

        <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Card Container -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    
                    <!-- Action Buttons -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <Link :href="route('products.create')" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 transform hover:scale-105 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Produk
                        </Link>
                        
                        <button onclick="window.print()" class="w-full sm:w-auto bg-gray-800 dark:bg-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan Stok
                        </button>
                    </div>

                    <!-- Table Container -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barcode</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Produk</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider aksi-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <!-- Barcode Cell -->
                                    <td class="py-4 px-4">
                                        <div class="bg-white p-1 rounded w-max shadow-sm border border-gray-200">
                                            <svg class="barcode-svg" :data-code="product.sku"></svg>
                                        </div>
                                    </td>
                                    
                                    <!-- Name -->
                                    <td class="py-4 px-4 text-sm font-bold text-gray-800 dark:text-gray-100">{{ product.name }}</td>
                                    
                                    <!-- Category -->
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-300">
                                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-1 px-3 rounded-full text-xs font-semibold">
                                            {{ product.category?.name }}
                                        </span>
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200 text-right font-medium">
                                        Rp {{ new Intl.NumberFormat('id-ID').format(product.price) }}
                                    </td>
                                    
                                    <!-- Stock -->
                                    <td class="py-4 px-4 text-center">
                                        <span :class="product.stock <= product.min_stock ? 'text-red-600 dark:text-red-400 font-black' : 'text-gray-800 dark:text-gray-200 font-bold'">
                                            {{ product.stock }}
                                        </span>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="py-4 px-4 text-center aksi-print">
                                        <div class="flex items-center justify-center gap-3">
                                            <Link :href="route('products.edit', product.id)" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-semibold text-sm">
                                                Edit
                                            </Link>
                                            <button @click="deleteProduct(product.id)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold text-sm">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="products.data.length === 0">
                                    <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        Belum ada data produk. Silakan tambahkan produk baru.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@media print {
    nav, header, .aksi-print, button, a[href="/products/create"] {
        display: none !important;
    }
    body { background-color: white; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; color: black !important; }
    .bg-white { background-color: white !important; }
}
</style>