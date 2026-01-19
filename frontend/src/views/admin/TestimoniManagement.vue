<template>
  <AdminLayout title="Kelola Testimoni">
    <template #header-actions>
      <button class="btn btn-primary" @click="showAddModal = true">+ Tambah Testimoni</button>
    </template>

    <div v-if="loading" class="loading"><div class="spinner"></div></div>

    <div v-else-if="testimoniList.length === 0" class="empty-state">
      <p>Belum ada testimoni. Klik tombol di atas untuk menambahkan.</p>
    </div>

    <div v-else class="testimoni-grid">
      <div v-for="item in testimoniList" :key="item.id_testimoni" class="testimoni-card">
        <div class="testimoni-image">
          <img :src="getImageUrl(item.gambar)" :alt="item.caption">
        </div>
        <div class="testimoni-info">
          <p class="caption">{{ item.caption || 'Tidak ada caption' }}</p>
          <span :class="['badge', item.is_active ? 'badge-success' : 'badge-secondary']">
            {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
          </span>
        </div>
        <div class="testimoni-actions">
          <button class="btn btn-sm btn-outline" @click="editTestimoni(item)">Edit</button>
          <button class="btn btn-sm btn-danger" @click="confirmDelete(item)">Hapus</button>
        </div>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showAddModal || editingItem" class="modal-overlay" @click.self="closeModal">
      <div class="modal">
        <div class="modal-header">
          <h3>{{ editingItem ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h3>
          <button class="modal-close" @click="closeModal">&times;</button>
        </div>
        <form @submit.prevent="saveTestimoni">
          <div class="modal-body">
            <div class="form-group">
              <label class="form-label">Gambar Testimoni *</label>
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
              <input type="text" v-model="formCaption" class="form-control" placeholder="Caption testimoni...">
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
          <p>Apakah Anda yakin ingin menghapus testimoni ini?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" @click="deletingItem = null">Batal</button>
          <button class="btn btn-danger" @click="deleteTestimoni" :disabled="saving">
            {{ saving ? 'Menghapus...' : 'Hapus' }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import testimoniService from '@/services/testimoniService'

export default {
  name: 'TestimoniManagement',
  components: {
    AdminLayout
  },
  data() {
    return {
      loading: true,
      saving: false,
      testimoniList: [],
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
    await this.loadTestimoni()
  },
  methods: {
    async loadTestimoni() {
      try {
        const response = await testimoniService.getAdminAll()
        this.testimoniList = response.data.data
      } catch (error) {
        console.error('Error loading testimoni:', error)
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
    editTestimoni(item) {
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
    async saveTestimoni() {
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
          await testimoniService.update(this.editingItem.id_testimoni, formData)
        } else {
          await testimoniService.create(formData)
        }

        this.closeModal()
        await this.loadTestimoni()
      } catch (error) {
        console.error('Error saving testimoni:', error)
        alert('Gagal menyimpan testimoni')
      } finally {
        this.saving = false
      }
    },
    async deleteTestimoni() {
      this.saving = true

      try {
        await testimoniService.delete(this.deletingItem.id_testimoni)
        this.deletingItem = null
        await this.loadTestimoni()
      } catch (error) {
        console.error('Error deleting testimoni:', error)
        alert('Gagal menghapus testimoni')
      } finally {
        this.saving = false
      }
    }
  }
}
</script>

<style scoped>
.testimoni-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
}

.testimoni-card {
  background: white;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.testimoni-image {
  aspect-ratio: 3/4;
  background: #f0f0f0;
}

.testimoni-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.testimoni-info {
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

.badge-success { background: #d4edda; color: #155724; }
.badge-secondary { background: #e2e3e5; color: #383d41; }

.testimoni-actions {
  padding: 0 1rem 1rem;
  display: flex;
  gap: 0.5rem;
}

.btn-sm { padding: 0.4rem 0.75rem; font-size: 0.85rem; }
.btn-danger { background: var(--primary); color: white; }
.empty-state { text-align: center; padding: 4rem; color: var(--text-secondary); }

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
  padding: 1rem;
}

.modal {
  background: white;
  border-radius: var(--radius-lg);
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-sm { max-width: 400px; }
.modal-header { padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.modal-header h3 { margin: 0; font-size: 1.25rem; }
.modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; }
.modal-body { padding: 1.5rem; }
.modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); display: flex; gap: 1rem; justify-content: flex-end; }
.form-group { margin-bottom: 1rem; }
.form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
.form-control { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); }
.form-check { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.image-upload-area { display: flex; align-items: center; gap: 1rem; }
.preview { width: 120px; height: 160px; border: 2px solid var(--border); overflow: hidden; }
.preview img { width: 100%; height: 100%; object-fit: cover; }

@media (max-width: 576px) {
  .testimoni-grid { grid-template-columns: 1fr; }
  .image-upload-area { flex-direction: column; align-items: flex-start; }
}
</style>
