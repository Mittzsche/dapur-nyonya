<template>
  <AdminLayout title="Laporan Penjualan">
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
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import penjualanService from '@/services/penjualanService'

export default {
  name: 'AdminPenjualan',
  components: {
    AdminLayout
  },
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
    }
  }
}
</script>

<style scoped>
.summary-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
.summary-card { background: white; padding: 1.5rem; border-radius: var(--radius-md); text-align: center; box-shadow: var(--shadow-sm); }
.summary-card h3 { font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
.big-number { font-size: 2rem; font-weight: 700; color: var(--primary); }

.table-container { 
  background: white; 
  border-radius: var(--radius-md); 
  overflow-x: auto; 
  box-shadow: var(--shadow-sm);
}
.table { width: 100%; border-collapse: collapse; min-width: 600px; }
.table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f8f8; font-weight: 600; white-space: nowrap; }

@media (max-width: 768px) {
  .summary-cards {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}
</style>
