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
        <h1>Kelola Pemesanan</h1>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>
        
        <div v-else class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Tanggal Acara</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in pemesananList" :key="item.id_pemesanan">
                <td>{{ index + 1 }}</td>
                <td>
                  <strong>{{ item.nama_pelanggan }}</strong><br>
                  <small>{{ item.no_hp }}</small>
                </td>
                <td>{{ item.layanan?.nama_paket || '-' }}</td>
                <td>{{ formatDate(item.tanggal_acara) }}</td>
                <td>
                  <span :class="'badge badge-' + statusClass(item.status)">
                    {{ item.status }}
                  </span>
                </td>
                <td>
                  <select @change="updateStatus(item.id_pemesanan, $event.target.value)" :value="item.status" class="status-select">
                    <option value="menunggu">Menunggu</option>
                    <option value="dikonfirmasi">Konfirmasi</option>
                    <option value="dibatalkan">Batalkan</option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import authService from '@/services/authService'
import pemesananService from '@/services/pemesananService'

export default {
  name: 'AdminPemesanan',
  data() {
    return {
      pemesananList: [],
      loading: true
    }
  },
  async mounted() {
    await this.fetchPemesanan()
  },
  methods: {
    async fetchPemesanan() {
      try {
        const response = await pemesananService.getAll()
        this.pemesananList = response.data.data
      } catch (error) {
        console.error('Error:', error)
      } finally {
        this.loading = false
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
    },
    statusClass(status) {
      return { menunggu: 'pending', dikonfirmasi: 'confirmed', dibatalkan: 'cancelled' }[status]
    },
    async updateStatus(id, status) {
      try {
        await pemesananService.updateStatus(id, status)
        await this.fetchPemesanan()
      } catch (e) {
        alert('Gagal update status')
      }
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
.table-container { background: white; border-radius: var(--radius-md); overflow: hidden; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f8f8; font-weight: 600; }
.badge-pending { background: #ffc107; color: #333; }
.badge-confirmed { background: #28a745; color: white; }
.badge-cancelled { background: #dc3545; color: white; }
.status-select { padding: 0.5rem; border-radius: 4px; border: 1px solid #ddd; }
</style>
