<template>
  <div class="home">
    <!-- Hero Section -->
    <section class="section-full hero">
      <div class="container">
        <div class="hero-content">
          <div class="hero-logo">
            <div v-if="heroLogo" class="logo-image">
              <img :src="heroLogo" alt="Logo Dapur Nyonya">
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
        
        <!-- Promotional Banners (Mengapa Memilih Kami) -->
        <div class="hero-images">
          <div class="hero-image-box">
            <img v-if="heroBanner1" :src="getImageUrl(heroBanner1)" alt="Mengapa Memilih Kami">
            <template v-else>
              <span>🚚</span>
              <p>Pesan Antar</p>
            </template>
          </div>
          <div class="hero-image-box">
            <img v-if="heroBanner2" :src="getImageUrl(heroBanner2)" alt="Mengapa Memilih Kami">
            <template v-else>
              <span>⚡</span>
              <p>Cepat & Efisien</p>
            </template>
          </div>
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
        
        <!-- Auto-scroll Carousel -->
        <div class="galeri-carousel" 
             ref="galeriCarousel"
             @mouseenter="pauseAutoScroll"
             @mouseleave="resumeAutoScroll"
             @touchstart="pauseAutoScroll"
             @touchend="resumeAutoScroll">
          <div class="galeri-track" ref="galeriTrack">
            <div v-for="(item, index) in infiniteGaleri" :key="'galeri-' + index" class="galeri-item">
              <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.caption">
              <template v-else>
                <span>📸</span>
                <p>Gambar</p>
              </template>
            </div>
          </div>
        </div>
        
        <!-- Navigation dots -->
        <div class="galeri-dots" v-if="galeriList.length > 0">
          <button v-for="(_, index) in galeriList" 
                  :key="index" 
                  :class="['dot', currentGaleriIndex === index ? 'active' : '']"
                  @click="scrollToGaleri(index)">
          </button>
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
import dapurNyonyaLogo from '@/assets/dapur-nyonya-logo.png'

