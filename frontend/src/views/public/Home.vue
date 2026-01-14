<template>
  <div class="home">
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="container hero-content">
        <h1 class="hero-title">Catering Berkualitas untuk Setiap Momen Spesial Anda</h1>
        <p class="hero-subtitle">
          Dapur Nyonya menyajikan hidangan lezat dengan cita rasa khas Indonesia 
          untuk berbagai acara - dari pesta pernikahan hingga meeting kantor.
        </p>
        <div class="hero-buttons">
          <router-link to="/hubungi" class="btn btn-primary btn-lg">Pesan Sekarang</router-link>
          <router-link to="/layanan" class="btn btn-outline btn-lg">Lihat Menu</router-link>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section why-us">
      <div class="container">
        <h2 class="section-title">Mengapa Memilih Kami?</h2>
        <p class="section-subtitle">Komitmen kami adalah kepuasan pelanggan</p>
        
        <div class="grid grid-4">
          <div class="why-card">
            <div class="why-icon">🍽️</div>
            <h3>Menu Beragam</h3>
            <p>Pilihan menu yang bervariasi dari tradisional hingga modern</p>
          </div>
          <div class="why-card">
            <div class="why-icon">⭐</div>
            <h3>Kualitas Terjamin</h3>
            <p>Bahan berkualitas dan freshness terjaga</p>
          </div>
          <div class="why-card">
            <div class="why-icon">💰</div>
            <h3>Harga Bersaing</h3>
            <p>Paket hemat tanpa mengurangi kualitas rasa</p>
          </div>
          <div class="why-card">
            <div class="why-icon">🚚</div>
            <h3>Tepat Waktu</h3>
            <p>Pengiriman on-time untuk kenyamanan acara Anda</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Popular Services Preview -->
    <section class="section services-preview" style="background: white;">
      <div class="container">
        <h2 class="section-title">Paket Favorit Kami</h2>
        <p class="section-subtitle">Menu pilihan yang paling diminati pelanggan</p>
        
        <div v-if="loading" class="loading">
          <div class="spinner"></div>
        </div>
        
        <div v-else class="grid grid-3">
          <div v-for="layanan in popularLayanan" :key="layanan.id_layanan" class="card">
            <div class="card-image-placeholder">
              <span>🍱</span>
            </div>
            <div class="card-content">
              <h3 class="card-title">{{ layanan.nama_paket }}</h3>
              <p class="card-text">{{ truncateText(layanan.deskripsi, 80) }}</p>
              <p class="card-price">Rp {{ formatPrice(layanan.harga) }}</p>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-2">
          <router-link to="/layanan" class="btn btn-secondary">Lihat Semua Paket</router-link>
        </div>
      </div>
    </section>

    <!-- How to Order Section -->
    <section class="section how-to-order">
      <div class="container">
        <h2 class="section-title">Cara Pemesanan</h2>
        <p class="section-subtitle">Proses mudah dalam 4 langkah</p>
        
        <div class="steps-container">
          <div class="step">
            <div class="step-number">1</div>
            <h4>Pilih Paket</h4>
            <p>Tentukan paket catering sesuai kebutuhan acara Anda</p>
          </div>
          <div class="step-arrow">→</div>
          <div class="step">
            <div class="step-number">2</div>
            <h4>Isi Formulir</h4>
            <p>Lengkapi data pemesanan melalui form online</p>
          </div>
          <div class="step-arrow">→</div>
          <div class="step">
            <div class="step-number">3</div>
            <h4>Konfirmasi</h4>
            <p>Tim kami akan menghubungi untuk konfirmasi</p>
          </div>
          <div class="step-arrow">→</div>
          <div class="step">
            <div class="step-number">4</div>
            <h4>Terima Pesanan</h4>
            <p>Pesanan dikirim tepat waktu ke lokasi Anda</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <h2>Siap untuk Memesan?</h2>
        <p>Hubungi kami sekarang dan dapatkan penawaran terbaik untuk acara Anda</p>
        <router-link to="/hubungi" class="btn btn-primary btn-lg">Hubungi Kami</router-link>
      </div>
    </section>
  </div>
</template>

<script>
import layananService from '@/services/layananService'

export default {
  name: 'Home',
  data() {
    return {
      popularLayanan: [],
      loading: true
    }
  },
  async mounted() {
    await this.fetchLayanan()
  },
  methods: {
    async fetchLayanan() {
      try {
        const response = await layananService.getAll()
        this.popularLayanan = response.data.data.slice(0, 3)
      } catch (error) {
        console.error('Error fetching layanan:', error)
      } finally {
        this.loading = false
      }
    },
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    truncateText(text, length) {
      if (text.length <= length) return text
      return text.substring(0, length) + '...'
    }
  }
}
</script>

<style scoped>
/* Hero Section */
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
  position: relative;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><circle cx="40" cy="40" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
  background-size: 40px 40px;
}

.hero-content {
  position: relative;
  z-index: 1;
  text-align: center;
  color: white;
  max-width: 800px;
  margin: 0 auto;
  padding-top: 80px;
}

.hero-title {
  font-family: 'Georgia', serif;
  font-size: 3rem;
  line-height: 1.2;
  margin-bottom: 1.5rem;
}

.hero-subtitle {
  font-size: 1.25rem;
  margin-bottom: 2rem;
  opacity: 0.9;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.hero .btn-outline {
  border-color: white;
  color: white;
}

.hero .btn-outline:hover {
  background: white;
  color: var(--primary);
}

/* Why Choose Us */
.why-us {
  background: var(--background);
}

.why-card {
  text-align: center;
  padding: 2rem;
  background: white;
  border-radius: var(--radius-lg);
  transition: transform 0.3s ease;
}

.why-card:hover {
  transform: translateY(-5px);
}

.why-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.why-card h3 {
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.why-card p {
  color: var(--text-secondary);
  font-size: 0.9rem;
}

/* Card Image Placeholder */
.card-image-placeholder {
  height: 180px;
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 4rem;
}

/* How to Order */
.how-to-order {
  background: var(--background);
}

.steps-container {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.step {
  text-align: center;
  max-width: 200px;
}

.step-number {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: var(--primary);
  color: white;
  font-size: 1.5rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
}

.step h4 {
  margin-bottom: 0.5rem;
}

.step p {
  color: var(--text-secondary);
  font-size: 0.9rem;
}

.step-arrow {
  font-size: 2rem;
  color: var(--primary);
  margin-top: 1rem;
}

/* CTA Section */
.cta-section {
  background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
  color: white;
  text-align: center;
  padding: 4rem 0;
}

.cta-section h2 {
  font-family: 'Georgia', serif;
  font-size: 2rem;
  margin-bottom: 1rem;
}

.cta-section p {
  margin-bottom: 1.5rem;
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .hero-subtitle {
    font-size: 1rem;
  }

  .step-arrow {
    display: none;
  }

  .steps-container {
    gap: 2rem;
  }
}
</style>
