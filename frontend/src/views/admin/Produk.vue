<template>
  <AdminLayout title="Kelola Produk">
    <template #header-actions>
      <router-link to="/admin/produk/tambah" class="btn btn-primary">+ Tambah Produk</router-link>
    </template>

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
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import layananService from '@/services/layananService'

export default {
  name: 'AdminProduk',
  components: {
    AdminLayout
  },
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
      return `https://dapur-nyonya-production.up.railway.app/storage/${path}`
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
    }
  }
}
</script>

<style scoped>
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

@media (max-width: 576px) {
  .produk-grid {
    grid-template-columns: 1fr;
  }
}
</style>
