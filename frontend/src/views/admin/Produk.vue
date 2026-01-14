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
        <h1>Kelola Produk</h1>
        <router-link to="/admin/produk/tambah" class="btn btn-primary">+ Tambah Produk</router-link>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>
        
        <div v-else class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in produkList" :key="item.id_layanan">
                <td>{{ index + 1 }}</td>
                <td>{{ item.nama_paket }}</td>
                <td>Rp {{ formatPrice(item.harga) }}</td>
                <td>{{ truncate(item.deskripsi, 50) }}</td>
                <td>
                  <router-link :to="`/admin/produk/edit/${item.id_layanan}`" class="btn-icon">✏️</router-link>
                  <button @click="deleteProduk(item.id_layanan)" class="btn-icon delete">🗑️</button>
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
import layananService from '@/services/layananService'

export default {
  name: 'AdminProduk',
  data() {
    return {
      produkList: [],
      loading: true
    }
  },
  async mounted() {
    await this.fetchProduk()
  },
  methods: {
    async fetchProduk() {
      try {
        const response = await layananService.getAll()
        this.produkList = response.data.data
      } catch (error) {
        console.error('Error:', error)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    truncate(text, len) {
      return text.length > len ? text.substring(0, len) + '...' : text
    },
    async deleteProduk(id) {
      if (confirm('Hapus produk ini?')) {
        try {
          await layananService.delete(id)
          await this.fetchProduk()
        } catch (error) {
          alert('Gagal menghapus produk')
        }
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
.nav-item { display: block; padding: 0.75rem 1.5rem; color: #ccc; transition: all 0.3s ease; }
.nav-item:hover, .nav-item.router-link-active { background: #444; color: white; }
.sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid #444; }
.logout-btn { width: 100%; padding: 0.75rem; background: transparent; border: 1px solid #666; color: #ccc; cursor: pointer; border-radius: var(--radius-md); }
.logout-btn:hover { background: #dc3545; border-color: #dc3545; color: white; }
.main-content { flex: 1; background: #f5f5f5; }
.header { background: white; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.content { padding: 2rem; }
.table-container { background: white; border-radius: var(--radius-md); overflow: hidden; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f8f8; font-weight: 600; }
.btn-icon { background: none; border: none; cursor: pointer; font-size: 1.1rem; padding: 0.25rem 0.5rem; }
.btn-icon.delete:hover { color: #dc3545; }
</style>
