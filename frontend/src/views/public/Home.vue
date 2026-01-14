<template>
  <div class="home">
    <!-- Hero Section -->
    <section class="section-full hero">
      <div class="container">
        <div class="hero-content">
          <div class="hero-logo">
            <div v-if="heroLogo" class="logo-image">
              <img :src="getImageUrl(heroLogo)" alt="Logo Dapur Nyonya">
            </div>
            <div v-else class="logo-placeholder">🍽️</div>
          </div>
          <h1 class="hero-title">Dapur Nyonya</h1>
          <p class="hero-motto">Catering Berkualitas untuk Setiap Momen Spesial</p>
          
          <div class="hero-buttons">
            <router-link to="/hubungi" class="btn btn-primary">Pesan Sekarang</router-link>
            <router-link to="/layanan" class="btn btn-outline-dark">Lihat Menu</router-link>
            <router-link to="/hubungi" class="btn btn-outline-dark">Hubungi Kami</router-link>
          </div>
        </div>
        
        <!-- Featured Images from Galeri -->
        <div class="hero-images">
          <div v-for="(item, index) in heroGaleri" :key="index" class="hero-image-box">
            <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.caption">
            <template v-else>
              <span>📸</span>
              <p>Gambar</p>
            </template>
          </div>
          <template v-if="heroGaleri.length === 0">
            <div class="hero-image-box">
              <span>📸</span>
              <p>Gambar</p>
            </div>
            <div class="hero-image-box">
              <span>📸</span>
              <p>Gambar</p>
            </div>
          </template>
        </div>
      </div>
    </section>

    <!-- Divider Line -->
    <div class="divider"></div>

    <!-- Kami Melayani Section -->
    <section class="section-full kami-melayani">
      <div class="container">
        <h2 class="section-title">Kami Melayani</h2>
        
        <div v-if="loading" class="loading">
          <div class="spinner"></div>
        </div>
        
        <div v-else class="menu-grid">
          <div v-for="layanan in layananList" :key="layanan.id_layanan" class="menu-card">
            <div class="menu-image">
              <img v-if="layanan.gambar" :src="getImageUrl(layanan.gambar)" :alt="layanan.nama_paket">
              <template v-else>
                <span>🍱</span>
                <p>Gambar Menu</p>
              </template>
            </div>
            <div class="menu-info">
              <h3>{{ layanan.nama_paket }}</h3>
            </div>
            <router-link to="/layanan" class="btn btn-outline">Lihat Selengkapnya</router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Tentang Kami Section -->
    <section class="section-full tentang-section">
      <div class="container">
        <div class="tentang-grid">
          <div class="tentang-image">
            <div v-if="tentangImage" class="image-real">
              <img :src="getImageUrl(tentangImage)" alt="Tentang Dapur Nyonya">
            </div>
            <div v-else class="image-placeholder">
              <span>📸</span>
              <p>Gambar</p>
            </div>
          </div>
          <div class="tentang-content">
            <h2 class="tentang-title">Tentang Kami</h2>
            <p class="tentang-text">
              Dapur Nyonya adalah layanan catering profesional yang berbasis di Sukabumi, 
              Jawa Barat. Didirikan dengan passion untuk menyajikan hidangan berkualitas 
              tinggi dengan cita rasa khas Indonesia yang autentik.
            </p>
            <p class="tentang-text">
              Kami melayani berbagai jenis acara mulai dari pesta pernikahan, arisan, 
              meeting kantor, seminar, hingga acara keluarga. Dengan pengalaman bertahun-tahun 
              di industri kuliner, kami berkomitmen untuk memberikan pelayanan terbaik.
            </p>
            <router-link to="/tentang" class="btn btn-primary">Selengkapnya</router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Galeri Section -->
    <section class="section-full galeri-section">
      <div class="container">
        <h2 class="section-title">Galeri Dapur Nyonya</h2>
        
        <div class="galeri-grid">
          <div v-for="(item, index) in displayGaleri" :key="index" class="galeri-item">
            <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.caption">
            <template v-else>
              <span>📸</span>
              <p>Gambar</p>
            </template>
          </div>
          <template v-if="displayGaleri.length === 0">
            <div class="galeri-item"><span>📸</span><p>Gambar</p></div>
            <div class="galeri-item"><span>📸</span><p>Gambar</p></div>
            <div class="galeri-item"><span>📸</span><p>Gambar</p></div>
          </template>
        </div>
      </div>
    </section>

    <!-- Testimoni Section -->
    <section class="section-full testimoni-section">
      <div class="container">
        <h2 class="section-title">Testimoni</h2>
        <p class="section-subtitle">Apa kata mereka...</p>
        
        <div class="testimoni-grid">
          <div v-for="(item, index) in displayTestimoni" :key="index" class="testimoni-card">
            <div class="testimoni-image">
              <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.caption">
              <template v-else>
                <span>📸</span>
                <p>Gambar</p>
              </template>
            </div>
          </div>
          <template v-if="displayTestimoni.length === 0">
            <div class="testimoni-card"><div class="testimoni-image"><span>📸</span><p>Gambar</p></div></div>
            <div class="testimoni-card"><div class="testimoni-image"><span>📸</span><p>Gambar</p></div></div>
            <div class="testimoni-card"><div class="testimoni-image"><span>📸</span><p>Gambar</p></div></div>
          </template>
        </div>

        <div class="text-center mt-2">
          <router-link to="/testimoni" class="btn btn-primary">Lihat Semua Testimoni</router-link>
        </div>
      </div>
    </section>

    <!-- Cara Pemesanan Section -->
    <section class="section-full cara-pemesanan-section">
      <div class="container cara-container">
        <h2 class="section-title">Cara Pemesanan</h2>
        
        <div class="cara-pemesanan-box">
          <div class="panduan-image">
            <img v-if="caraPemesananImage" :src="getImageUrl(caraPemesananImage)" alt="Cara Pemesanan">
            <template v-else>
              <span>📋</span>
              <p>Gambar / Panduan Pemesanan</p>
            </template>
          </div>
          <router-link to="/hubungi" class="btn btn-primary btn-lg pesan-btn">Pesan Sekarang!</router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import layananService from '@/services/layananService'
