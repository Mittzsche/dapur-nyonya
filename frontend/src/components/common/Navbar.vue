<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">
    <div class="container navbar-container">
      <!-- Logo -->
      <router-link to="/" class="navbar-brand">
        <div class="logo-box">
          <img v-if="navLogo" :src="navLogo" alt="Logo Dapur Nyonya" class="logo-img">
          <span v-else>🍽️</span>
        </div>
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
        <li><router-link to="/hubungi" class="nav-link" @click="closeMenu">Hubungi Kami</router-link></li>
      </ul>
    </div>

    <!-- Red Line -->
    <div class="navbar-line"></div>
  </nav>
</template>

<script>
import dapurNyonyaLogo from '@/assets/dapur-nyonya-logo.png'

export default {
  name: 'Navbar',
  data() {
    return {
      isScrolled: false,
      isMenuOpen: false,
      navLogo: dapurNyonyaLogo
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
  background: white;
  transition: all 0.3s ease;
}

.navbar-scrolled {
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.navbar-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1.5rem;
}

.navbar-brand {
  display: flex;
  align-items: center;
}

.logo-box {
  width: 50px;
  height: 50px;
  border: 2px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  background: #f9f9f9;
  overflow: hidden;
}

.logo-box:has(.logo-img) {
  border: none;
  background: transparent;
}

.logo-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.navbar-menu {
  display: flex;
  align-items: center;
  gap: 2.5rem;
}

.nav-link {
  font-weight: 500;
  color: var(--text-primary);
  transition: color 0.3s ease;
  position: relative;
  padding: 0.5rem 0;
}

.nav-link:hover {
  color: var(--primary);
}

.nav-link.router-link-active,
.nav-link.router-link-exact-active {
  background: var(--primary);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: var(--radius-md);
}

/* Red Line at bottom of navbar */
.navbar-line {
  height: 4px;
  background: var(--primary);
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
  .navbar-container {
    padding: 0.75rem 1rem;
  }

  .navbar-toggle {
    display: block;
  }

  .navbar-menu {
    position: fixed;
    top: 70px;
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

  .logo-box {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
  }
}

/* Extra Small Screens */
@media (max-width: 480px) {
  .navbar-container {
    padding: 0.5rem 0.75rem;
  }

  .navbar-menu {
    top: 52px;
    padding: 1rem;
  }

  .logo-box {
    width: 36px;
    height: 36px;
    font-size: 1rem;
  }

  .hamburger {
    width: 22px;
  }
}
</style>
