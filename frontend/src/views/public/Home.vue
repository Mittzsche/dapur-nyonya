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

/* Hero Section - Red Gradient Background */
.hero {
  padding-top: 5rem;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
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
  width: 120px;
  height: 120px;
  border: 3px solid rgba(255,255,255,0.5);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3.5rem;
  margin: 0 auto;
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
}

.logo-image {
  width: 120px;
  height: 120px;
  margin: 0 auto;
  overflow: hidden;
  border-radius: 50%;
  border: 3px solid rgba(255,255,255,0.5);
}

.logo-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  background: white;
}

.hero-title {
  font-family: var(--font-heading);
  font-size: 3.5rem;
  margin-bottom: 0.5rem;
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.hero-motto {
  color: rgba(255,255,255,0.9);
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.hero .btn-primary {
  background: white;
  color: var(--primary);
  border-color: white;
  font-weight: 700;
}

.hero .btn-primary:hover {
  background: var(--accent);
  border-color: var(--accent);
  color: #333;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.btn-outline-dark {
  border: 2px solid white;
  color: white;
  background: transparent;
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius-md);
  transition: all 0.3s ease;
  font-weight: 600;
}

.btn-outline-dark:hover {
  background: white;
  color: var(--primary);
  transform: translateY(-3px);
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
  border: 3px solid rgba(255,255,255,0.3);
  border-radius: var(--radius-lg);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: rgba(255,255,255,0.1);
  overflow: hidden;
  transition: all 0.3s ease;
}

.hero-image-box:hover {
  transform: scale(1.03);
  border-color: white;
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
  color: rgba(255,255,255,0.7);
  font-size: 0.9rem;
}

/* Divider - Enhanced */
.divider {
  height: 6px;
  background: linear-gradient(90deg, var(--primary-dark), var(--primary), var(--primary-light), var(--primary), var(--primary-dark));
}

/* Section Title */
.section-title {
  font-family: var(--font-heading);
  font-size: 2.5rem;
  text-align: center;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.section-title::after {
  content: '';
  display: block;
  width: 80px;
  height: 4px;
  background: var(--primary);
  margin: 0.75rem auto 0;
  border-radius: 2px;
}

.section-subtitle {
  text-align: center;
  color: var(--text-secondary);
  margin-bottom: 2rem;
  font-size: 1.1rem;
}

/* Kami Melayani - Light Red Background */
.kami-melayani {
  background: linear-gradient(180deg, #FFF5F5 0%, #FEF0F2 100%);
}

.menu-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-top: 2rem;
}

.menu-card {
  background: white;
  border: none;
  border-radius: var(--radius-lg);
  text-align: center;
  padding-bottom: 1.5rem;
  box-shadow: 0 4px 20px rgba(196, 30, 58, 0.1);
  transition: all 0.3s ease;
  overflow: hidden;
}

.menu-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 40px rgba(196, 30, 58, 0.2);
}

.menu-image {
  aspect-ratio: 4/3;
  background: linear-gradient(135deg, #f8f8f8 0%, #f0f0f0 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
}

.menu-image::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: var(--primary);
}

.menu-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.menu-image span {
  font-size: 3.5rem;
}

.menu-image p {
  color: var(--text-secondary);
  font-size: 0.85rem;
}

.menu-info {
  padding: 1.5rem 1rem;
}

.menu-info h3 {
  font-size: 1.1rem;
  color: var(--text-primary);
  font-weight: 600;
}

.menu-card .btn-outline {
  background: transparent;
  border: 2px solid var(--primary);
  color: var(--primary);
  font-weight: 600;
}

.menu-card .btn-outline:hover {
  background: var(--primary);
  color: white;
}

/* Tentang Section - Red Accent */
.tentang-section {
  background: white;
  position: relative;
}

.tentang-section::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 8px;
  background: var(--primary);
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
  border: none;
  border-radius: var(--radius-lg);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #FEF0F2 0%, #FFE5E8 100%);
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(196, 30, 58, 0.15);
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
  color: var(--primary);
}

.tentang-title {
  font-family: var(--font-heading);
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: var(--primary);
  position: relative;
}

.tentang-text {
  color: var(--text-secondary);
  line-height: 1.8;
  margin-bottom: 1rem;
  font-size: 1.05rem;
}

/* Galeri Section - Gradient Background */
.galeri-section {
  background: linear-gradient(180deg, #f8f8f8 0%, #FFF5F5 100%);
}

.galeri-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 2rem;
}

.galeri-item {
  aspect-ratio: 4/3;
  border: none;
  border-radius: var(--radius-lg);
  background: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.galeri-item:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 30px rgba(196, 30, 58, 0.2);
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

/* Testimoni Section - Red Background */
.testimoni-section {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
}

.testimoni-section .section-title {
  color: white;
}

.testimoni-section .section-title::after {
  background: white;
}

.testimoni-section .section-subtitle {
  color: rgba(255,255,255,0.8);
}

.testimoni-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 2rem;
  margin-bottom: 2rem;
}

.testimoni-card {
  border: none;
  border-radius: var(--radius-lg);
  background: rgba(255,255,255,0.1);
  overflow: hidden;
  transition: all 0.3s ease;
}

.testimoni-card:hover {
  transform: translateY(-5px);
  background: rgba(255,255,255,0.2);
}

.testimoni-image {
  aspect-ratio: 3/4;
  background: rgba(255,255,255,0.05);
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
  color: rgba(255,255,255,0.6);
}

.testimoni-section .btn-primary {
  background: white;
  color: var(--primary);
  border-color: white;
  font-weight: 700;
}

.testimoni-section .btn-primary:hover {
  background: var(--accent);
  border-color: var(--accent);
  color: #333;
}

.text-center {
  text-align: center;
}

.mt-2 {
  margin-top: 2rem;
}

/* Cara Pemesanan - Gradient */
.cara-pemesanan-section {
  background: linear-gradient(180deg, #FFF5F5 0%, white 100%);
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
  border: none;
  border-radius: var(--radius-lg);
  background: linear-gradient(135deg, #FEF0F2 0%, #FFE5E8 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 2rem;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(196, 30, 58, 0.15);
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
  color: var(--primary);
}

.pesan-btn {
  padding: 1.25rem 4rem;
  font-size: 1.3rem;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  border: none;
  border-radius: 50px;
  box-shadow: 0 8px 25px rgba(196, 30, 58, 0.4);
  transition: all 0.3s ease;
}

.pesan-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 35px rgba(196, 30, 58, 0.5);
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
  
  .tentang-section::before {
    display: none;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
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
  
  .section-title {
    font-size: 2rem;
  }
}
</style>

