<template>
  <div>
    <!-- Mobile Overlay -->
    <div 
      v-if="isOpen" 
      class="sidebar-overlay"
      @click="$emit('close')"
    ></div>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ 'is-open': isOpen }">
      <div class="sidebar-header">
        <div class="logo-container">
          <img :src="sidebarLogo" alt="Dapur Nyonya" class="logo-img">
        </div>
        <p>Admin Panel</p>
        <button class="close-btn" @click="$emit('close')">✕</button>
      </div>
      
      <nav class="sidebar-nav">
        <router-link to="/admin/dashboard" class="nav-item" @click="$emit('close')">📊 Dashboard</router-link>
        <router-link to="/admin/produk" class="nav-item" @click="$emit('close')">📦 Produk</router-link>
        <router-link to="/admin/pemesanan" class="nav-item" @click="$emit('close')">📋 Pemesanan</router-link>
        <router-link to="/admin/penjualan" class="nav-item" @click="$emit('close')">💰 Penjualan</router-link>
        <router-link to="/admin/mitra" class="nav-item" @click="$emit('close')">🤝 Mitra</router-link>
        <div class="nav-divider"></div>
        <router-link to="/admin/konten" class="nav-item" @click="$emit('close')">📝 Konten</router-link>
        <router-link to="/admin/testimoni" class="nav-item" @click="$emit('close')">💬 Testimoni</router-link>
        <router-link to="/admin/galeri" class="nav-item" @click="$emit('close')">🖼️ Galeri</router-link>
      </nav>
      
      <div class="sidebar-footer">
        <button @click="handleLogout" class="logout-btn">🚪 Logout</button>
      </div>
    </aside>
  </div>
</template>

<script>
import authService from '@/services/authService'
import dapurNyonyaLogo from '@/assets/dapur-nyonya-logo.png'

export default {
  name: 'Sidebar',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      sidebarLogo: dapurNyonyaLogo
    }
  },
  methods: {
    handleLogout() {
      if(confirm('Apakah Anda yakin ingin logout?')) {
        authService.clearAuth()
        this.$router.push('/admin/login')
      }
    }
  }
}
</script>

<style scoped>
.sidebar {
  width: 250px;
  background: #2D2D2D;
  color: white;
  display: flex;
  flex-direction: column;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  z-index: 1001;
  transition: transform 0.3s ease;
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid #444;
  position: relative;
}

.sidebar-header h2 {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.logo-container {
  display: flex;
  justify-content: center;
  margin-bottom: 0.5rem;
}

.logo-img {
  width: 100px;
  height: auto;
  object-fit: contain;
}

.sidebar-header p {
  font-size: 0.8rem;
  opacity: 0.7;
}

.close-btn {
  display: none;
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: transparent;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem 0;
  overflow-y: auto;
}

.nav-item {
  display: block;
  padding: 0.75rem 1.5rem;
  color: #ccc;
  transition: all 0.3s ease;
  text-decoration: none;
}

.nav-item:hover, .nav-item.router-link-active {
  background: #444;
  color: white;
}

.nav-divider {
  height: 1px;
  background: #444;
  margin: 0.5rem 1.5rem;
}

.sidebar-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #444;
}

.logout-btn {
  width: 100%;
  padding: 0.75rem;
  background: transparent;
  border: 1px solid #666;
  color: #ccc;
  cursor: pointer;
  border-radius: 8px; /* Hardcoded from var --radius-md just in case */
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background: #dc3545;
  border-color: #dc3545;
  color: white;
}

.sidebar-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

/* Mobile Responsive */
@media (max-width: 992px) {
  .sidebar {
    transform: translateX(-100%);
  }
  
  .sidebar.is-open {
    transform: translateX(0);
  }
  
  .sidebar-overlay {
    display: block;
  }
  
  .close-btn {
    display: block;
  }
}
</style>
