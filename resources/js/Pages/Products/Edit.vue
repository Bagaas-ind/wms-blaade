<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
    categories: Array,
    suppliers: Array
});

const form = useForm({
    sku: props.product.sku,
    name: props.product.name,
    category_id: props.product.category_id,
    supplier_id: props.product.supplier_id,
    price: props.product.price,
    stock: props.product.stock,
    min_stock: props.product.min_stock
});

const submit = () => { form.put(route('products.update', props.product.id)); };
</script>

<template>
    <Head title="Edit Produk" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">Edit Produk</h2>
        </template>
        
        <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    <form @submit.prevent="submit">
                        <!-- SKU & Nama -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kode (SKU)</label>
                                <input type="text" v-model="form.sku" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500" required>
                                <div v-if="form.errors.sku" class="text-red-500 text-xs mt-2">{{ form.errors.sku }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nama Produk</label>
                                <input type="text" v-model="form.name" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500" required>
                                <div v-if="form.errors.name" class="text-red-500 text-xs mt-2">{{ form.errors.name }}</div>
                            </div>
                        </div>

                        <!-- Kategori & Supplier -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Kategori</label>
                                <select v-model="form.category_id" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Supplier (Opsional)</label>
                                <select v-model="form.supplier_id" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500">
                                    <option value="">-- Pilih Supplier --</option>
                                    <option v-for="sup in suppliers" :key="sup.id" :value="sup.id">{{ sup.name }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Harga, Stok, Min Stok -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Harga (Rp)</label>
                                <input type="number" v-model="form.price" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500" required min="0">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Stok Saat Ini (Terkunci)</label>
                                <!-- INPUT STOK DIBERI ATRIBUT DISABLED -->
                                <input type="number" v-model="form.stock" class="shadow border rounded w-full py-2 px-3 bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed border-gray-300 dark:border-gray-500" disabled>
                                <p class="text-xs text-red-500 mt-1">*Stok hanya bisa diubah via menu Transaksi</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Batas Stok Min</label>
                                <input type="number" v-model="form.min_stock" class="shadow border rounded w-full py-2 px-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-red-500 focus:border-red-500" required min="0">
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all transform hover:scale-105" :disabled="form.processing">
                                Update Produk
                            </button>
                            <Link :href="route('products.index')" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>