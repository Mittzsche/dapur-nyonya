<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">
    <div class="container navbar-container">
      <!-- Logo -->
      <router-link to="/" class="navbar-brand">
        <span class="logo-text">Dapur Nyonya</span>
      </router-link>

      <!-- Mobile Menu Toggle -->
      <button class="navbar-toggle" @click="isMenuOpen = !isMenuOpen">
        <span class="hamburger" :class="{ 'is-active': isMenuOpen }"></span>
      </button>

      <!-- Navigation Links -->
      <ul class="navbar-menu" :class="{ 'is-open': isMenuOpen }">
        <li><router-link to="/" class="nav-link" @click="closeMenu">Beranda</router-link></li>
        <li><router-link to="/layanan" class="nav-link" @click="closeMenu">Layanan Kami</router-link></li>
        <li><router-link to="/tentang" class="nav-link" @click="closeMenu">Tentang Kami</router-link></li>
        <li><router-link to="/testimoni" class="nav-link" @click="closeMenu">Testimoni</router-link></li>
        <li>
          <router-link to="/hubungi" class="nav-link nav-cta" @click="closeMenu">
            Pesan Sekarang
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  data() {
    return {
      isScrolled: false,
      isMenuOpen: false
    }
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll)
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll)
  },
  methods: {
    handleScroll() {
      this.isScrolled = window.scrollY > 50
    },
    closeMenu() {
      this.isMenuOpen = false
    }
  }
}
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  background: transparent;
  transition: all 0.3s ease;
  padding: 1rem 0;
}

.navbar-scrolled {
  background: rgba(255, 255, 255, 0.98);
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  padding: 0.5rem 0;
}

.navbar-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.navbar-brand {
  font-family: 'Georgia', serif;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--primary);
}

.navbar-scrolled .navbar-brand {
  color: var(--primary-dark);
}

.navbar-menu {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.nav-link {
  font-weight: 500;
  color: var(--text-primary);
  transition: color 0.3s ease;
  position: relative;
}

.nav-link:hover {
  color: var(--primary);
}

.nav-link.router-link-active {
  color: var(--primary);
}

.nav-link.router-link-active::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--primary);
}

.nav-cta {
  background: var(--primary);
  color: white !important;
  padding: 0.5rem 1.25rem;
  border-radius: var(--radius-md);
}

.nav-cta:hover {
  background: var(--primary-dark);
}

.nav-cta.router-link-active::after {
  display: none;
}

/* Mobile Toggle */
.navbar-toggle {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
}

.hamburger {
  display: block;
  width: 25px;
  height: 3px;
  background: var(--text-primary);
  position: relative;
  transition: all 0.3s ease;
}

.hamburger::before,
.hamburger::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 3px;
  background: var(--text-primary);
  transition: all 0.3s ease;
}

.hamburger::before { top: -8px; }
.hamburger::after { bottom: -8px; }

.hamburger.is-active {
  background: transparent;
}

.hamburger.is-active::before {
  transform: rotate(45deg);
  top: 0;
}

.hamburger.is-active::after {
  transform: rotate(-45deg);
  bottom: 0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .navbar-toggle {
    display: block;
  }

  .navbar-menu {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    background: white;
    flex-direction: column;
    padding: 1.5rem;
    gap: 1rem;
    box-shadow: var(--shadow-lg);
    transform: translateY(-100%);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }

  .navbar-menu.is-open {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
  }

  .nav-link {
    display: block;
    padding: 0.5rem 0;
  }

  .nav-cta {
    text-align: center;
    display: block;
  }
}
</style>
