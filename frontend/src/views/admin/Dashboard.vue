<template>
  <AdminLayout title="Dashboard">
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
    </div>
    
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
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import penjualanService from '@/services/penjualanService'

export default {
  name: 'AdminDashboard',
  components: {
    AdminLayout
  },
  data() {
    return {
      summary: {},
      loading: true
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
    }
  }
}
</script>

<style scoped>
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

@media (max-width: 576px) {
  .dashboard-grid {
    grid-template-columns: 1fr;
  }
}
</style>
