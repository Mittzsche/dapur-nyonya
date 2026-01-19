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
        <h1>Kelola Konten Website</h1>
      </header>

      <div class="content">
        <div v-if="loading" class="loading"><div class="spinner"></div></div>

        <div v-else>
          <!-- Success/Error Messages -->
          <div v-if="message" :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-error']">
            {{ message }}
          </div>

          <!-- Tab Navigation -->
          <div class="tabs">
            <button :class="['tab', activeTab === 'home' ? 'active' : '']" @click="activeTab = 'home'">🏠 Beranda</button>
            <button :class="['tab', activeTab === 'tentang' ? 'active' : '']" @click="activeTab = 'tentang'">📄 Tentang Kami</button>
          </div>

          <!-- Home Tab -->
          <div v-if="activeTab === 'home'" class="content-form">
            <h3 class="form-section-title">Gambar Halaman Beranda</h3>
            
            <!-- Logo -->
            <div class="form-group">
              <label class="form-label">Logo (100x100)</label>
              <div class="image-upload">
                <div v-if="homeLogoPreview || form.home_logo" class="image-preview small">
                  <img :src="homeLogoPreview || getImageUrl(form.home_logo)" alt="Logo">
                </div>
                <div v-else class="image-placeholder small">
                  <span>🍽️</span>
                </div>
                <input type="file" @change="e => handleImage(e, 'homeLogo')" accept="image/*" ref="homeLogoInput" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.homeLogoInput.click()">Upload</button>
              </div>
            </div>

            <!-- Hero Banner 1 -->
            <div class="form-group">
              <label class="form-label">Banner Hero 1 - Mengapa Memilih Kami (4:3)</label>
              <div class="image-upload">
                <div v-if="heroBanner1Preview || form.home_hero_1" class="image-preview landscape">
                  <img :src="heroBanner1Preview || getImageUrl(form.home_hero_1)" alt="Hero 1">
                </div>
                <div v-else class="image-placeholder landscape">
                  <span>🚚</span>
                </div>
                <input type="file" @change="e => handleImage(e, 'heroBanner1')" accept="image/*" ref="heroBanner1Input" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.heroBanner1Input.click()">Upload</button>
              </div>
            </div>

            <!-- Hero Banner 2 -->
            <div class="form-group">
              <label class="form-label">Banner Hero 2 - Mengapa Memilih Kami (4:3)</label>
              <div class="image-upload">
                <div v-if="heroBanner2Preview || form.home_hero_2" class="image-preview landscape">
                  <img :src="heroBanner2Preview || getImageUrl(form.home_hero_2)" alt="Hero 2">
                </div>
                <div v-else class="image-placeholder landscape">
                  <span>⚡</span>
                </div>
                <input type="file" @change="e => handleImage(e, 'heroBanner2')" accept="image/*" ref="heroBanner2Input" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.heroBanner2Input.click()">Upload</button>
              </div>
            </div>

            <!-- Tentang Image -->
            <div class="form-group">
              <label class="form-label">Gambar Section Tentang (4:3)</label>
              <div class="image-upload">
                <div v-if="tentangImagePreview || form.home_tentang_image" class="image-preview landscape">
                  <img :src="tentangImagePreview || getImageUrl(form.home_tentang_image)" alt="Tentang">
                </div>
                <div v-else class="image-placeholder landscape">
                  <span>📸</span>
                </div>
                <input type="file" @change="e => handleImage(e, 'tentangImage')" accept="image/*" ref="tentangImageInput" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.tentangImageInput.click()">Upload</button>
              </div>
            </div>

            <!-- Cara Pemesanan Image -->
            <div class="form-group">
              <label class="form-label">Gambar Cara Pemesanan (16:9)</label>
              <div class="image-upload">
                <div v-if="caraPemesananPreview || form.home_cara_pemesanan" class="image-preview wide">
                  <img :src="caraPemesananPreview || getImageUrl(form.home_cara_pemesanan)" alt="Cara Pemesanan">
                </div>
                <div v-else class="image-placeholder wide">
                  <span>📋</span>
                </div>
                <input type="file" @change="e => handleImage(e, 'caraPemesanan')" accept="image/*" ref="caraPemesananInput" style="display:none">
                <button type="button" class="btn btn-outline" @click="$refs.caraPemesananInput.click()">Upload</button>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="btn btn-primary" @click="saveHomeContent" :disabled="saving">
                {{ saving ? 'Menyimpan...' : 'Simpan Gambar Beranda' }}
              </button>
            </div>
          </div>

          <!-- Tentang Tab -->
          <div v-if="activeTab === 'tentang'" class="content-form">
            <h3 class="form-section-title">Konten Halaman Tentang Kami</h3>

            <form @submit.prevent="saveTentangContent">
              <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" v-model="form.title" class="form-control" placeholder="Dapur Nyonya">
              </div>

              <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea v-model="form.subtitle" class="form-control" rows="3" placeholder="Deskripsi singkat..."></textarea>
              </div>

              <div class="form-group">
                <label class="form-label">Foto Owner (200x250)</label>
                <div class="image-upload">
                  <div v-if="ownerImagePreview || form.owner_image" class="image-preview portrait">
                    <img :src="ownerImagePreview || getImageUrl(form.owner_image)" alt="Owner">
                  </div>
                  <div v-else class="image-placeholder portrait">
                    <span>👩‍🍳</span>
                  </div>
                  <input type="file" @change="e => handleImage(e, 'ownerImage')" accept="image/*" ref="ownerImageInput" style="display:none">
                  <button type="button" class="btn btn-outline" @click="$refs.ownerImageInput.click()">Upload</button>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Latar Belakang</label>
                <textarea v-model="form.latar_belakang" class="form-control" rows="12" placeholder="Tuliskan latar belakang..."></textarea>
                <small class="form-hint">Pisahkan paragraf dengan enter dua kali</small>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary" :disabled="saving">
                  {{ saving ? 'Menyimpan...' : 'Simpan Konten Tentang' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import kontenService from '@/services/kontenService'
import authService from '@/services/authService'

export default {
  name: 'KontenManagement',
  data() {
    return {
      loading: true,
      saving: false,
      message: '',
      messageType: '',
      activeTab: 'home',
      form: {
        title: 'Dapur Nyonya',
        subtitle: '',
        owner_image: '',
        latar_belakang: '',
        home_logo: '',
        home_hero_1: '',
        home_hero_2: '',
        home_tentang_image: '',
        home_cara_pemesanan: ''
      },
      ownerImagePreview: null,
      ownerImageFile: null,
      homeLogoPreview: null,
      homeLogoFile: null,
      heroBanner1Preview: null,
      heroBanner1File: null,
      heroBanner2Preview: null,
      heroBanner2File: null,
      tentangImagePreview: null,
      tentangImageFile: null,
      caraPemesananPreview: null,
      caraPemesananFile: null
    }
  },
  async mounted() {
    await this.loadContent()
  },
  methods: {
    async loadContent() {
      try {
        const response = await kontenService.getAll()
        const konten = response.data.data

        if (konten.tentang_title) this.form.title = konten.tentang_title.value
        if (konten.tentang_subtitle) this.form.subtitle = konten.tentang_subtitle.value
        if (konten.tentang_owner_image) this.form.owner_image = konten.tentang_owner_image.value
        if (konten.tentang_latar_belakang) this.form.latar_belakang = konten.tentang_latar_belakang.value
        if (konten.home_logo) this.form.home_logo = konten.home_logo.value
        if (konten.home_hero_1) this.form.home_hero_1 = konten.home_hero_1.value
        if (konten.home_hero_2) this.form.home_hero_2 = konten.home_hero_2.value
        if (konten.home_tentang_image) this.form.home_tentang_image = konten.home_tentang_image.value
        if (konten.home_cara_pemesanan) this.form.home_cara_pemesanan = konten.home_cara_pemesanan.value
      } catch (error) {
        console.error('Error loading content:', error)
      } finally {
        this.loading = false
      }
    },
    handleImage(event, type) {
      const file = event.target.files[0]
      if (!file) return
      
      const preview = URL.createObjectURL(file)
      
      if (type === 'ownerImage') {
        this.ownerImageFile = file
        this.ownerImagePreview = preview
      } else if (type === 'homeLogo') {
        this.homeLogoFile = file
        this.homeLogoPreview = preview
      } else if (type === 'heroBanner1') {
        this.heroBanner1File = file
        this.heroBanner1Preview = preview
      } else if (type === 'heroBanner2') {
        this.heroBanner2File = file
        this.heroBanner2Preview = preview
      } else if (type === 'tentangImage') {
        this.tentangImageFile = file
        this.tentangImagePreview = preview
      } else if (type === 'caraPemesanan') {
        this.caraPemesananFile = file
        this.caraPemesananPreview = preview
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      const apiUrl = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'
      const baseUrl = apiUrl.replace(/\/api\/?$/, '')
      return `${baseUrl}/storage/${path}`
    },
    async saveHomeContent() {
      this.saving = true
      this.message = ''

      try {
        if (this.homeLogoFile) {
          await kontenService.uploadImage('home_logo', this.homeLogoFile)
          this.homeLogoFile = null
        }
        if (this.heroBanner1File) {
          await kontenService.uploadImage('home_hero_1', this.heroBanner1File)
          this.heroBanner1File = null
        }
        if (this.heroBanner2File) {
          await kontenService.uploadImage('home_hero_2', this.heroBanner2File)
          this.heroBanner2File = null
        }
        if (this.tentangImageFile) {
          await kontenService.uploadImage('home_tentang_image', this.tentangImageFile)
          this.tentangImageFile = null
        }
        if (this.caraPemesananFile) {
          await kontenService.uploadImage('home_cara_pemesanan', this.caraPemesananFile)
          this.caraPemesananFile = null
        }

        this.message = 'Gambar beranda berhasil disimpan!'
        this.messageType = 'success'
        await this.loadContent()
      } catch (error) {
        console.error('Error saving:', error)
        this.message = 'Gagal menyimpan'
        this.messageType = 'error'
      } finally {
        this.saving = false
      }
    },
    async saveTentangContent() {
      this.saving = true
      this.message = ''

      try {
        await kontenService.bulkUpdate([
          { key: 'tentang_title', value: this.form.title, type: 'text' },
          { key: 'tentang_subtitle', value: this.form.subtitle, type: 'text' },
          { key: 'tentang_latar_belakang', value: this.form.latar_belakang, type: 'html' }
        ])

        if (this.ownerImageFile) {
          await kontenService.uploadImage('tentang_owner_image', this.ownerImageFile)
          this.ownerImageFile = null
        }

        this.message = 'Konten tentang berhasil disimpan!'
        this.messageType = 'success'
        await this.loadContent()
      } catch (error) {
        console.error('Error saving:', error)
        this.message = 'Gagal menyimpan'
        this.messageType = 'error'
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
.logout-btn { width: 100%; padding: 0.75rem; background: transparent; border: 1px solid #666; color: #ccc; cursor: pointer; border-radius: var(--radius-md); }
.logout-btn:hover { background: #dc3545; border-color: #dc3545; color: white; }

.main-content { flex: 1; background: #f5f5f5; }
.header { background: white; padding: 1.5rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.header h1 { font-size: 1.5rem; color: var(--text-primary); }
.content { padding: 2rem; }

.tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
.tab {
  padding: 0.75rem 1.5rem;
  background: white;
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: all 0.3s ease;
}
.tab.active { background: var(--primary); color: white; border-color: var(--primary); }
.tab:hover:not(.active) { background: #f0f0f0; }

.content-form { background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }

.form-section-title { font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--text-primary); }

.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; }
.form-control { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; }
.form-control:focus { outline: none; border-color: var(--primary); }
.form-hint { display: block; margin-top: 0.25rem; color: var(--text-secondary); font-size: 0.85rem; }

.image-upload { display: flex; align-items: center; gap: 1.5rem; }

.image-preview, .image-placeholder {
  border: 2px solid var(--border);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9f9f9;
}

.image-preview img { width: 100%; height: 100%; object-fit: cover; }
.image-placeholder span { font-size: 2.5rem; }

.image-preview.small, .image-placeholder.small { width: 100px; height: 100px; }
.image-preview.portrait, .image-placeholder.portrait { width: 150px; height: 180px; }
.image-preview.landscape, .image-placeholder.landscape { width: 200px; height: 150px; }
.image-preview.wide, .image-placeholder.wide { width: 240px; height: 135px; }

.form-actions { margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); }

.alert { padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; }
.alert-success { background: #d4edda; color: #155724; }
.alert-error { background: #f8d7da; color: #721c24; }
</style>
