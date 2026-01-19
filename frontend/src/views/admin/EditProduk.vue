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
        <h1>{{ isEdit ? 'Edit Produk' : 'Tambah Produk' }}</h1>
      </header>

      <div class="content">
        <div class="form-card">
          <form @submit.prevent="handleSubmit">
            <!-- Gambar Paket -->
            <div class="form-group">
              <label class="form-label">Foto Paket</label>
              <div class="image-upload">
                <div v-if="imagePreview || form.gambar" class="image-preview">
                  <img :src="imagePreview || getImageUrl(form.gambar)" alt="Gambar Paket">
                </div>
                <div v-else class="image-placeholder">
                  <span>📦</span>
                  <p>Belum ada foto</p>
                </div>
                <div class="upload-actions">
                  <input type="file" @change="handleImageSelect" accept="image/*" ref="imageInput" style="display:none">
                  <button type="button" class="btn btn-outline" @click="$refs.imageInput.click()">
                    {{ form.gambar || imagePreview ? 'Ganti Foto' : 'Upload Foto' }}
                  </button>
                  <small v-if="selectedFile" class="file-name">{{ selectedFile.name }}</small>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Nama Paket *</label>
              <input type="text" v-model="form.nama_paket" class="form-control" required placeholder="Contoh: Paket Nasi Box Premium">
            </div>
            <div class="form-group">
              <label class="form-label">Harga (Rp) *</label>
              <input type="number" v-model="form.harga" class="form-control" required placeholder="Contoh: 35000">
            </div>
            <div class="form-group">
              <label class="form-label">Deskripsi *</label>
              <textarea v-model="form.deskripsi" class="form-control" rows="5" required placeholder="Isi paket: Nasi, Ayam Goreng, Sayur, Kerupuk, dll..."></textarea>
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
import authService from '@/services/authService'

export default {
  name: 'AdminEditProduk',
  data() {
    return {
      form: { nama_paket: '', harga: '', deskripsi: '', gambar: '' },
      loading: false,
      selectedFile: null,
      imagePreview: null
    }
  },
  computed: {
    isEdit() { return !!this.$route.params.id }
  },
  async mounted() {
    if (this.isEdit) {
      try {
        const res = await layananService.getById(this.$route.params.id)
        this.form = res.data.data
      } catch (error) {
        console.error('Error loading layanan:', error)
      }
    }
  },
  methods: {
    handleImageSelect(event) {
      const file = event.target.files[0]
      if (file) {
        this.selectedFile = file
        this.imagePreview = URL.createObjectURL(file)
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      const apiUrl = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'
      const baseUrl = apiUrl.replace(/\/api\/?$/, '')
      return `${baseUrl}/storage/${path}`
    },
    async handleSubmit() {
      this.loading = true
      try {
        const formData = new FormData()
        formData.append('nama_paket', this.form.nama_paket)
        formData.append('harga', this.form.harga)
        formData.append('deskripsi', this.form.deskripsi)
        
        if (this.selectedFile) {
          formData.append('gambar', this.selectedFile)
        }
        
        if (this.isEdit) {
          await layananService.update(this.$route.params.id, formData)
        } else {
          await layananService.create(formData)
        }
        this.$router.push('/admin/produk')
      } catch (e) {
        console.error('Error saving:', e)
        alert('Gagal menyimpan')
      } finally {
        this.loading = false
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
.header { background: white; padding: 1.5rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.header h1 { font-size: 1.5rem; color: var(--text-primary); }
.content { padding: 2rem; }
.form-card { background: white; padding: 2rem; border-radius: var(--radius-lg); max-width: 700px; box-shadow: var(--shadow-sm); }

.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  font-size: 1rem;
}
.form-control:focus { outline: none; border-color: var(--primary); }

.image-upload { display: flex; align-items: flex-start; gap: 1.5rem; }

.image-preview {
  width: 180px;
  height: 135px;
  border: 2px solid var(--border);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.image-preview img { width: 100%; height: 100%; object-fit: cover; }

.image-placeholder {
  width: 180px;
  height: 135px;
  border: 2px dashed var(--border);
  border-radius: var(--radius-md);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f9f9f9;
}
.image-placeholder span { font-size: 3rem; }
.image-placeholder p { color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem; }

.upload-actions { display: flex; flex-direction: column; gap: 0.5rem; }
.file-name { color: var(--text-secondary); font-size: 0.85rem; }

.form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); }
</style>
