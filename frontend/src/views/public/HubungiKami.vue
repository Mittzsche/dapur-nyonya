<template>
  <div class="hubungi-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Hubungi Kami</h1>
        <p class="header-subtitle">
          Dapur Nyonya dengan senang hati siap melayani kebutuhan catering untuk berbagai acara Anda. 
          Hubungi kami untuk melakukan pemesanan dan dapatkan konsultasi langsung dengan tim marketing kami.
        </p>
      </div>
    </section>

    <!-- Divider Line -->
    <div class="divider"></div>

    <section class="section hubungi-section">
      <div class="container">
        <div class="contact-grid">
          <!-- Order Form -->
          <div class="form-section">
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
                <label class="form-label">Nama Lengkap*</label>
                <input 
                  type="text" 
                  v-model="form.nama_pelanggan" 
                  class="form-control"
                  :class="{ 'error': errors.nama_pelanggan }"
                >
                <span v-if="errors.nama_pelanggan" class="form-error">{{ errors.nama_pelanggan }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Nomor HP*</label>
                <input 
                  type="tel" 
                  v-model="form.no_hp" 
                  class="form-control"
                  :class="{ 'error': errors.no_hp }"
                >
                <span v-if="errors.no_hp" class="form-error">{{ errors.no_hp }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Email*</label>
                <input 
                  type="email" 
                  v-model="form.email" 
                  class="form-control"
                  :class="{ 'error': errors.email }"
                >
                <span v-if="errors.email" class="form-error">{{ errors.email }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Lokasi Pengiriman*</label>
                <textarea 
                  v-model="form.alamat" 
                  class="form-control"
                  :class="{ 'error': errors.alamat }"
                  rows="2"
                ></textarea>
                <span v-if="errors.alamat" class="form-error">{{ errors.alamat }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Jenis Layanan*</label>
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
                    {{ layanan.nama_paket }}
                  </option>
                </select>
                <span v-if="errors.id_layanan" class="form-error">{{ errors.id_layanan }}</span>
              </div>

              <div class="form-group">
                <label class="form-label">Tanggal Pesanan*</label>
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
                <label class="form-label">Catatan</label>
                <textarea 
                  v-model="form.catatan" 
                  class="form-control"
                  rows="3"
                ></textarea>
              </div>

              <button type="submit" class="btn btn-primary btn-block" :disabled="isSubmitting">
                {{ isSubmitting ? 'Mengirim...' : 'Kirim' }}
              </button>
            </form>
          </div>

          <!-- Contact Info -->
          <div class="info-section">
            <!-- Contact Details -->
            <div class="info-card">
              <div class="info-item">
                <strong>No. Telp</strong>
                <p>0812-3456-7890</p>
              </div>
              <div class="info-item">
                <strong>Email</strong>
                <p>info@dapurnyonya.com</p>
              </div>
              <div class="info-item">
                <strong>Alamat</strong>
                <p>Sukabumi, Jawa Barat</p>
              </div>
            </div>

            <!-- Jam Kerja -->
            <div class="info-card">
              <h4>Jam Kerja</h4>
              <div class="jam-kerja">
                <p>Senin: 08:00 - 16:00</p>
                <p>Selasa: 08:00 - 16:00</p>
                <p>Rabu: 08:00 - 16:00</p>
                <p>Kamis: 08:00 - 16:00</p>
                <p>Jumat: 08:00 - 16:00</p>
                <p>Sabtu: 08:00 - 14:00</p>
                <p>Minggu: Libur</p>
              </div>
            </div>

            <!-- Ketentuan -->
            <div class="ketentuan-card" @click="toggleKetentuan('pembayaran')">
              <span>Ketentuan Pembayaran</span>
              <span class="arrow">{{ openKetentuan === 'pembayaran' ? '▲' : '▼' }}</span>
            </div>
            <div v-if="openKetentuan === 'pembayaran'" class="ketentuan-content">
              <p>DP minimal 50% dari total pesanan. Pelunasan dilakukan H-1 sebelum pengiriman.</p>
            </div>

            <div class="ketentuan-card" @click="toggleKetentuan('pengiriman')">
              <span>Ketentuan Pengiriman</span>
              <span class="arrow">{{ openKetentuan === 'pengiriman' ? '▲' : '▼' }}</span>
            </div>
            <div v-if="openKetentuan === 'pengiriman'" class="ketentuan-content">
              <p>Gratis pengiriman untuk area Sukabumi. Area luar kota dikenakan biaya tambahan.</p>
            </div>

            <div class="ketentuan-card" @click="toggleKetentuan('pembatalan')">
              <span>Ketentuan Pembatalan</span>
              <span class="arrow">{{ openKetentuan === 'pembatalan' ? '▲' : '▼' }}</span>
            </div>
            <div v-if="openKetentuan === 'pembatalan'" class="ketentuan-content">
              <p>Pembatalan H-3 sebelum acara, DP dikembalikan 50%. H-1 tidak dapat dikembalikan.</p>
            </div>

            <!-- WhatsApp Link -->
            <div class="whatsapp-link">
              <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-whatsapp">
                💬 Chat via WhatsApp
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
        email: '',
        id_layanan: '',
        tanggal_acara: '',
        alamat: '',
        catatan: ''
      },
      errors: {},
      isSubmitting: false,
      successMessage: '',
      errorMessage: '',
      openKetentuan: null
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
    toggleKetentuan(type) {
      this.openKetentuan = this.openKetentuan === type ? null : type
    },
    validateForm() {
      this.errors = {}
      
      if (!this.form.nama_pelanggan.trim()) {
        this.errors.nama_pelanggan = 'Nama wajib diisi'
      }
      if (!this.form.no_hp.trim()) {
        this.errors.no_hp = 'Nomor HP wajib diisi'
      }
      if (!this.form.email.trim()) {
        this.errors.email = 'Email wajib diisi'
      }
      if (!this.form.id_layanan) {
        this.errors.id_layanan = 'Pilih jenis layanan'
      }
      if (!this.form.tanggal_acara) {
        this.errors.tanggal_acara = 'Tanggal wajib diisi'
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
        this.successMessage = 'Pemesanan berhasil dikirim! Kami akan segera menghubungi Anda.'
        
        // Reset form
        this.form = {
          nama_pelanggan: '',
          no_hp: '',
          email: '',
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
/* Page Header - Red Gradient */
.page-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  text-align: center;
  padding: 8rem 0 3rem;
  color: white;
}

.page-header h1 {
  font-family: var(--font-heading);
  font-size: 3rem;
  margin-bottom: 1rem;
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.header-subtitle {
  color: rgba(255,255,255,0.9);
  max-width: 700px;
  margin: 0 auto;
  line-height: 1.7;
  font-size: 1.1rem;
}

.divider {
  height: 6px;
  background: linear-gradient(90deg, var(--primary-dark), var(--primary), var(--primary-light), var(--primary), var(--primary-dark));
}

.hubungi-section {
  padding: 4rem 0;
  background: linear-gradient(180deg, #FFF5F5 0%, #f8f8f8 100%);
}

.contact-grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 3rem;
  align-items: start;
}

/* Modern Form Section */
.form-section {
  background: white;
  padding: 2.5rem;
  border-radius: var(--radius-lg);
  box-shadow: 0 10px 40px rgba(196, 30, 58, 0.1);
  border: none;
}

.form-group {
  margin-bottom: 1.25rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
  color: var(--text-primary);
  font-weight: 600;
}

.form-control {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid #e8e8e8;
  border-radius: var(--radius-md);
  background: #fafafa;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  outline: none;
  border-color: var(--primary);
  background: white;
  box-shadow: 0 0 0 4px rgba(196, 30, 58, 0.1);
}

.form-control.error {
  border-color: var(--error);
}

select.form-control {
  cursor: pointer;
}

.btn-block {
  width: 100%;
  margin-top: 1.5rem;
  padding: 1rem;
  font-size: 1.1rem;
  border-radius: 50px;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  border: none;
  box-shadow: 0 6px 20px rgba(196, 30, 58, 0.35);
  transition: all 0.3s ease;
}

.btn-block:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(196, 30, 58, 0.4);
}

/* Info Section - Modern Cards */
.info-section {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.info-card {
  background: white;
  padding: 1.75rem;
  border-radius: var(--radius-lg);
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: none;
  transition: all 0.3s ease;
}

.info-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 30px rgba(196, 30, 58, 0.12);
}

.info-card h4 {
  font-size: 1.1rem;
  margin-bottom: 1rem;
  color: var(--primary);
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.info-card h4::before {
  content: '';
  width: 4px;
  height: 20px;
  background: var(--primary);
  border-radius: 2px;
}

.info-item {
  margin-bottom: 1rem;
  padding-left: 1rem;
  border-left: 2px solid #f0f0f0;
}

.info-item strong {
  display: block;
  font-size: 0.85rem;
  color: var(--primary);
  margin-bottom: 0.25rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-item p {
  color: var(--text-primary);
  margin: 0;
  font-size: 1rem;
  font-weight: 500;
}

.jam-kerja {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.5rem;
}

.jam-kerja p {
  color: var(--text-secondary);
  font-size: 0.9rem;
  margin: 0;
  padding: 0.5rem 0.75rem;
  background: #f8f8f8;
  border-radius: var(--radius-sm);
}

/* Ketentuan - Collapsible */
.ketentuan-card {
  background: white;
  padding: 1.25rem 1.5rem;
  border-radius: var(--radius-md);
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  border: none;
}

.ketentuan-card:hover {
  background: #FFF5F5;
  box-shadow: 0 4px 15px rgba(196, 30, 58, 0.1);
}

.ketentuan-card span:first-child {
  font-size: 0.95rem;
  color: var(--text-primary);
  font-weight: 500;
}

.arrow {
  font-size: 0.8rem;
  color: var(--primary);
  transition: transform 0.2s;
}

.ketentuan-content {
  background: white;
  padding: 1.25rem 1.5rem;
  border-radius: 0 0 var(--radius-md) var(--radius-md);
  margin-top: -0.5rem;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.ketentuan-content p {
  font-size: 0.9rem;
  color: var(--text-secondary);
  margin: 0;
  line-height: 1.6;
}

/* WhatsApp Button */
.whatsapp-link {
  margin-top: 1.5rem;
}

.btn-whatsapp {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: white;
  padding: 1rem 1.5rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1rem;
  box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
  transition: all 0.3s ease;
}

.btn-whatsapp:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(37, 211, 102, 0.4);
}

/* Alerts */
.alert {
  padding: 1rem 1.25rem;
  border-radius: var(--radius-md);
  margin-bottom: 1.5rem;
}

.alert-success {
  background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
  color: #155724;
  border-left: 4px solid #28a745;
}

.alert-error {
  background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
  color: #721c24;
  border-left: 4px solid #dc3545;
}

.form-error {
  color: var(--error);
  font-size: 0.8rem;
  margin-top: 0.25rem;
  display: block;
}

/* Responsive */
@media (max-width: 768px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }

  .page-header {
    padding: 6rem 0 2rem;
  }

  .page-header h1 {
    font-size: 2.25rem;
  }

  .form-section {
    padding: 1.5rem;
  }

  .jam-kerja {
    grid-template-columns: 1fr;
  }
}
</style>
