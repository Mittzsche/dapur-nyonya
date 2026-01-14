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
        <h1>Laporan Penjualan</h1>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>
        
        <div v-else>
          <div class="summary-cards">
            <div class="summary-card">
              <h3>Total Transaksi</h3>
              <span class="big-number">{{ penjualan.summary?.total_transaksi || 0 }}</span>
            </div>
            <div class="summary-card">
              <h3>Total Pendapatan</h3>
              <span class="big-number">Rp {{ formatPrice(penjualan.summary?.total_pendapatan || 0) }}</span>
            </div>
          </div>

          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Pelanggan</th>
                  <th>Paket</th>
                  <th>Tanggal Acara</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in penjualan.penjualan" :key="item.id_pemesanan">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.nama_pelanggan }}</td>
                  <td>{{ item.layanan?.nama_paket || '-' }}</td>
                  <td>{{ formatDate(item.tanggal_acara) }}</td>
                  <td>Rp {{ formatPrice(item.layanan?.harga || 0) }}</td>
                </tr>
              </tbody>
            </table>
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
  name: 'AdminPenjualan',
  data() {
    return {
      penjualan: {},
      loading: true
    }
  },
  async mounted() {
    await this.fetchPenjualan()
  },
  methods: {
    async fetchPenjualan() {
      try {
        const response = await penjualanService.getReport()
        this.penjualan = response.data.data
      } catch (error) {
        console.error('Error:', error)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
    },
    handleLogout() {
      authService.clearAuth()
      this.$router.push('/admin/login')
    }
  }
}
</script>

<style scoped>
.admin-layout { display: flex; min-height: 100vh; }
.sidebar { width: 250px; background: #2D2D2D; color: white; display: flex; flex-direction: column; }
.sidebar-header { padding: 1.5rem; border-bottom: 1px solid #444; }
.sidebar-header h2 { font-size: 1.25rem; margin-bottom: 0.25rem; }
.sidebar-header p { font-size: 0.8rem; opacity: 0.7; }
.sidebar-nav { flex: 1; padding: 1rem 0; }
.nav-item { display: block; padding: 0.75rem 1.5rem; color: #ccc; }
.nav-item:hover, .nav-item.router-link-active { background: #444; color: white; }
.sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid #444; }
.logout-btn { width: 100%; padding: 0.75rem; background: transparent; border: 1px solid #666; color: #ccc; cursor: pointer; border-radius: var(--radius-md); }
.main-content { flex: 1; background: #f5f5f5; }
.header { background: white; padding: 1.5rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.content { padding: 2rem; }
.summary-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
.summary-card { background: white; padding: 1.5rem; border-radius: var(--radius-md); text-align: center; }
.summary-card h3 { font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
.big-number { font-size: 2rem; font-weight: 700; color: var(--primary); }
.table-container { background: white; border-radius: var(--radius-md); overflow: hidden; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f8f8; font-weight: 600; }
</style>
