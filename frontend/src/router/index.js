import { createRouter, createWebHistory } from 'vue-router'

// Public Views
import Home from '@/views/public/Home.vue'
import LayananKami from '@/views/public/LayananKami.vue'
import TentangKami from '@/views/public/TentangKami.vue'
import Testimoni from '@/views/public/Testimoni.vue'
import HubungiKami from '@/views/public/HubungiKami.vue'

// Admin Views
import AdminLogin from '@/views/admin/Login.vue'
import AdminDashboard from '@/views/admin/Dashboard.vue'
import AdminProduk from '@/views/admin/Produk.vue'
import AdminEditProduk from '@/views/admin/EditProduk.vue'
import AdminPemesanan from '@/views/admin/Pemesanan.vue'
import AdminPenjualan from '@/views/admin/Penjualan.vue'

const routes = [
    // ==================
    // PUBLIC ROUTES
    // ==================
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: { title: 'Beranda - Dapur Nyonya' }
    },
    {
        path: '/layanan',
        name: 'LayananKami',
        component: LayananKami,
        meta: { title: 'Layanan Kami - Dapur Nyonya' }
    },
    {
        path: '/tentang',
        name: 'TentangKami',
        component: TentangKami,
        meta: { title: 'Tentang Kami - Dapur Nyonya' }
    },
    {
        path: '/testimoni',
        name: 'Testimoni',
        component: Testimoni,
        meta: { title: 'Testimoni - Dapur Nyonya' }
    },
    {
        path: '/hubungi',
        name: 'HubungiKami',
        component: HubungiKami,
        meta: { title: 'Hubungi Kami - Dapur Nyonya' }
    },

    // ==================
    // ADMIN ROUTES
    // ==================
    {
        path: '/admin/login',
        name: 'AdminLogin',
        component: AdminLogin,
        meta: { title: 'Login Admin - Dapur Nyonya', isGuest: true }
    },
    {
        path: '/admin/dashboard',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: { title: 'Dashboard - Admin Dapur Nyonya', requiresAuth: true }
    },
    {
        path: '/admin/produk',
        name: 'AdminProduk',
        component: AdminProduk,
        meta: { title: 'Kelola Produk - Admin Dapur Nyonya', requiresAuth: true }
    },
    {
        path: '/admin/produk/tambah',
        name: 'AdminTambahProduk',
        component: AdminEditProduk,
        meta: { title: 'Tambah Produk - Admin Dapur Nyonya', requiresAuth: true }
    },
    {
        path: '/admin/produk/edit/:id',
        name: 'AdminEditProduk',
        component: AdminEditProduk,
        meta: { title: 'Edit Produk - Admin Dapur Nyonya', requiresAuth: true }
    },
    {
        path: '/admin/pemesanan',
        name: 'AdminPemesanan',
        component: AdminPemesanan,
        meta: { title: 'Kelola Pemesanan - Admin Dapur Nyonya', requiresAuth: true }
    },
    {
        path: '/admin/penjualan',
        name: 'AdminPenjualan',
        component: AdminPenjualan,
        meta: { title: 'Laporan Penjualan - Admin Dapur Nyonya', requiresAuth: true }
    },

    // Catch-all redirect
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    }
})

// Navigation guard for auth
router.beforeEach((to, from, next) => {
    // Set page title
    document.title = to.meta.title || 'Dapur Nyonya'

    const isLoggedIn = !!localStorage.getItem('admin_token')

    // Check if route requires auth
    if (to.meta.requiresAuth && !isLoggedIn) {
        next({ name: 'AdminLogin' })
        return
    }

    // Redirect if already logged in and trying to access login
    if (to.meta.isGuest && isLoggedIn) {
        next({ name: 'AdminDashboard' })
        return
    }

    next()
})

export default router
