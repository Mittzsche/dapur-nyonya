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
        <div class="nav-divider"></div>
        <router-link to="/admin/konten" class="nav-item">📝 Konten</router-link>
        <router-link to="/admin/testimoni" class="nav-item">💬 Testimoni</router-link>
        <router-link to="/admin/galeri" class="nav-item">🖼️ Galeri</router-link>
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
        
        <div v-else-if="produkList.length === 0" class="empty-state">
          <p>Belum ada produk. Klik tombol di atas untuk menambahkan.</p>
        </div>

        <div v-else class="produk-grid">
          <div v-for="item in produkList" :key="item.id_layanan" class="produk-card">
            <div class="produk-image">
              <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.nama_paket">
              <div v-else class="image-placeholder">
                <span>📦</span>
              </div>
            </div>
            <div class="produk-info">
              <h3>{{ item.nama_paket }}</h3>
              <p class="price">Rp {{ formatPrice(item.harga) }}</p>
              <p class="desc">{{ truncate(item.deskripsi, 80) }}</p>
            </div>
            <div class="produk-actions">
              <router-link :to="`/admin/produk/edit/${item.id_layanan}`" class="btn btn-sm btn-outline">Edit</router-link>
              <button @click="deleteProduk(item.id_layanan)" class="btn btn-sm btn-danger">Hapus</button>
            </div>
          </div>
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
    getImageUrl(path) {
      if (!path) return ''
      return `http://localhost:8000/storage/${path}`
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

.sidebar {
  width: 250px;
  background: #2D2D2D;
  color: white;
  display: flex;
  flex-direction: column;
}

.sidebar-header { padding: 1.5rem; border-bottom: 1px solid #444; }
.sidebar-header h2 { font-size: 1.25rem; margin-bottom: 0.25rem; }
.sidebar-header p { font-size: 0.8rem; opacity: 0.7; }

.sidebar-nav { flex: 1; padding: 1rem 0; }
.nav-item { display: block; padding: 0.75rem 1.5rem; color: #ccc; transition: all 0.3s ease; }
.nav-item:hover, .nav-item.router-link-active { background: #444; color: white; }

.nav-divider { height: 1px; background: #444; margin: 0.5rem 1.5rem; }

.sidebar-footer { padding: 1rem 1.5rem; border-top: 1px solid #444; }
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
.logout-btn:hover { background: #dc3545; border-color: #dc3545; color: white; }

.main-content { flex: 1; background: #f5f5f5; }

.header {
  background: white;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.header h1 { font-size: 1.5rem; color: var(--text-primary); }

.content { padding: 2rem; }

.empty-state {
  text-align: center;
  padding: 4rem;
  color: var(--text-secondary);
}

.produk-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.produk-card {
  background: white;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.produk-image {
  aspect-ratio: 16/9;
  background: #f0f0f0;
}

.produk-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 4rem;
}

.produk-info {
  padding: 1.25rem;
}

.produk-info h3 {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.produk-info .price {
  font-weight: 700;
  color: var(--primary);
  margin-bottom: 0.5rem;
}

.produk-info .desc {
  font-size: 0.9rem;
  color: var(--text-secondary);
  line-height: 1.5;
}

.produk-actions {
  padding: 0 1.25rem 1.25rem;
  display: flex;
  gap: 0.5rem;
}

.btn-sm {
  padding: 0.4rem 0.75rem;
  font-size: 0.85rem;
}

.btn-danger {
  background: var(--primary);
  color: white;
}
</style>