export default {
  name: 'Home',
  data() {
    return {
      layananList: [],
      galeriList: [],
      testimoniList: [],
      heroLogo: dapurNyonyaLogo,
      heroBanner1: '',
      heroBanner2: '',
      tentangImage: '',
      caraPemesananImage: '',
      loading: true,
      galeriScrollInterval: null,
      currentGaleriIndex: 0,
      isAutoScrollPaused: false
    }
  },
  computed: {
    infiniteGaleri() {
      // Triple the array for seamless looping
      if (this.galeriList.length === 0) return []
      return [...this.galeriList, ...this.galeriList, ...this.galeriList]
    },
    displayTestimoni() {
      return this.testimoniList.slice(0, 3)
    }
  },
  async mounted() {
    try {
      await Promise.allSettled([
        this.fetchLayanan(),
        this.fetchGaleri(),
        this.fetchTestimoni(),
        this.fetchKonten()
      ])
    } catch (error) {
      console.error('Error mounting Home:', error)
    } finally {
      this.loading = false
    }
    this.$nextTick(() => {
      this.initGaleriCarousel()
    })
  },
  beforeUnmount() {
    this.stopAutoScroll()
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
        if (konten.home_hero_1) this.heroBanner1 = konten.home_hero_1.value
        if (konten.home_hero_2) this.heroBanner2 = konten.home_hero_2.value
        if (konten.home_tentang_image) this.tentangImage = konten.home_tentang_image.value
        if (konten.home_cara_pemesanan) this.caraPemesananImage = konten.home_cara_pemesanan.value
      } catch (error) {
        console.error('Error fetching konten:', error)
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      const apiUrl = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'
      const baseUrl = apiUrl.replace(/\/api\/?$/, '')
      return `${baseUrl}/storage/${path}`
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    initGaleriCarousel() {
      if (this.galeriList.length === 0) return
      
      // Start at the middle set (so we can scroll both ways)
      this.$nextTick(() => {
        const carousel = this.$refs.galeriCarousel
        if (carousel) {
          const itemWidth = carousel.offsetWidth / 3 + 24 // item width + gap
          carousel.scrollLeft = itemWidth * this.galeriList.length
          this.startAutoScroll()
        }
      })
    },
    startAutoScroll() {
      this.stopAutoScroll()
      this.galeriScrollInterval = setInterval(() => {
        if (!this.isAutoScrollPaused) {
          this.scrollGaleriNext()
        }
      }, 3000)
    },
    stopAutoScroll() {
      if (this.galeriScrollInterval) {
        clearInterval(this.galeriScrollInterval)
        this.galeriScrollInterval = null
      }
    },
    pauseAutoScroll() {
      this.isAutoScrollPaused = true
    },
    resumeAutoScroll() {
      this.isAutoScrollPaused = false
    },
    scrollGaleriNext() {
      const carousel = this.$refs.galeriCarousel
      if (!carousel) return
      
      const itemWidth = carousel.offsetWidth / 3 + 24
      const maxScroll = carousel.scrollWidth - carousel.offsetWidth
      
      carousel.scrollBy({ left: itemWidth, behavior: 'smooth' })
      
      this.currentGaleriIndex = (this.currentGaleriIndex + 1) % this.galeriList.length
      
      // Reset to middle when reaching end
      setTimeout(() => {
        if (carousel.scrollLeft >= maxScroll - 10) {
          carousel.scrollLeft = itemWidth * this.galeriList.length
        }
      }, 500)
    },
    scrollToGaleri(index) {
      const carousel = this.$refs.galeriCarousel
      if (!carousel) return
      
      const itemWidth = carousel.offsetWidth / 3 + 24
      const targetScroll = itemWidth * (this.galeriList.length + index)
      
      carousel.scrollTo({ left: targetScroll, behavior: 'smooth' })
      this.currentGaleriIndex = index
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
  padding-left: 1rem;
  padding-right: 1rem;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
}

.hero .container {
  /* Let container use its default max-width and padding */
}

.hero-content {
  text-align: center;
  margin-bottom: 3rem;
  padding: 0 1.5rem;
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
  width: 200px;
  height: auto;
  margin: 0 auto;
}

.logo-image img {
  width: 100%;
  height: auto;
  object-fit: contain;
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

/* Auto-scroll Carousel */
.galeri-carousel {
  margin-top: 2rem;
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  cursor: grab;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.galeri-carousel::-webkit-scrollbar {
  display: none;
}

.galeri-carousel:active {
  cursor: grabbing;
}

.galeri-track {
  display: flex;
  gap: 1.5rem;
  padding: 1rem 0;
}

.galeri-item {
  min-width: calc((100% - 3rem) / 3);
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
  flex-shrink: 0;
}

.galeri-item:hover {
  transform: scale(1.03);
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

/* Navigation Dots */
.galeri-dots {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1.5rem;
}

.galeri-dots .dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid var(--primary);
  background: transparent;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 0;
}

.galeri-dots .dot:hover {
  background: rgba(196, 30, 58, 0.3);
}

.galeri-dots .dot.active {
  background: var(--primary);
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

  .galeri-item {
    min-width: calc((100% - 1.5rem) / 2);
  }
}

@media (max-width: 768px) {
  .hero {
    padding-top: 4rem;
  }

  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-motto {
    font-size: 1rem;
    padding: 0 1rem;
  }
  
  .hero-buttons {
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 0 1rem;
  }

  .hero-buttons .btn {
    width: 100%;
    max-width: 250px;
  }
  
  .hero-images {
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 0 1rem;
  }
  
  .menu-grid,
  .testimoni-grid {
    grid-template-columns: 1fr;
  }
  
  .section-full {
    min-height: auto;
    padding: 3rem 0;
  }
  
  .section-title {
    font-size: 1.75rem;
  }

  .galeri-item {
    min-width: 80%;
  }

  .pesan-btn {
    padding: 1rem 2.5rem;
    font-size: 1.1rem;
  }
}

@media (max-width: 480px) {
  .hero {
    padding-top: 3.5rem;
  }

  .hero-title {
    font-size: 2rem;
  }

  .hero-motto {
    font-size: 0.95rem;
  }

  .logo-placeholder,
  .logo-image {
    width: 150px;
    height: auto;
  }

  .logo-image {
  }

  .logo-placeholder {
    font-size: 2.5rem;
  }

  .hero-buttons {
    gap: 0.5rem;
  }

  .hero-buttons .btn {
    padding: 0.6rem 1.5rem;
    font-size: 0.9rem;
  }

  .btn-outline-dark {
    padding: 0.6rem 1.5rem;
  }

  .section-full {
    padding: 2rem 0;
  }

  .section-title {
    font-size: 1.5rem;
  }

  .menu-card .btn-outline {
    padding: 0.5rem 1.5rem;
    font-size: 0.85rem;
  }

  .galeri-item {
    min-width: 90%;
  }

  .testimoni-grid {
    gap: 1rem;
  }

  .pesan-btn {
    padding: 0.9rem 2rem;
    font-size: 1rem;
  }

  /* Hero banners - make larger on mobile */
  .hero-images {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    padding: 0 0.5rem;
    max-width: 100%;
  }

  .hero-image-box {
    aspect-ratio: 1/1;
    border-width: 2px;
  }

  .hero-image-box span {
    font-size: 2rem;
  }

  .hero-image-box p {
    font-size: 0.75rem;
  }

  /* Cara Pemesanan - make larger on mobile */
  .cara-pemesanan-box {
    padding: 0 0.5rem;
  }

  .panduan-image {
    aspect-ratio: 4/3;
    min-height: 200px;
  }

  .panduan-image span {
    font-size: 3rem;
  }

  .panduan-image p {
    font-size: 0.9rem;
  }
}
</style>

