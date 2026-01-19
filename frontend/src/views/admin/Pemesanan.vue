<template>
  <AdminLayout title="Kelola Pemesanan">
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
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import pemesananService from '@/services/pemesananService'

export default {
  name: 'AdminPemesanan',
  components: {
    AdminLayout
  },
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
    }
  }
}
</script>

<style scoped>
.table-container { 
  background: white; 
  border-radius: var(--radius-md); 
  overflow-x: auto; /* Enable horizontal scroll for mobile */
  box-shadow: var(--shadow-sm);
}
.table { width: 100%; border-collapse: collapse; min-width: 600px; /* Force scroll on small screens */ }
.table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f8f8; font-weight: 600; white-space: nowrap; }
.badge-pending { background: #ffc107; color: #333; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; }
.badge-confirmed { background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; }
.badge-cancelled { background: #dc3545; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; }
.status-select { padding: 0.5rem; border-radius: 4px; border: 1px solid #ddd; }
</style>
