<template>
  <div class="testimoni-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Testimoni</h1>
        <p>Apa kata pelanggan tentang kami</p>
      </div>
    </section>

    <!-- Testimonials Gallery -->
    <section class="section">
      <div class="container">
        <p class="gallery-intro text-center mb-2">
          Berikut adalah testimoni dari pelanggan setia Dapur Nyonya yang telah 
          mempercayakan kebutuhan catering mereka kepada kami.
        </p>

        <!-- Testimonial Images Grid -->
        <div class="testimoni-grid">
          <div class="testimoni-card" v-for="n in 6" :key="n">
            <div class="testimoni-image">
              <span>📸</span>
            </div>
            <p class="testimoni-caption">Testimoni Pelanggan #{{ n }}</p>
          </div>
        </div>

        <div class="text-center mt-2">
          <p class="follow-text">
            Lihat lebih banyak testimoni di Instagram kami 
            <a href="#" class="instagram-link">@dapurnyonya</a>
          </p>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats-section" style="background: white;">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-item">
            <span class="stat-number">500+</span>
            <span class="stat-label">Acara Dilayani</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">10K+</span>
            <span class="stat-label">Porsi Terjual</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">100%</span>
            <span class="stat-label">Kepuasan Pelanggan</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">5⭐</span>
            <span class="stat-label">Rating</span>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
      <div class="container">
        <h2>Bergabung dengan Pelanggan Puas Kami</h2>
        <p>Pesan sekarang dan rasakan sendiri kualitas layanan kami</p>
        <router-link to="/hubungi" class="btn btn-primary btn-lg">
          Pesan Sekarang
        </router-link>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Testimoni'
}
</script>

<style scoped>
.page-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
  color: white;
  text-align: center;
  padding: 8rem 0 4rem;
}

.page-header h1 {
  font-family: 'Georgia', serif;
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.gallery-intro {
  max-width: 600px;
  margin: 0 auto;
  color: var(--text-secondary);
}

.testimoni-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.testimoni-card {
  background: white;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: transform 0.3s ease;
}

.testimoni-card:hover {
  transform: translateY(-5px);
}

.testimoni-image {
  height: 250px;
  background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 4rem;
}

.testimoni-caption {
  padding: 1rem;
  text-align: center;
  color: var(--text-secondary);
  font-size: 0.9rem;
}

.follow-text {
  color: var(--text-secondary);
}

.instagram-link {
  color: var(--primary);
  font-weight: 600;
}

.instagram-link:hover {
  text-decoration: underline;
}

.stats-section {
  background: var(--background);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary);
  margin-bottom: 0.5rem;
}

.stat-label {
  color: var(--text-secondary);
}

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

@media (max-width: 992px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .testimoni-grid {
    grid-template-columns: 1fr;
  }

  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