import galeriService from '@/services/galeriService'
import testimoniService from '@/services/testimoniService'
import kontenService from '@/services/kontenService'

export default {
  name: 'Home',
  data() {
    return {
      layananList: [],
      galeriList: [],
      testimoniList: [],
      heroLogo: '',
      tentangImage: '',
      caraPemesananImage: '',
      loading: true
    }
  },
  computed: {
    heroGaleri() {
      return this.galeriList.slice(0, 2)
    },
    displayGaleri() {
      return this.galeriList.slice(0, 3)
    },
    displayTestimoni() {
      return this.testimoniList.slice(0, 3)
    }
  },
  async mounted() {
    await Promise.all([
      this.fetchLayanan(),
      this.fetchGaleri(),
      this.fetchTestimoni(),
      this.fetchKonten()
    ])
    this.loading = false
  },
  methods: {
    async fetchLayanan() {
      try {
        const response = await layananService.getAll()
        this.layananList = response.data.data
      } catch (error) {
        console.error('Error fetching layanan:', error)
      }
    },
    async fetchGaleri() {
      try {
        const response = await galeriService.getAll()
        this.galeriList = response.data.data
      } catch (error) {
        console.error('Error fetching galeri:', error)
      }
    },
    async fetchTestimoni() {
      try {
        const response = await testimoniService.getAll()
        this.testimoniList = response.data.data
      } catch (error) {
        console.error('Error fetching testimoni:', error)
      }
    },
    async fetchKonten() {
      try {
        const response = await kontenService.getAll()
        const konten = response.data.data
        if (konten.home_logo) this.heroLogo = konten.home_logo.value
        if (konten.home_tentang_image) this.tentangImage = konten.home_tentang_image.value
        if (konten.home_cara_pemesanan) this.caraPemesananImage = konten.home_cara_pemesanan.value
      } catch (error) {
        console.error('Error fetching konten:', error)
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      return `http://localhost:8000/storage/${path}`
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    }
  }
}
</script>

<style scoped>
/* Full height section */
.section-full {
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 2rem 0;
}

/* Hero Section */
.hero {
  padding-top: 5rem;
  background: var(--background);
}

.hero .container {
  width: 100%;
}

.hero-content {
  text-align: center;
  margin-bottom: 3rem;
}

.hero-logo {
  margin-bottom: 1rem;
}

.logo-placeholder {
  width: 100px;
  height: 100px;
  border: 2px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  margin: 0 auto;
  background: #f9f9f9;
}

.logo-image {
  width: 100px;
  height: 100px;
  margin: 0 auto;
  overflow: hidden;
}

.logo-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.hero-title {
  font-family: var(--font-heading);
  font-size: 3rem;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.hero-motto {
  color: var(--text-secondary);
  font-size: 1.1rem;
  margin-bottom: 2rem;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-outline-dark {
  border: 2px solid var(--text-primary);
  color: var(--text-primary);
  background: transparent;
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius-md);
  transition: all 0.3s ease;
}

.btn-outline-dark:hover {
  background: var(--text-primary);
  color: white;
}

.hero-images {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  max-width: 700px;
  margin: 0 auto;
}

.hero-image-box {
  aspect-ratio: 4/3;
  border: 2px solid var(--border);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f9f9f9;
  overflow: hidden;
}

.hero-image-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.hero-image-box span {
  font-size: 3rem;
}

.hero-image-box p {
  color: var(--text-secondary);
  font-size: 0.9rem;
}

/* Divider */
.divider {
  height: 4px;
  background: var(--primary);
}

/* Section Title */
.section-title {
  font-family: var(--font-heading);
  font-size: 2rem;
  text-align: center;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.section-title::after {
  content: '';
  display: block;
  width: 60px;
  height: 3px;
  background: var(--primary);
  margin: 0.5rem auto 0;
}

.section-subtitle {
  text-align: center;
  color: var(--text-secondary);
  margin-bottom: 2rem;
}

/* Kami Melayani */
.kami-melayani {
  background: #f9f9f9;
}

.menu-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-top: 2rem;
}

.menu-card {
  background: white;
  border: 2px solid var(--border);
  text-align: center;
  padding-bottom: 1.5rem;
}

.menu-image {
  aspect-ratio: 4/3;
  background: #f0f0f0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-bottom: 2px solid var(--border);
  overflow: hidden;
}

.menu-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.menu-image span {
  font-size: 3rem;
}

.menu-image p {
  color: var(--text-secondary);
  font-size: 0.85rem;
}

.menu-info {
  padding: 1rem;
}

.menu-info h3 {
  font-size: 1rem;
  color: var(--text-primary);
}

/* Tentang Section */
.tentang-section {
  background: white;
}

.tentang-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.tentang-image .image-placeholder,
.tentang-image .image-real {
  aspect-ratio: 4/3;
  border: 2px solid var(--border);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f9f9f9;
  overflow: hidden;
}

.tentang-image .image-real img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.tentang-image span {
  font-size: 4rem;
}

.tentang-image p {
  color: var(--text-secondary);
}

.tentang-title {
  font-family: var(--font-heading);
  font-size: 2rem;
  margin-bottom: 1rem;
  color: var(--text-primary);
}

.tentang-text {
  color: var(--text-secondary);
  line-height: 1.7;
  margin-bottom: 1rem;
}

/* Galeri Section */
.galeri-section {
  background: #f9f9f9;
}

.galeri-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 2rem;
}

.galeri-item {
  aspect-ratio: 4/3;
  border: 2px solid var(--border);
  background: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.galeri-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.galeri-item span {
  font-size: 3rem;
}

.galeri-item p {
  color: var(--text-secondary);
}

/* Testimoni Section */
.testimoni-section {
  background: white;
}

.testimoni-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 2rem;
  margin-bottom: 2rem;
}

.testimoni-card {
  border: 2px solid var(--border);
}

.testimoni-image {
  aspect-ratio: 3/4;
  background: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.testimoni-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.testimoni-image span {
  font-size: 3rem;
}

.testimoni-image p {
  color: var(--text-secondary);
}

.text-center {
  text-align: center;
}

.mt-2 {
  margin-top: 2rem;
}

/* Cara Pemesanan */
.cara-pemesanan-section {
  background: #f5f5f5;
}

.cara-container {
  text-align: center;
}

.cara-pemesanan-box {
  max-width: 800px;
  margin: 2rem auto 0;
}

.panduan-image {
  aspect-ratio: 16/9;
  border: 2px solid var(--border);
  background: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 2rem;
  overflow: hidden;
}

.panduan-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.panduan-image span {
  font-size: 4rem;
}

.panduan-image p {
  color: var(--text-secondary);
}

.pesan-btn {
  padding: 1rem 3rem;
  font-size: 1.2rem;
}

/* Responsive */
@media (max-width: 992px) {
  .menu-grid,
  .galeri-grid,
  .testimoni-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .tentang-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .hero-images {
    grid-template-columns: 1fr;
  }
  
  .menu-grid,
  .galeri-grid,
  .testimoni-grid {
    grid-template-columns: 1fr;
  }
  
  .section-full {
    min-height: auto;
    padding: 4rem 0;
  }
}
</style>
