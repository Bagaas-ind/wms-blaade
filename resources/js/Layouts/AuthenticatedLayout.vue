<script setup>
import { ref, onMounted, watch } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();

// === LOGIKA DARK MODE (PUSAT) ===
const isDarkMode = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
};

watch(isDarkMode, (val) => {
    if (val) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
});

onMounted(() => {
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDarkMode.value = false;
        document.documentElement.classList.remove('dark');
    }
});

// Menu Navigasi
const menus = [
    { name: 'Dashboard', route: 'dashboard', active: 'dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { name: 'Kategori', route: 'categories.index', active: 'categories.*', icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' },
    { name: 'Supplier', route: 'suppliers.index', active: 'suppliers.*', icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' },
    { name: 'Produk', route: 'products.index', active: 'products.*', icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' },
    { name: 'Transaksi', route: 'transactions.index', active: 'transactions.*', icon: 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 flex">
        
        <!-- SIDEBAR (Putih di mode terang, Hitam di mode gelap) -->
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col fixed h-full z-20 shadow-sm transition-colors duration-300">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-100 dark:border-gray-700">
                <Link :href="route('dashboard')" class="flex items-center gap-3">
                    <div class="bg-red-600 p-1.5 rounded-lg shadow-md">
                        <ApplicationLogo class="h-6 w-6 fill-current text-white" />
                    </div>
                    <div>
                        <span class="block text-lg font-black text-gray-800 dark:text-gray-100 leading-none">WMS</span>
                        <span class="block text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-widest font-semibold mt-1">Warehouse System</span>
                    </div>
                </Link>
            </div>

            <!-- Menu -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                <p class="px-2 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4">Menu Utama</p>
                
                <Link v-for="menu in menus" :key="menu.name" 
                    :href="route(menu.route)" 
                    :class="[
                        route().current(menu.active) 
                            ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border-red-600' 
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400 border-transparent',
                        'flex items-center px-4 py-3 text-sm font-semibold rounded-xl border-l-4 transition-all duration-200'
                    ]"
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="menu.icon"></path>
                    </svg>
                    {{ menu.name }}
                </Link>
            </div>

            <!-- User Profile Dropdown di Sidebar -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button class="flex items-center w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors text-left">
                            <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold mr-3 shrink-0">
                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">{{ $page.props.auth.user.name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $page.props.auth.user.email }}</p>
                            </div>
                        </button>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                        <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <!-- HEADER (Hanya ada 1 Tombol Toggle di sini) -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 sticky top-0 z-10 transition-colors duration-300">
                
                <div class="flex items-center gap-4">
                    <!-- Tombol Mobile Hamburger -->
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="md:hidden text-gray-500 dark:text-gray-400">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>

                <!-- Tombol Dark Mode (Bersih, tanpa kotak aneh) -->
                <div class="flex items-center gap-4">
                    <button @click="toggleDarkMode" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-yellow-400 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg v-if="!isDarkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                </div>
            </header>

            <!-- PAGE CONTENT (Isi Halaman) -->
            <main class="flex-1">
                <slot />
            </main>
        </div>
    </div>
</template>