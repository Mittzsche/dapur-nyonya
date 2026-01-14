<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <!-- About Section -->
        <div class="footer-section">
          <h3 class="footer-title">Dapur Nyonya</h3>
          <p class="footer-text">
            Layanan catering profesional untuk berbagai acara Anda. 
            Menyajikan makanan berkualitas dengan cita rasa khas Indonesia.
          </p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
          <h4 class="footer-subtitle">Menu</h4>
          <ul class="footer-links">
            <li><router-link to="/">Beranda</router-link></li>
            <li><router-link to="/layanan">Layanan Kami</router-link></li>
            <li><router-link to="/tentang">Tentang Kami</router-link></li>
            <li><router-link to="/testimoni">Testimoni</router-link></li>
            <li><router-link to="/hubungi">Hubungi Kami</router-link></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-section">
          <h4 class="footer-subtitle">Kontak</h4>
          <ul class="footer-contact">
            <li>📍 Sukabumi, Jawa Barat</li>
            <li>📞 0812-3456-7890</li>
            <li>✉️ info@dapurnyonya.com</li>
          </ul>
        </div>

        <!-- Social Media -->
        <div class="footer-section">
          <h4 class="footer-subtitle">Ikuti Kami</h4>
          <div class="social-links">
            <a href="#" class="social-link">📘 Facebook</a>
            <a href="#" class="social-link">📸 Instagram</a>
            <a href="#" class="social-link">💬 WhatsApp</a>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="footer-bottom">
        <p>&copy; {{ currentYear }} Dapur Nyonya. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
  computed: {
    currentYear() {
      return new Date().getFullYear()
    }
  }
}
</script>

<style scoped>
.footer {
  background: linear-gradient(135deg, #2D2D2D 0%, #1a1a1a 100%);
  color: #ccc;
  padding: 3rem 0 1.5rem;
  margin-top: auto;
}

.footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 2rem;
}

.footer-title {
  font-family: 'Georgia', serif;
  font-size: 1.5rem;
  color: var(--primary);
  margin-bottom: 1rem;
}

.footer-subtitle {
  font-size: 1.1rem;
  color: #fff;
  margin-bottom: 1rem;
}

.footer-text {
  line-height: 1.7;
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.footer-links a {
  color: #ccc;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: var(--primary);
}

.footer-contact {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.social-links {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.social-link {
  color: #ccc;
  transition: color 0.3s ease;
}

.social-link:hover {
  color: var(--primary);
}

.footer-bottom {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #444;
  text-align: center;
  font-size: 0.875rem;
}

@media (max-width: 992px) {
  .footer-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 576px) {
  .footer-grid {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .footer-links,
  .footer-contact,
  .social-links {
    align-items: center;
  }
}
</style>
