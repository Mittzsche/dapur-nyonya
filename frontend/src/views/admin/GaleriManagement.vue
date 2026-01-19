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
        <h1>Kelola Galeri</h1>
        <button class="btn btn-primary" @click="showAddModal = true">+ Tambah Gambar</button>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>

        <div v-else-if="galeriList.length === 0" class="empty-state">
          <p>Belum ada gambar galeri. Klik tombol di atas untuk menambahkan.</p>
        </div>

        <div v-else class="galeri-grid">
          <div v-for="item in galeriList" :key="item.id_galeri" class="galeri-card">
            <div class="galeri-image">
              <img :src="getImageUrl(item.gambar)" :alt="item.caption">
            </div>
            <div class="galeri-info">
              <p class="caption">{{ item.caption || 'Tidak ada caption' }}</p>
              <span :class="['badge', item.is_active ? 'badge-success' : 'badge-secondary']">
                {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </div>
            <div class="galeri-actions">
              <button class="btn btn-sm btn-outline" @click="editGaleri(item)">Edit</button>
              <button class="btn btn-sm btn-danger" @click="confirmDelete(item)">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Add/Edit Modal -->
    <div v-if="showAddModal || editingItem" class="modal-overlay" @click.self="closeModal">
      <div class="modal">
        <div class="modal-header">
          <h3>{{ editingItem ? 'Edit Gambar' : 'Tambah Gambar' }}</h3>
          <button class="modal-close" @click="closeModal">&times;</button>
        </div>
        <form @submit.prevent="saveGaleri">
          <div class="modal-body">
            <div class="form-group">
              <label class="form-label">Gambar *</label>
              <div class="image-upload-area">
                <div v-if="imagePreview || (editingItem && editingItem.gambar)" class="preview">
                  <img :src="imagePreview || getImageUrl(editingItem.gambar)" alt="Preview">
                </div>
                <input type="file" @change="handleImageSelect" accept="image/*" ref="imageInput" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.imageInput.click()">
                  {{ imagePreview || (editingItem && editingItem.gambar) ? 'Ganti Gambar' : 'Pilih Gambar' }}
                </button>
              </div>
            </div>
            
            <div class="form-group">
              <label class="form-label">Caption</label>
              <input type="text" v-model="formCaption" class="form-control" placeholder="Caption gambar...">
            </div>

            <div class="form-group">
              <label class="form-label">Urutan</label>
              <input type="number" v-model="formUrutan" class="form-control" min="0">
            </div>

            <div v-if="editingItem" class="form-group">
              <label class="form-check">
                <input type="checkbox" v-model="formIsActive">
                <span>Aktif (ditampilkan di publik)</span>
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" @click="closeModal">Batal</button>
            <button type="submit" class="btn btn-primary" :disabled="saving">
              {{ saving ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation -->
    <div v-if="deletingItem" class="modal-overlay" @click.self="deletingItem = null">
      <div class="modal modal-sm">
        <div class="modal-header">
          <h3>Konfirmasi Hapus</h3>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus gambar ini?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" @click="deletingItem = null">Batal</button>
          <button class="btn btn-danger" @click="deleteGaleri" :disabled="saving">
            {{ saving ? 'Menghapus...' : 'Hapus' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import galeriService from '@/services/galeriService'
import authService from '@/services/authService'

export default {
  name: 'GaleriManagement',
  data() {
    return {
      loading: true,
      saving: false,
      galeriList: [],
      showAddModal: false,
      editingItem: null,
      deletingItem: null,
      selectedFile: null,
      imagePreview: null,
      formCaption: '',
      formUrutan: 0,
      formIsActive: true
    }
  },
  async mounted() {
    await this.loadGaleri()
  },
  methods: {
    async loadGaleri() {
      try {
        const response = await galeriService.getAdminAll()
        this.galeriList = response.data.data
      } catch (error) {
        console.error('Error loading galeri:', error)
      } finally {
        this.loading = false
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      const apiUrl = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'
      const baseUrl = apiUrl.replace(/\/api\/?$/, '')
      return `${baseUrl}/storage/${path}`
    },
    handleImageSelect(event) {
      const file = event.target.files[0]
      if (file) {
        this.selectedFile = file
        this.imagePreview = URL.createObjectURL(file)
      }
    },
    editGaleri(item) {
      this.editingItem = item
      this.formCaption = item.caption || ''
      this.formUrutan = item.urutan || 0
      this.formIsActive = item.is_active
      this.selectedFile = null
      this.imagePreview = null
    },
    closeModal() {
      this.showAddModal = false
      this.editingItem = null
      this.selectedFile = null
      this.imagePreview = null
      this.formCaption = ''
      this.formUrutan = 0
      this.formIsActive = true
    },
    confirmDelete(item) {
      this.deletingItem = item
    },
    async saveGaleri() {
      if (!this.editingItem && !this.selectedFile) {
        alert('Pilih gambar terlebih dahulu')
        return
      }

      this.saving = true

      try {
        const formData = new FormData()
        if (this.selectedFile) {
          formData.append('gambar', this.selectedFile)
        }
        formData.append('caption', this.formCaption)
        formData.append('urutan', this.formUrutan)
        
        if (this.editingItem) {
          formData.append('is_active', this.formIsActive ? 1 : 0)
          await galeriService.update(this.editingItem.id_galeri, formData)
        } else {
          await galeriService.create(formData)
        }

        this.closeModal()
        await this.loadGaleri()
      } catch (error) {
        console.error('Error saving galeri:', error)
        const errorMsg = error.response?.data?.message || 'Gagal menyimpan gambar'
        alert(errorMsg)
      } finally {
        this.saving = false
      }
    },
    async deleteGaleri() {
      this.saving = true

      try {
        await galeriService.delete(this.deletingItem.id_galeri)
        this.deletingItem = null
        await this.loadGaleri()
      } catch (error) {
        console.error('Error deleting galeri:', error)
        alert('Gagal menghapus gambar')
      } finally {
        this.saving = false
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
.admin-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background: #2D2D2D;
  color: white;
  display: flex;
  flex-direction: column;
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid #444;
}

.sidebar-header h2 {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.sidebar-header p {
  font-size: 0.8rem;
  opacity: 0.7;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem 0;
}

.nav-item {
  display: block;
  padding: 0.75rem 1.5rem;
  color: #ccc;
  transition: all 0.3s ease;
}

.nav-item:hover, .nav-item.router-link-active {
  background: #444;
  color: white;
}

.nav-divider {
  height: 1px;
  background: #444;
  margin: 0.5rem 1.5rem;
}

.sidebar-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #444;
}

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

.logout-btn:hover {
  background: #dc3545;
  border-color: #dc3545;
  color: white;
}

.main-content {
  flex: 1;
  background: #f5f5f5;
}

.header {
  background: white;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.header h1 {
  font-size: 1.5rem;
  color: var(--text-primary);
}

.content {
  padding: 2rem;
}

.galeri-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
}

.galeri-card {
  background: white;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.galeri-image {
  aspect-ratio: 4/3;
  background: #f0f0f0;
}

.galeri-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.galeri-info {
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.caption {
  font-size: 0.9rem;
  color: var(--text-secondary);
  margin: 0;
}

.badge {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
}

.badge-success {
  background: #d4edda;
  color: #155724;
}

.badge-secondary {
  background: #e2e3e5;
  color: #383d41;
}

.galeri-actions {
  padding: 0 1rem 1rem;
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

.empty-state {
  text-align: center;
  padding: 4rem;
  color: var(--text-secondary);
}

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal {
  background: white;
  border-radius: var(--radius-lg);
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-sm {
  max-width: 400px;
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  margin: 0;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid var(--border);
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.form-group {
  margin-bottom: 1rem;
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
}

.form-check {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.image-upload-area {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.preview {
  width: 150px;
  height: 110px;
  border: 2px solid var(--border);
  overflow: hidden;
}

.preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
