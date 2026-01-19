<template>
  <div id="app">
    <!-- Show Navbar & Footer only for public pages -->
    <template v-if="!isAdminRoute">
      <Navbar />
      <main class="main-content">
        <router-view />
      </main>
      <Footer />
    </template>
    
    <!-- Admin pages without public Navbar/Footer -->
    <template v-else>
      <router-view />
    </template>
  </div>
</template>

<script>
import Navbar from '@/components/common/Navbar.vue'
import Footer from '@/components/common/Footer.vue'

export default {
  name: 'App',
  components: {
    Navbar,
    Footer
  },
  computed: {
    isAdminRoute() {
      return this.$route.path.startsWith('/admin')
    }
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

#app {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #333;
}

.main-content {
  min-height: calc(100vh - 160px);
}
</style>
