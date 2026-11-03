<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ products: Object });

const deleteProduct = (id) => {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        router.delete(route('products.destroy', id));
    }
};
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
                    <div class="mb-4">
                        <Link :href="route('products.create')" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tambah Produk</Link>
                    </div>

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
                                <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b font-mono text-sm">{{ product.sku }}</td>
                                    <td class="py-3 px-4 border-b font-medium">{{ product.name }}</td>
                                    <td class="py-3 px-4 border-b">{{ product.category?.name }}</td>
                                    <td class="py-3 px-4 border-b">{{ product.supplier ? product.supplier.name : '-' }}</td>
                                    <td class="py-3 px-4 border-b text-right">Rp {{ new Intl.NumberFormat('id-ID').format(product.price) }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <span :class="product.stock <= product.min_stock ? 'text-red-600 font-bold' : 'text-gray-800'">
                                            {{ product.stock }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <Link :href="route('products.edit', product.id)" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</Link>
                                        <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </td>
                                </tr>
                                <tr v-if="products.data.length === 0">
                                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data produk.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>