<template>
  <div class="hubungi-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Pesan catering untuk acara Anda</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="contact-grid">
          <!-- Order Form -->
          <div class="form-section">
            <h2>Form Pemesanan</h2>
            <p class="form-intro">Isi form berikut dan kami akan segera menghubungi Anda</p>

            <!-- Success Message -->
            <div v-if="successMessage" class="alert alert-success">
              {{ successMessage }}
            </div>

            <!-- Error Message -->
            <div v-if="errorMessage" class="alert alert-error">
              {{ errorMessage }}
            </div>

            <form @submit.prevent="submitOrder" class="order-form">
              <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input 
                  type="text" 
                  v-model="form.nama_pelanggan" 
                  class="form-control"
                  :class="{ 'error': errors.nama_pelanggan }"
                  placeholder="Masukkan nama lengkap"
                >
                <span v-if="errors.nama_pelanggan" class="form-error">{{ errors.nama_pelanggan }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Nomor HP/WhatsApp *</label>
                <input 
                  type="tel" 
                  v-model="form.no_hp" 
                  class="form-control"
                  :class="{ 'error': errors.no_hp }"
                  placeholder="Contoh: 081234567890"
                >
                <span v-if="errors.no_hp" class="form-error">{{ errors.no_hp }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Pilih Paket Layanan *</label>
                <select 
                  v-model="form.id_layanan" 
                  class="form-control"
                  :class="{ 'error': errors.id_layanan }"
                >
                  <option value="">-- Pilih Paket --</option>
                  <option 
                    v-for="layanan in layananList" 
                    :key="layanan.id_layanan" 
                    :value="layanan.id_layanan"
                  >
                    {{ layanan.nama_paket }} - Rp {{ formatPrice(layanan.harga) }}
                  </option>
                </select>
                <span v-if="errors.id_layanan" class="form-error">{{ errors.id_layanan }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Tanggal Acara *</label>
                <input 
                  type="date" 
                  v-model="form.tanggal_acara" 
                  class="form-control"
                  :class="{ 'error': errors.tanggal_acara }"
                  :min="minDate"
                >
                <span v-if="errors.tanggal_acara" class="form-error">{{ errors.tanggal_acara }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Alamat Pengiriman *</label>
                <textarea 
                  v-model="form.alamat" 
                  class="form-control"
                  :class="{ 'error': errors.alamat }"
                  placeholder="Masukkan alamat lengkap pengiriman"
                  rows="3"
                ></textarea>
                <span v-if="errors.alamat" class="form-error">{{ errors.alamat }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <textarea 
                  v-model="form.catatan" 
                  class="form-control"
                  placeholder="Catatan khusus (contoh: jumlah porsi, alergi makanan, dll)"
                  rows="3"
                ></textarea>
              </div>

              <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="isSubmitting">
                {{ isSubmitting ? 'Mengirim...' : 'Kirim Pemesanan' }}
              </button>
            </form>
          </div>

          <!-- Contact Info -->
          <div class="info-section">
            <div class="info-card">
              <h3>📍 Lokasi</h3>
              <p>Sukabumi, Jawa Barat</p>
            </div>

            <div class="info-card">
              <h3>📞 Telepon</h3>
              <p>0812-3456-7890</p>
            </div>

            <div class="info-card">
              <h3>✉️ Email</h3>
              <p>info@dapurnyonya.com</p>
            </div>

            <div class="info-card">
              <h3>⏰ Jam Operasional</h3>
              <p>Senin - Sabtu: 08.00 - 17.00</p>
              <p>Minggu: Tutup</p>
            </div>

            <div class="whatsapp-card">
              <h3>Chat via WhatsApp</h3>
              <p>Butuh respon cepat? Hubungi langsung via WhatsApp</p>
              <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success">
                💬 Chat WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import layananService from '@/services/layananService'
import pemesananService from '@/services/pemesananService'

export default {
  name: 'HubungiKami',
  data() {
    return {
      layananList: [],
      form: {
        nama_pelanggan: '',
        no_hp: '',
        id_layanan: '',
        tanggal_acara: '',
        alamat: '',
        catatan: ''
      },
      errors: {},
      isSubmitting: false,
      successMessage: '',
      errorMessage: ''
    }
  },
  computed: {
    minDate() {
      return new Date().toISOString().split('T')[0]
    }
  },
  async mounted() {
    await this.fetchLayanan()
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
    formatPrice(price) {
      return parseFloat(price).toLocaleString('id-ID')
    },
    validateForm() {
      this.errors = {}
      
      if (!this.form.nama_pelanggan.trim()) {
        this.errors.nama_pelanggan = 'Nama wajib diisi'
      }
      if (!this.form.no_hp.trim()) {
        this.errors.no_hp = 'Nomor HP wajib diisi'
      }
      if (!this.form.id_layanan) {
        this.errors.id_layanan = 'Pilih paket layanan'
      }
      if (!this.form.tanggal_acara) {
        this.errors.tanggal_acara = 'Tanggal acara wajib diisi'
      }
      if (!this.form.alamat.trim()) {
        this.errors.alamat = 'Alamat wajib diisi'
      }

      return Object.keys(this.errors).length === 0
    },
    async submitOrder() {
      this.successMessage = ''
      this.errorMessage = ''

      if (!this.validateForm()) {
        return
      }

      this.isSubmitting = true

      try {
        await pemesananService.create(this.form)
        this.successMessage = 'Pemesanan berhasil dikirim! Kami akan segera menghubungi Anda via WhatsApp.'
        
        // Reset form
        this.form = {
          nama_pelanggan: '',
          no_hp: '',
          id_layanan: '',
          tanggal_acara: '',
          alamat: '',
          catatan: ''
        }
      } catch (error) {
        if (error.response?.data?.message) {
          this.errorMessage = error.response.data.message
        } else {
          this.errorMessage = 'Terjadi kesalahan. Silakan coba lagi.'
        }
      } finally {
        this.isSubmitting = false
      }
    }
  }
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

.contact-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 3rem;
}

.form-section h2 {
  font-family: 'Georgia', serif;
  color: var(--text-primary);
  margin-bottom: 0.5rem;
}

.form-intro {
  color: var(--text-secondary);
  margin-bottom: 2rem;
}

.btn-block {
  width: 100%;
}

.btn-success {
  background: #25D366;
  color: white;
}

.btn-success:hover {
  background: #1da851;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.info-card {
  background: white;
  padding: 1.5rem;
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-sm);
}

.info-card h3 {
  font-size: 1rem;
  margin-bottom: 0.5rem;
  color: var(--text-primary);
}

.info-card p {
  color: var(--text-secondary);
  margin: 0;
}

.whatsapp-card {
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: white;
  padding: 1.5rem;
  border-radius: var(--radius-md);
  text-align: center;
}

.whatsapp-card h3 {
  margin-bottom: 0.5rem;
}

.whatsapp-card p {
  margin-bottom: 1rem;
  opacity: 0.9;
}

.whatsapp-card .btn {
  background: white;
  color: #25D366;
}

.whatsapp-card .btn:hover {
  background: #f0f0f0;
}

@media (max-width: 768px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }
}
</style>
