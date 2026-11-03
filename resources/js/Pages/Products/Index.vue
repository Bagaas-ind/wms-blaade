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

// Fungsi untuk generate barcode setelah halaman diload
onMounted(() => {
    const barcodes = document.querySelectorAll('.barcode-svg');
    barcodes.forEach((el) => {
        JsBarcode(el, el.dataset.code, {
            format: "CODE128",
            lineColor: "#000",
            width: 1.5,
            height: 40,
            displayValue: true,
            fontSize: 12
        });
    });
});
</script>

<template>
    <Head title="Manajemen Produk" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Produk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4 flex justify-between items-center">
                        <Link :href="route('products.create')" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tambah Produk</Link>
                        
                        <!-- Tombol Cetak PDF Laporan Stok -->
                        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-900">
                            🖨️ Cetak Laporan Stok
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Barcode</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Produk</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Kategori</th>
                                    <th class="py-3 px-4 border-b text-right text-sm font-semibold text-gray-600">Harga</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Stok</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600 aksi-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50">
                                    <!-- Menampilkan Barcode -->
                                    <td class="py-3 px-4 border-b">
                                        <svg class="barcode-svg" :data-code="product.sku"></svg>
                                    </td>
                                    <td class="py-3 px-4 border-b font-medium">{{ product.name }}</td>
                                    <td class="py-3 px-4 border-b">{{ product.category?.name }}</td>
                                    <td class="py-3 px-4 border-b text-right">Rp {{ new Intl.NumberFormat('id-ID').format(product.price) }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <span :class="product.stock <= product.min_stock ? 'text-red-600 font-bold' : 'text-gray-800'">
                                            {{ product.stock }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b text-center aksi-print">
                                        <Link :href="route('products.edit', product.id)" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</Link>
                                        <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
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
/* CSS ini akan menyembunyikan tombol aksi dan navbar saat di-print (CTRL+P) */
@media print {
    nav, header, .aksi-print, button {
        display: none !important;
    }
    body {
        background-color: white;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
    }
}
</style>