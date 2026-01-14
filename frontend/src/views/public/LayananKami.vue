<template>
  <div class="layanan-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Layanan Kami</h1>
        <p>Pilih paket catering terbaik untuk acara Anda</p>
      </div>
    </section>

    <!-- Services List -->
    <section class="section">
      <div class="container">
        <div v-if="loading" class="loading">
          <div class="spinner"></div>
        </div>

        <div v-else-if="layananList.length === 0" class="empty-state">
          <p>Belum ada paket layanan tersedia.</p>
        </div>

        <div v-else class="grid grid-3">
          <div v-for="layanan in layananList" :key="layanan.id_layanan" class="card service-card">
            <div class="card-image-placeholder">
              <span>🍱</span>
            </div>
            <div class="card-content">
              <h3 class="card-title">{{ layanan.nama_paket }}</h3>
              <p class="card-text">{{ layanan.deskripsi }}</p>
              <div class="card-footer">
                <p class="card-price">Rp {{ formatPrice(layanan.harga) }}</p>
                <router-link to="/hubungi" class="btn btn-primary btn-sm">
                  Pesan
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Custom Order CTA -->
    <section class="custom-order">
      <div class="container">
        <h2>Butuh Paket Custom?</h2>
        <p>Hubungi kami untuk menyesuaikan menu sesuai kebutuhan dan budget Anda</p>
        <router-link to="/hubungi" class="btn btn-primary btn-lg">
          Konsultasi Gratis
        </router-link>
      </div>
    </section>
  </div>
</template>

<script>
import layananService from '@/services/layananService'

export default {
  name: 'LayananKami',
  data() {
    return {
      layananList: [],
      loading: true
    }
  },
  async mounted() {
    await this.fetchLayanan()
  },
  methods: {
    async fetchLayanan() {
      try {
        const response = await layananService.getAll()
        this.layananList = response.data.data
      } catch (error) {
        console.error('Error fetching layanan:', error)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    }
  }
}
</script>

<style scoped>
.page-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
  color: white;
  text-align: center;
  padding: 8rem 0 4rem;
}

.page-header h1 {
  font-family: 'Georgia', serif;
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.page-header p {
  opacity: 0.9;
}

.card-image-placeholder {
  height: 200px;
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 4rem;
}

.service-card .card-content {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.service-card .card-text {
  flex: 1;
  font-size: 0.9rem;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid var(--border);
}

.card-footer .card-price {
  margin: 0;
}

.btn-sm {
  padding: 0.4rem 1rem;
  font-size: 0.9rem;
}

.empty-state {
  text-align: center;
  padding: 4rem;
  color: var(--text-secondary);
}

.custom-order {
  background: var(--secondary);
  color: white;
  text-align: center;
  padding: 4rem 0;
}

.custom-order h2 {
  font-family: 'Georgia', serif;
  font-size: 2rem;
  margin-bottom: 1rem;
}

.custom-order p {
  margin-bottom: 1.5rem;
  opacity: 0.9;
}
</style>
