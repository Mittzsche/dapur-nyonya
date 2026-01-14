<template>
  <div class="tentang-page">
    <!-- Page Header -->
    <section class="page-header">
      <div class="container">
        <h1>Tentang Kami</h1>
        <p>Mengenal lebih dekat Dapur Nyonya</p>
      </div>
    </section>

    <!-- About Content -->
    <section class="section about-content">
      <div class="container">
        <div class="about-grid">
          <div class="about-image">
            <div class="image-placeholder">
              <span>👩‍🍳</span>
            </div>
          </div>
          <div class="about-text">
            <h2>Dapur Nyonya - Catering Berkualitas Sukabumi</h2>
            <p>
              Dapur Nyonya adalah layanan catering profesional yang berbasis di Sukabumi, 
              Jawa Barat. Didirikan dengan passion untuk menyajikan hidangan berkualitas 
              tinggi dengan cita rasa khas Indonesia yang autentik.
            </p>
            <p>
              Kami melayani berbagai jenis acara mulai dari pesta pernikahan, arisan, 
              meeting kantor, seminar, hingga acara keluarga. Dengan pengalaman bertahun-tahun 
              di industri kuliner, kami berkomitmen untuk memberikan pelayanan terbaik 
              dengan harga yang terjangkau.
            </p>
            <p>
              Setiap hidangan yang kami sajikan diolah dengan bahan-bahan segar dan 
              berkualitas, dimasak oleh tim chef berpengalaman, serta dikemas dengan 
              standar kebersihan yang tinggi.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="section values-section" style="background: white;">
      <div class="container">
        <h2 class="section-title">Nilai-Nilai Kami</h2>
        
        <div class="grid grid-3">
          <div class="value-card">
            <div class="value-icon">💯</div>
            <h3>Kualitas</h3>
            <p>Tidak ada kompromi untuk kualitas rasa dan bahan makanan yang kami gunakan</p>
          </div>
          <div class="value-card">
            <div class="value-icon">🤝</div>
            <h3>Kepercayaan</h3>
            <p>Menjaga kepercayaan pelanggan adalah prioritas utama kami</p>
          </div>
          <div class="value-card">
            <div class="value-icon">❤️</div>
            <h3>Dedikasi</h3>
            <p>Setiap hidangan dimasak dengan cinta dan dedikasi penuh</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Vision Mission -->
    <section class="section vision-mission">
      <div class="container">
        <div class="vm-grid">
          <div class="vm-card">
            <h3>🎯 Visi</h3>
            <p>
              Menjadi layanan catering terpercaya dan pilihan utama masyarakat Sukabumi 
              dan sekitarnya dalam menyediakan hidangan berkualitas untuk setiap momen spesial.
            </p>
          </div>
          <div class="vm-card">
            <h3>🚀 Misi</h3>
            <ul>
              <li>Menyajikan hidangan dengan cita rasa terbaik</li>
              <li>Memberikan pelayanan ramah dan profesional</li>
              <li>Menjaga kebersihan dan kesegaran makanan</li>
              <li>Menawarkan harga kompetitif tanpa mengurangi kualitas</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
      <div class="container">
        <h2>Mari Bekerja Sama</h2>
        <p>Percayakan kebutuhan catering acara Anda kepada kami</p>
        <router-link to="/hubungi" class="btn btn-primary btn-lg">
          Hubungi Kami
        </router-link>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'TentangKami'
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

.about-grid {
  display: grid;
  grid-template-columns: 1fr 1.5fr;
  gap: 3rem;
  align-items: center;
}

.image-placeholder {
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  border-radius: var(--radius-lg);
  height: 350px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 8rem;
}

.about-text h2 {
  font-family: 'Georgia', serif;
  color: var(--primary);
  margin-bottom: 1.5rem;
}

.about-text p {
  margin-bottom: 1rem;
  line-height: 1.8;
  color: var(--text-secondary);
}

.value-card {
  text-align: center;
  padding: 2rem;
  background: var(--background);
  border-radius: var(--radius-lg);
}

.value-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.value-card h3 {
  margin-bottom: 0.5rem;
}

.value-card p {
  color: var(--text-secondary);
  font-size: 0.9rem;
}

.vision-mission {
  background: var(--background);
}

.vm-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.vm-card {
  background: white;
  padding: 2rem;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
}

.vm-card h3 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
  color: var(--text-primary);
}

.vm-card p, .vm-card li {
  color: var(--text-secondary);
  line-height: 1.8;
}

.vm-card ul {
  padding-left: 1.25rem;
  list-style: disc;
}

.vm-card li {
  margin-bottom: 0.5rem;
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

@media (max-width: 768px) {
  .about-grid {
    grid-template-columns: 1fr;
  }

  .vm-grid {
    grid-template-columns: 1fr;
  }
}
</style>
