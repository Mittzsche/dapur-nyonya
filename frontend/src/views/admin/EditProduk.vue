<template>
  <AdminLayout :title="isEdit ? 'Edit Produk' : 'Tambah Produk'">
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
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout.vue'
import layananService from '@/services/layananService'

export default {
  name: 'AdminEditProduk',
  components: {
    AdminLayout
  },
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
        // Validation: Max 2MB
        if (file.size > 2 * 1024 * 1024) {
          alert('Ukuran file terlalu besar. Maksimal 2MB.')
          event.target.value = ''
          return
        }
        
        // Validation: Type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']
        if (!allowedTypes.includes(file.type)) {
          alert('Format file tidak didukung. Gunakan PNG, JPG, atau GIF.')
          event.target.value = ''
          return
        }

        this.selectedFile = file
        this.imagePreview = URL.createObjectURL(file)
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      return `https://dapur-nyonya-production.up.railway.app/storage/${path}`
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
        const msg = e.response?.data?.message || 'Gagal menyimpan'
        alert(msg)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.form-card { background: white; padding: 2rem; border-radius: var(--radius-lg); max-width: 700px; box-shadow: var(--shadow-sm); }
.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
.form-control { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; }
.form-control:focus { outline: none; border-color: var(--primary); }

.image-upload { display: flex; align-items: flex-start; gap: 1.5rem; }
.image-preview { width: 180px; height: 135px; border: 2px solid var(--border); border-radius: var(--radius-md); overflow: hidden; }
.image-preview img { width: 100%; height: 100%; object-fit: cover; }
.image-placeholder { width: 180px; height: 135px; border: 2px dashed var(--border); border-radius: var(--radius-md); display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f9f9f9; }
.image-placeholder span { font-size: 3rem; }
.image-placeholder p { color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.5rem; }
.upload-actions { display: flex; flex-direction: column; gap: 0.5rem; }
.file-name { color: var(--text-secondary); font-size: 0.85rem; }
.form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); }

@media (max-width: 576px) {
  .image-upload { flex-direction: column; }
  .form-card { padding: 1rem; }
}
</style>
