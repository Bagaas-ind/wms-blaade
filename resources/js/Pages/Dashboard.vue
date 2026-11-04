<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import RackVisualization from '@/Components/RackVisualization.vue'; // Import komponen baru

// Data dummy untuk contoh (sesuaikan dengan data dari Controller Laravel kamu nanti)
const stats = [
    { title: 'Total Produk', value: '2', icon: 'box', color: 'bg-blue-500/10 text-blue-500' },
    { title: 'Kategori', value: '2', icon: 'tag', color: 'bg-emerald-500/10 text-emerald-500' },
    { title: 'Supplier', value: '2', icon: 'truck', color: 'bg-purple-500/10 text-purple-500' },
    { title: 'Transaksi', value: '2', icon: 'exchange', color: 'bg-orange-500/10 text-orange-500' },
];

const activities = [
    { name: 'wajan', date: 'Selasa, 3 Nov', qty: '+5', type: 'in' },
    { name: 'paku', date: 'Selasa, 3 Nov', qty: '+20', type: 'in' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-6">
            <!-- max-w-7xl dan space-y-6 memastikan jarak antar section rapi -->
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- 1. Banner Sambutan -->
                <div class="overflow-hidden bg-white border border-gray-100 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative p-6 sm:p-8">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-50 to-transparent dark:from-red-900/10 dark:to-transparent"></div>
                        <div class="relative">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Halo, Admin! <span class="text-2xl">👋</span>
                            </h1>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Selamat datang di WMS Blaade. Berikut adalah ringkasan aktivitas gudang hari ini.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2. Kartu Statistik -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="stat in stats" :key="stat.title" class="p-5 bg-white border border-gray-100 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ stat.title }}</p>
                                <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ stat.value }}</p>
                            </div>
                            <div :class="['flex items-center justify-center w-12 h-12 rounded-lg', stat.color]">
                                <svg v-if="stat.icon === 'box'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <svg v-if="stat.icon === 'tag'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                <svg v-if="stat.icon === 'truck'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                                <svg v-if="stat.icon === 'exchange'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Komponen Visualisasi Rak (Komponen Baru Kita) -->
                <RackVisualization />

                <!-- 4. Grafik & Aktivitas -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Area Grafik (Kiri) -->
                    <div class="p-6 bg-white border border-gray-100 rounded-xl shadow-sm lg:col-span-2 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Grafik Transaksi (7 Hari)</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                Terbaru
                            </span>
                        </div>
                        <div class="flex items-end justify-between h-64 gap-2 px-2">
                            <div class="w-full bg-gray-100 rounded-t-sm h-[30%] dark:bg-gray-700"></div>
                            <div class="w-full bg-gray-100 rounded-t-sm h-[45%] dark:bg-gray-700"></div>
                            <div class="w-full bg-gray-100 rounded-t-sm h-[25%] dark:bg-gray-700"></div>
                            <div class="w-full bg-gray-100 rounded-t-sm h-[60%] dark:bg-gray-700"></div>
                            <div class="w-full bg-gray-100 rounded-t-sm h-[55%] dark:bg-gray-700"></div>
                            <div class="w-full bg-red-400 rounded-t-sm h-[80%] dark:bg-red-500"></div>
                            <div class="w-full bg-gray-100 rounded-t-sm h-[35%] dark:bg-gray-700"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-xs text-gray-400">
                            <span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span>
                        </div>
                    </div>

                    <!-- Area Aktivitas (Kanan) -->
                    <div class="p-6 bg-white border border-gray-100 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Aktivitas Terakhir</h3>
                        <div class="space-y-4">
                            <div v-for="(act, index) in activities" :key="index" class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ act.name }}</p>
                                        <p class="text-xs text-gray-500">{{ act.date }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ act.qty }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>