<template>
  <div class="admin-login">
    <div class="login-container">
      <div class="login-card">
        <h1 class="login-title">🍽️ Dapur Nyonya</h1>
        <p class="login-subtitle">Admin Panel</p>

        <div v-if="error" class="alert alert-error">{{ error }}</div>

        <form @submit.prevent="handleLogin">
          <div class="form-group">
            <label class="form-label">Username</label>
            <input 
              type="text" 
              v-model="username" 
              class="form-control" 
              placeholder="Masukkan username"
              required
            >
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <input 
              type="password" 
              v-model="password" 
              class="form-control" 
              placeholder="Masukkan password"
              required
            >
          </div>

          <button type="submit" class="btn btn-primary btn-block" :disabled="isLoading">
            {{ isLoading ? 'Loading...' : 'Masuk' }}
          </button>
        </form>

        <p class="back-link">
          <router-link to="/">← Kembali ke Website</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import authService from '@/services/authService'

export default {
  name: 'AdminLogin',
  data() {
    return {
      username: '',
      password: '',
      error: '',
      isLoading: false
    }
  },
  methods: {
    async handleLogin() {
      this.error = ''
      this.isLoading = true

      try {
        const response = await authService.login({
          username: this.username,
          password: this.password
        })

        if (response.data.success) {
          authService.saveAuth(response.data.data.token, response.data.data.admin)
          this.$router.push('/admin/dashboard')
        }
      } catch (err) {
        this.error = err.response?.data?.message || 'Login gagal'
      } finally {
        this.isLoading = false
      }
    }
  }
}
</script>

<style scoped>
.admin-login {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
}

.login-card {
  background: white;
  padding: 2.5rem;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  width: 100%;
  max-width: 400px;
}

.login-title {
  text-align: center;
  font-family: 'Georgia', serif;
  color: var(--primary);
  margin-bottom: 0.25rem;
}

.login-subtitle {
  text-align: center;
  color: var(--text-secondary);
  margin-bottom: 2rem;
}

.btn-block {
  width: 100%;
}

.back-link {
  text-align: center;
  margin-top: 1.5rem;
  font-size: 0.9rem;
}

.back-link a {
  color: var(--primary);
}
</style>
