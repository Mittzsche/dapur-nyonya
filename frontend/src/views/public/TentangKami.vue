<template>
  <div class="tentang-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container header-grid">
        <div class="header-text">
          <h1>{{ content.title || 'Dapur Nyonya' }}</h1>
          <p class="header-subtitle">
            {{ content.subtitle || 'Dapur Nyonya Catering didirikan pada tahun 1984 dengan tujuan utama memberikan pelayanan terbaik serta menjadi mitra terpercaya dalam penyelenggaraan berbagai acara dan pesta.' }}
          </p>
        </div>
        <div class="header-image">
          <div v-if="content.owner_image" class="owner-image-real">
            <img :src="getImageUrl(content.owner_image)" alt="Owner Dapur Nyonya">
          </div>
          <div v-else class="owner-image">
            <span>👩‍🍳</span>
            <p>Foto Owner</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Divider Line -->
    <div class="divider"></div>

    <!-- Latar Belakang Section -->
    <section class="section latar-belakang">
      <div class="container">
        <div class="latar-box">
          <h2>Latar Belakang</h2>
          
          <div v-if="content.latar_belakang" v-html="formattedLatarBelakang"></div>
          <div v-else>
            <p>
              Sebagai penyedia layanan jasa boga profesional, Dapur Nyonya Catering hadir dengan komitmen untuk 
              memberikan pelayanan terbaik dan pengalaman kuliner yang berkesan di setiap acara. Sejak awal berdirinya, 
              kami berfokus untuk menghadirkan sajian lezat, tampilan yang elegan, serta pelayanan yang ramah dan berkelas 
              bagi setiap pelanggan.
            </p>

            <p>
              Didukung oleh tim ahli dan tenaga profesional di bidang kuliner, Dapur Nyonya Catering menggabungkan cita rasa 
              tradisional dengan sentuhan modern. Kami memahami bahwa setiap acara memiliki karakter dan kebutuhan yang 
              berbeda, sehingga setiap hidangan disiapkan dengan menyesuaikan tema, konsep, serta selera pelanggan baik 
              untuk pesta pernikahan, acara perusahaan, gathering keluarga, maupun perjamuan resmi.
            </p>

            <p>
              Kami menawarkan beragam pilihan menu Nusantara dan internasional yang dikreasikan dengan perpaduan bahan 
              berkualitas tinggi dan bumbu pilihan khas Dapur Nyonya. Setiap sajian diolah dengan teliti untuk menghasilkan 
              rasa yang autentik dan tampilan yang menarik, sehingga memberikan kesan istimewa bagi para tamu yang hadir.
            </p>

            <p>
              Prinsip utama kami adalah "segar, higienis, dan berkualitas". Seluruh proses mulai dari pemilihan bahan baku, 
              pengolahan makanan, hingga penyajian dilakukan dengan standar kebersihan yang tinggi dan pengawasan ketat 
              untuk menjamin kualitas terbaik di setiap hidangan.
            </p>

            <p>
              Dengan cita rasa khas dan tampilan yang menawan, Dapur Nyonya Catering selalu berupaya menghadirkan 
              inovasi dalam setiap penyajian. Kami ingin memastikan bahwa setiap acara yang Anda percayakan kepada kami 
              bukan sekadar pesta, melainkan menjadi momen berharga yang dipenuhi kelezatan dan kebahagiaan.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import kontenService from '@/services/kontenService'

export default {
  name: 'TentangKami',
  data() {
    return {
      content: {
        title: '',
        subtitle: '',
        owner_image: '',
        latar_belakang: ''
      }
    }
  },
  computed: {
    formattedLatarBelakang() {
      if (!this.content.latar_belakang) return ''
      // Convert line breaks to paragraphs
      const paragraphs = this.content.latar_belakang.split('\n\n').filter(p => p.trim())
      return paragraphs.map(p => `<p>${p}</p>`).join('')
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

        if (konten.tentang_title) this.content.title = konten.tentang_title.value
        if (konten.tentang_subtitle) this.content.subtitle = konten.tentang_subtitle.value
        if (konten.tentang_owner_image) this.content.owner_image = konten.tentang_owner_image.value
        if (konten.tentang_latar_belakang) this.content.latar_belakang = konten.tentang_latar_belakang.value
      } catch (error) {
        console.error('Error loading content:', error)
      }
    },
    getImageUrl(path) {
      if (!path) return ''
      const apiUrl = process.env.VUE_APP_API_URL || 'http://localhost:8000/api'
      const baseUrl = apiUrl.replace(/\/api\/?$/, '')
      return `${baseUrl}/storage/${path}`
    }
  }
}
</script>

<style scoped>
/* Page Header - Red Gradient */
.page-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  padding: 8rem 0 3rem;
  color: white;
}

.header-grid {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 3rem;
  align-items: center;
}

.header-text h1 {
  font-family: var(--font-heading);
  font-size: 3rem;
  margin-bottom: 1rem;
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.header-subtitle {
  color: rgba(255,255,255,0.9);
  max-width: 600px;
  line-height: 1.7;
  font-size: 1.05rem;
}

.owner-image {
  width: 200px;
  height: 250px;
  border: 2px solid var(--border);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #f9f9f9;
}

.owner-image span {
  font-size: 4rem;
  margin-bottom: 0.5rem;
}

.owner-image p {
  color: var(--text-secondary);
  font-size: 0.9rem;
}

.owner-image-real {
  width: 200px;
  height: 250px;
  border: 2px solid var(--border);
  overflow: hidden;
}

.owner-image-real img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.divider {
  height: 4px;
  background: var(--primary);
}

.latar-belakang {
  padding: 3rem 0;
  background: #f5f5f5;
  min-height: 60vh;
}

.latar-box {
  background: white;
  border: 2px solid var(--border);
  padding: 2.5rem;
}

.latar-box h2 {
  font-family: var(--font-heading);
  font-size: 1.75rem;
  margin-bottom: 1.5rem;
  color: var(--text-primary);
  border-bottom: 2px solid var(--text-primary);
  padding-bottom: 0.5rem;
  display: inline-block;
}

.latar-box p,
.latar-box :deep(p) {
  color: var(--text-secondary);
  line-height: 1.8;
  margin-bottom: 1.5rem;
  text-align: justify;
}

.latar-box p:last-child,
.latar-box :deep(p:last-child) {
  margin-bottom: 0;
}

@media (max-width: 768px) {
  .page-header {
    padding: 6rem 0 2rem;
  }

  .header-grid {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .header-text h1 {
    font-size: 2rem;
  }

  .header-subtitle {
    text-align: center;
  }

  .header-image {
    display: flex;
    justify-content: center;
  }

  .latar-box {
    padding: 1.5rem;
  }

  .latar-box h2 {
    font-size: 1.5rem;
  }
}
</style>
