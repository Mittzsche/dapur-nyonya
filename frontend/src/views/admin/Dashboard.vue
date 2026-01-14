<template>
  <div class="admin-layout">
    <aside class="sidebar">
      <div class="sidebar-header">
        <h2>🍽️ Dapur Nyonya</h2>
        <p>Admin Panel</p>
      </div>
      <nav class="sidebar-nav">
        <router-link to="/admin/dashboard" class="nav-item">📊 Dashboard</router-link>
        <router-link to="/admin/produk" class="nav-item">📦 Produk</router-link>
        <router-link to="/admin/pemesanan" class="nav-item">📋 Pemesanan</router-link>
        <router-link to="/admin/penjualan" class="nav-item">💰 Penjualan</router-link>
      </nav>
      <div class="sidebar-footer">
        <button @click="handleLogout" class="logout-btn">🚪 Logout</button>
      </div>
    </aside>

    <main class="main-content">
      <header class="header">
        <h1>Dashboard</h1>
        <span>Selamat datang, {{ adminName }}</span>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>
        
        <div v-else class="dashboard-grid">
          <div class="stat-card">
            <span class="stat-icon">📦</span>
            <div class="stat-info">
              <span class="stat-number">{{ summary.pesanan_hari_ini || 0 }}</span>
              <span class="stat-label">Pesanan Hari Ini</span>
            </div>
          </div>
          <div class="stat-card pending">
            <span class="stat-icon">⏳</span>
            <div class="stat-info">
              <span class="stat-number">{{ summary.pesanan_menunggu || 0 }}</span>
              <span class="stat-label">Menunggu Konfirmasi</span>
            </div>
          </div>
          <div class="stat-card success">
            <span class="stat-icon">✅</span>
            <div class="stat-info">
              <span class="stat-number">{{ summary.pesanan_bulan_ini || 0 }}</span>
              <span class="stat-label">Pesanan Bulan Ini</span>
            </div>
          </div>
          <div class="stat-card revenue">
            <span class="stat-icon">💰</span>
            <div class="stat-info">
              <span class="stat-number">Rp {{ formatPrice(summary.pendapatan_bulan_ini || 0) }}</span>
              <span class="stat-label">Pendapatan Bulan Ini</span>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import authService from '@/services/authService'
import penjualanService from '@/services/penjualanService'

export default {
  name: 'AdminDashboard',
  data() {
    return {
      summary: {},
      loading: true
    }
  },
  computed: {
    adminName() {
      const user = authService.getStoredUser()
      return user?.nama_lengkap || 'Admin'
    }
  },
  async mounted() {
    await this.fetchSummary()
  },
  methods: {
    async fetchSummary() {
      try {
        const response = await penjualanService.getSummary()
        this.summary = response.data.data
      } catch (error) {
        console.error('Error fetching summary:', error)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    handleLogout() {
      authService.clearAuth()
      this.$router.push('/admin/login')
    }
  }
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background: #2D2D2D;
  color: white;
  display: flex;
  flex-direction: column;
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid #444;
}

.sidebar-header h2 {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.sidebar-header p {
  font-size: 0.8rem;
  opacity: 0.7;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem 0;
}

.nav-item {
  display: block;
  padding: 0.75rem 1.5rem;
  color: #ccc;
  transition: all 0.3s ease;
}

.nav-item:hover, .nav-item.router-link-active {
  background: #444;
  color: white;
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
  border-radius: var(--radius-md);
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background: #dc3545;
  border-color: #dc3545;
  color: white;
}

.main-content {
  flex: 1;
  background: #f5f5f5;
}

.header {
  background: white;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.header h1 {
  font-size: 1.5rem;
  color: var(--text-primary);
}

.content {
  padding: 2rem;
}

.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.stat-card {
  background: white;
  padding: 1.5rem;
  border-radius: var(--radius-md);
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: var(--shadow-sm);
  border-left: 4px solid var(--primary);
}

.stat-card.pending { border-left-color: var(--warning); }
.stat-card.success { border-left-color: var(--success); }
.stat-card.revenue { border-left-color: #9c27b0; }

.stat-icon {
  font-size: 2rem;
}

.stat-number {
  display: block;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text-primary);
}

.stat-label {
  font-size: 0.85rem;
  color: var(--text-secondary);
}

@media (max-width: 992px) {
  .dashboard-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
