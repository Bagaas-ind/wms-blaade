<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';

const props = defineProps({
    totalProducts: Number,
    totalCategories: Number,
    totalSuppliers: Number,
    totalTransactions: Number,
    lowStockProducts: Array,
    weeklyTransactions: Array,
    recentTransactions: Array
});

const user = computed(() => usePage().props.auth.user);

const maxWeekly = computed(() => {
    const max = Math.max(...props.weeklyTransactions.map(d => d.total));
    return max > 0 ? max : 1;
});

// ==========================================
// LOGIKA DARK MODE / LIGHT MODE
// ==========================================
const isDarkMode = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

onMounted(() => {
    // Cek apakah sebelumnya user sudah pilih dark mode
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDarkMode.value = false;
        document.documentElement.classList.remove('dark');
    }
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <!-- Header dengan Tombol Toggle -->
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">Overview Dashboard</h2>
                
                <!-- Tombol Toggle Mode Gelap/Terang -->
                <button @click="toggleDarkMode" class="p-2 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg v-if="!isDarkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
            </div>
        </template>

        <!-- Background menyesuaikan mode -->
        <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Banner (Telkom Red) -->
                <div class="relative bg-gradient-to-r from-red-700 via-red-600 to-red-800 rounded-2xl shadow-xl p-8 text-white overflow-hidden">
                    <div class="absolute -right-10 -top-10 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-2">Halo, {{ user.name }}! 👋</h3>
                        <p class="text-red-100 text-lg">Selamat datang di WMS Blaade. Berikut adalah ringkasan aktivitas gudang hari ini.</p>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-700 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total Produk</p>
                                <p class="text-4xl font-extrabold text-gray-800 dark:text-gray-100">{{ totalProducts }}</p>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-700 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Kategori</p>
                                <p class="text-4xl font-extrabold text-gray-800 dark:text-gray-100">{{ totalCategories }}</p>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-700 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Supplier</p>
                                <p class="text-4xl font-extrabold text-gray-800 dark:text-gray-100">{{ totalSuppliers }}</p>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 dark:border-gray-700 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-1 uppercase tracking-wider">Transaksi</p>
                                <p class="text-4xl font-extrabold text-gray-800 dark:text-gray-100">{{ totalTransactions }}</p>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Grafik -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100">Grafik Transaksi (7 Hari)</h4>
                            <span class="text-xs font-semibold bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-3 py-1 rounded-full">Terbaru</span>
                        </div>
                        
                        <div class="flex items-end justify-between h-56 gap-3 mt-4">
                            <div v-for="(day, index) in weeklyTransactions" :key="index" class="flex flex-col items-center flex-1 h-full justify-end group">
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-300 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ day.total }}</span>
                                <!-- Bar Chart Merah -->
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-t-md relative flex items-end overflow-hidden" style="height: 100%;">
                                    <div class="w-full bg-gradient-to-t from-red-600 to-red-400 rounded-t-md transition-all duration-500" 
                                         :style="{ height: `${(day.total / maxWeekly) * 100}%`, minHeight: day.total > 0 ? '8%' : '0%' }">
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-3">{{ day.label }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Terakhir -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">Aktivitas Terakhir</h4>
                        <div class="space-y-4">
                            <div v-for="trx in recentTransactions" :key="trx.id" class="flex items-start">
                                <div :class="trx.type === 'in' ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'" class="p-2 rounded-full mt-1 mr-3">
                                    <svg v-if="trx.type === 'in'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                </div>
                                <div class="flex-1 border-b border-gray-100 dark:border-gray-700 pb-3">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ trx.product?.name }}</p>
                                        <span :class="trx.type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'" class="text-sm font-bold">
                                            {{ trx.type === 'in' ? '+' : '-' }}{{ trx.quantity }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ new Date(trx.date).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short' }) }}</p>
                                </div>
                            </div>
                            <div v-if="recentTransactions.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400 text-sm">
                                Belum ada aktivitas hari ini.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peringatan Stok Menipis -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-red-100 dark:border-red-900/30">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100">Perhatian: Stok Menipis!</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="prod in lowStockProducts" :key="prod.id" class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-900/30">
                            <div>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ prod.name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-1">{{ prod.sku }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-red-600 dark:text-red-500">{{ prod.stock }}</p>
                                <p class="text-xs text-red-400 dark:text-red-500">Batas: {{ prod.min_stock }}</p>
                            </div>
                        </div>
                        <div v-if="lowStockProducts.length === 0" class="col-span-full text-center py-6 text-green-600 dark:text-green-400 font-medium bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-900/30">
                            ✅ Semua stok dalam kondisi aman.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>