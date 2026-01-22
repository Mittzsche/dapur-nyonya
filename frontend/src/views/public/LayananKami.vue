<template>
  <div class="layanan-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Kami Melayani</h1>
        <p>Kami menyediakan catering untuk berbagai kebutuhan acara</p>
      </div>
    </section>

    <!-- Divider Line -->
    <div class="divider"></div>

    <!-- Services List -->
    <section class="section layanan-section">
      <div class="container">
        <div v-if="loading" class="loading">
          <div class="spinner"></div>
        </div>

        <div v-else-if="layananList.length === 0" class="empty-state">
          <p>Belum ada paket layanan tersedia.</p>
        </div>

        <div v-else class="layanan-grid">
          <div v-for="layanan in layananList" :key="layanan.id_layanan" class="layanan-card">
            <div class="layanan-image">
              <img v-if="layanan.gambar" :src="getImageUrl(layanan.gambar)" :alt="layanan.nama_paket">
              <div v-else class="placeholder">
                <span>🍱</span>
              </div>
            </div>
            <div class="layanan-content">
              <h3 class="layanan-title">{{ layanan.nama_paket }}</h3>
              <p class="layanan-desc">{{ layanan.deskripsi }}</p>
              <router-link to="/hubungi" class="btn btn-primary btn-sm">Hubungi Kami</router-link>
            </div>
          </div>
        </div>
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
    getImageUrl(path) {
      if (!path) return ''
      return `https://dapur-nyonya-production.up.railway.app/storage/${path}`
    }
  }
}
</script>

<style scoped>
/* Page Header - Red Gradient */
.page-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  text-align: center;
  padding: 8rem 0 3rem;
  color: white;
}

.page-header h1 {
  font-family: var(--font-heading);
  font-size: 3rem;
  margin-bottom: 0.75rem;
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.page-header h1::after {
  content: '';
  display: block;
  width: 80px;
  height: 4px;
  background: white;
  margin: 0.75rem auto 0;
  border-radius: 2px;
}

.page-header p {
  color: rgba(255,255,255,0.9);
  font-size: 1.1rem;
}

.divider {
  height: 6px;
  background: linear-gradient(90deg, var(--primary-dark), var(--primary), var(--primary-light), var(--primary), var(--primary-dark));
}

.layanan-section {
  padding: 4rem 0;
  background: white;
  min-height: 70vh;
}

.layanan-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.layanan-card {
  border: none;
  border-radius: var(--radius-lg);
  text-align: center;
  background: white;
  transition: all 0.3s ease;
  box-shadow: 0 4px 20px rgba(196, 30, 58, 0.1);
  overflow: hidden;
}

.layanan-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 40px rgba(196, 30, 58, 0.2);
}

.layanan-image {
  width: 100%;
  aspect-ratio: 4/3;
  background: linear-gradient(135deg, #FEF0F2 0%, #FFE5E8 100%);
  overflow: hidden;
  position: relative;
}

.layanan-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.layanan-image .placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.layanan-image .placeholder span {
  font-size: 4rem;
}

.layanan-content {
  padding: 1.5rem;
}

.layanan-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: var(--primary);
}

.layanan-desc {
  color: var(--text-secondary);
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  min-height: 50px;
}

.btn-sm {
  padding: 0.6rem 2rem;
  font-size: 0.9rem;
  border-radius: 50px;
}

.empty-state {
  text-align: center;
  padding: 4rem;
  color: var(--text-secondary);
}

@media (max-width: 992px) {
  .layanan-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .layanan-grid {
    grid-template-columns: 1fr;
  }
  
  .page-header {
    padding: 5rem 0 2rem;
  }
  
  .page-header h1 {
    font-size: 2rem;
  }
}

@media (max-width: 480px) {
  .page-header {
    padding: 4rem 0 1.5rem;
  }

  .page-header h1 {
    font-size: 1.75rem;
  }

  .page-header p {
    font-size: 0.95rem;
    padding: 0 0.5rem;
  }

  .layanan-section {
    padding: 2rem 0;
  }

  .layanan-content {
    padding: 1rem;
  }

  .layanan-title {
    font-size: 1.1rem;
  }

  .layanan-desc {
    font-size: 0.9rem;
    min-height: auto;
  }

  .btn-sm {
    padding: 0.5rem 1.5rem;
    font-size: 0.85rem;
  }
}
</style>
