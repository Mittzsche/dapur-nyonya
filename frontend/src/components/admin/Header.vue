<template>
  <header class="header">
    <div class="header-left">
      <button class="menu-toggle" @click="$emit('toggle-sidebar')">☰</button>
      <h1>{{ title }}</h1>
    </div>
    
    <div class="header-right">
      <slot name="actions"></slot>
      <div class="user-info">
        <span>Selamat datang, {{ adminName }}</span>
      </div>
    </div>
  </header>
</template>

<script>
import authService from '@/services/authService'

export default {
  name: 'Header',
  props: {
    title: {
      type: String,
      default: 'Dashboard'
    }
  },
  computed: {
    adminName() {
      const user = authService.getStoredUser()
      return user?.nama_lengkap || 'Admin'
    }
  }
}
</script>

<style scoped>
.header {
  background: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  position: sticky;
  top: 0;
  z-index: 99;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #333;
  padding: 0;
}

.header h1 {
  font-size: 1.5rem;
  color: #333; /* Hardcoded color to avoid var issues if not imported */
  margin: 0;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.user-info {
  font-size: 0.9rem;
  color: #666;
}

@media (max-width: 992px) {
  .menu-toggle {
    display: block;
  }
  
  .header {
    padding: 1rem;
  }
  
  .header h1 {
    font-size: 1.25rem;
  }
  
  .user-info {
    display: none; /* Hide user name on mobile to save space */
  }
}
</style>
