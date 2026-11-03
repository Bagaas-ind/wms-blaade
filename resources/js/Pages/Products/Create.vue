<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    suppliers: Array
});

const form = useForm({
    sku: '', name: '', category_id: '', supplier_id: '', price: '', stock: 0, min_stock: 5
});

const submit = () => { form.post(route('products.store')); };
</script>

<template>
    <Head title="Tambah Produk" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Produk</h2></template>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Kode (SKU)</label>
                                <input type="text" v-model="form.sku" class="shadow border rounded w-full py-2 px-3" required>
                                <div v-if="form.errors.sku" class="text-red-500 text-xs mt-2">{{ form.errors.sku }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                                <input type="text" v-model="form.name" class="shadow border rounded w-full py-2 px-3" required>
                                <div v-if="form.errors.name" class="text-red-500 text-xs mt-2">{{ form.errors.name }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                                <select v-model="form.category_id" class="shadow border rounded w-full py-2 px-3" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                </select>
                                <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-2">{{ form.errors.category_id }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Supplier (Opsional)</label>
                                <select v-model="form.supplier_id" class="shadow border rounded w-full py-2 px-3">
                                    <option value="">-- Pilih Supplier --</option>
                                    <option v-for="sup in suppliers" :key="sup.id" :value="sup.id">{{ sup.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                                <input type="number" v-model="form.price" class="shadow border rounded w-full py-2 px-3" required min="0">
                                <div v-if="form.errors.price" class="text-red-500 text-xs mt-2">{{ form.errors.price }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Stok Awal</label>
                                <input type="number" v-model="form.stock" class="shadow border rounded w-full py-2 px-3" required min="0">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Batas Stok Min</label>
                                <input type="number" v-model="form.min_stock" class="shadow border rounded w-full py-2 px-3" required min="0">
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded" :disabled="form.processing">Simpan Produk</button>
                            <Link :href="route('products.index')" class="text-gray-600 hover:underline">Batal</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>