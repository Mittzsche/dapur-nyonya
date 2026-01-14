<template>
  <div class="testimoni-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Testimoni</h1>
        <p>Apa kata pelanggan tentang kami</p>
      </div>
    </section>

    <!-- Divider Line -->
    <div class="divider"></div>

    <!-- Testimonials Slider -->
    <section class="section testimoni-section">
      <div class="container">
        <div v-if="loading" class="loading">
          <div class="spinner"></div>
        </div>

        <div v-else-if="testimoniList.length === 0" class="empty-state">
          <p>Belum ada testimoni</p>
        </div>

        <template v-else>
          <!-- Slider Container -->
          <div class="slider-container">
            <button class="slider-btn prev" @click="prevSlide">
              ‹
            </button>
            
            <div class="slider-wrapper">
              <div class="slider-track" :style="{ transform: `translateX(-${currentSlide * slideWidth}%)` }">
                <div class="testimoni-slide" v-for="(item, index) in testimoniList" :key="index">
                  <div class="testimoni-card">
                    <div class="testimoni-image">
                      <img v-if="item.gambar" :src="getImageUrl(item.gambar)" :alt="item.caption">
                      <div v-else class="placeholder">
                        <span>📸</span>
                        <p>Gambar</p>
                      </div>
                    </div>
                    <p class="testimoni-caption">{{ item.caption || 'Testimoni Pelanggan' }}</p>
                  </div>
                </div>
              </div>
            </div>
            
            <button class="slider-btn next" @click="nextSlide">
              ›
            </button>
          </div>

          <!-- Slider Dots -->
          <div class="slider-dots" v-if="totalDots > 1">
            <span 
              v-for="n in totalDots" 
              :key="n" 
              class="dot" 
              :class="{ active: currentSlide === n - 1 }"
              @click="goToSlide(n - 1)"
            ></span>
          </div>
        </template>
      </div>
    </section>
  </div>
</template>

<script>
import testimoniService from '@/services/testimoniService'

export default {
  name: 'Testimoni',
  data() {
    return {
      currentSlide: 0,
      slidesToShow: 3,
      testimoniList: [],
      loading: true
    }
  },
  computed: {
    slideWidth() {
      return 100 / this.slidesToShow
    },
    maxSlide() {
      return Math.max(0, this.testimoniList.length - this.slidesToShow)
    },
    totalDots() {
      return this.maxSlide + 1
    }
  },
  async mounted() {
    await this.loadTestimoni()
  },
  methods: {
    async loadTestimoni() {
      try {
        const response = await testimoniService.getAll()
        this.testimoniList = response.data.data
      } catch (error) {
        console.error('Error loading testimoni:', error)
      } finally {
        this.loading = false
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      return `http://localhost:8000/storage/${path}`
    },
    nextSlide() {
      if (this.currentSlide < this.maxSlide) {
        this.currentSlide++
      } else {
        this.currentSlide = 0 // Loop back to start
      }
    },
    prevSlide() {
      if (this.currentSlide > 0) {
        this.currentSlide--
      } else {
        this.currentSlide = this.maxSlide // Loop to end
      }
    },
    goToSlide(index) {
      this.currentSlide = index
    }
  }
}
</script>

<style scoped>
.page-header {
  background: white;
  text-align: center;
  padding: 8rem 0 2rem;
}

.page-header h1 {
  font-family: var(--font-heading);
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.page-header h1::after {
  content: '';
  display: block;
  width: 60px;
  height: 3px;
  background: var(--primary);
  margin: 0.5rem auto 0;
}

.page-header p {
  color: var(--text-secondary);
}

.divider {
  height: 4px;
  background: var(--primary);
}

.testimoni-section {
  padding: 4rem 0;
  background: #f9f9f9;
  min-height: 80vh;
  display: flex;
  align-items: center;
}

.empty-state {
  text-align: center;
  padding: 4rem;
  color: var(--text-secondary);
}

.slider-container {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.slider-btn {
  width: 50px;
  height: 50px;
  border: 2px solid var(--border);
  background: white;
  font-size: 2rem;
  cursor: pointer;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  flex-shrink: 0;
}

.slider-btn:hover:not(:disabled) {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
}

.slider-btn:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.slider-wrapper {
  flex: 1;
  overflow: hidden;
}

.slider-track {
  display: flex;
  transition: transform 0.5s ease;
}

.testimoni-slide {
  flex: 0 0 33.333%;
  padding: 0 0.75rem;
  box-sizing: border-box;
}

.testimoni-card {
  border: 2px solid var(--border);
  background: white;
  overflow: hidden;
}

.testimoni-image {
  aspect-ratio: 3/4;
  background: #f0f0f0;
  overflow: hidden;
}

.testimoni-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.testimoni-image .placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px solid var(--border);
}

.testimoni-image .placeholder span {
  font-size: 4rem;
  margin-bottom: 0.5rem;
}

.testimoni-image .placeholder p {
  color: var(--text-secondary);
}

.testimoni-caption {
  padding: 1rem;
  text-align: center;
  color: var(--text-secondary);
  font-size: 0.9rem;
  border-top: 1px solid var(--border);
}

.slider-dots {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 2rem;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: var(--border);
  cursor: pointer;
  transition: background 0.3s ease;
}

.dot.active {
  background: var(--primary);
}

.dot:hover {
  background: var(--primary-light);
}

@media (max-width: 992px) {
  .testimoni-slide {
    flex: 0 0 50%;
  }
}

@media (max-width: 768px) {
  .testimoni-slide {
    flex: 0 0 100%;
  }

  .page-header {
    padding: 6rem 0 2rem;
  }

  .page-header h1 {
    font-size: 2rem;
  }

  .slider-btn {
    width: 40px;
    height: 40px;
    font-size: 1.5rem;
  }
}
</style>
