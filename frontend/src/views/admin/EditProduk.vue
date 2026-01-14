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
    </aside>

    <main class="main-content">
      <header class="header">
        <h1>{{ isEdit ? 'Edit Produk' : 'Tambah Produk' }}</h1>
      </header>

      <div class="content">
        <div class="form-card">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label class="form-label">Nama Paket</label>
              <input type="text" v-model="form.nama_paket" class="form-control" required>
            </div>
            <div class="form-group">
              <label class="form-label">Harga (Rp)</label>
              <input type="number" v-model="form.harga" class="form-control" required>
            </div>
            <div class="form-group">
              <label class="form-label">Deskripsi</label>
              <textarea v-model="form.deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-actions">
              <router-link to="/admin/produk" class="btn btn-outline">Batal</router-link>
              <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ loading ? 'Menyimpan...' : 'Simpan' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import layananService from '@/services/layananService'

export default {
  name: 'AdminEditProduk',
  data() {
    return {
      form: { nama_paket: '', harga: '', deskripsi: '' },
      loading: false
    }
  },
  computed: {
    isEdit() { return !!this.$route.params.id }
  },
  async mounted() {
    if (this.isEdit) {
      const res = await layananService.getById(this.$route.params.id)
      this.form = res.data.data
    }
  },
  methods: {
    async handleSubmit() {
      this.loading = true
      try {
        const formData = new FormData()
        Object.keys(this.form).forEach(key => formData.append(key, this.form[key]))
        
        if (this.isEdit) {
          await layananService.update(this.$route.params.id, formData)
        } else {
          await layananService.create(formData)
        }
        this.$router.push('/admin/produk')
      } catch (e) {
        alert('Gagal menyimpan')
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.admin-layout { display: flex; min-height: 100vh; }
.sidebar { width: 250px; background: #2D2D2D; color: white; }
.sidebar-header { padding: 1.5rem; border-bottom: 1px solid #444; }
.sidebar-header h2 { font-size: 1.25rem; margin-bottom: 0.25rem; }
.sidebar-header p { font-size: 0.8rem; opacity: 0.7; }
.sidebar-nav { padding: 1rem 0; }
.nav-item { display: block; padding: 0.75rem 1.5rem; color: #ccc; }
.nav-item:hover, .nav-item.router-link-active { background: #444; color: white; }
.main-content { flex: 1; background: #f5f5f5; }
.header { background: white; padding: 1.5rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.content { padding: 2rem; }
.form-card { background: white; padding: 2rem; border-radius: var(--radius-md); max-width: 600px; }
.form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem; }
</style>
