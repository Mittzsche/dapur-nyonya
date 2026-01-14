import api from './api'

export const authService = {
    // Login admin
    login(credentials) {
        return api.post('/auth/login', credentials)
    },

    // Logout admin
    logout() {
        return api.post('/auth/logout')
    },

    // Get current admin info
    getMe() {
        return api.get('/auth/me')
    },

    // Save auth data to localStorage
    saveAuth(token, user) {
        localStorage.setItem('admin_token', token)
        localStorage.setItem('admin_user', JSON.stringify(user))
    },

    // Clear auth data
    clearAuth() {
        localStorage.removeItem('admin_token')
        localStorage.removeItem('admin_user')
    },

    // Check if logged in
    isLoggedIn() {
        return !!localStorage.getItem('admin_token')
    },

    // Get stored user
    getStoredUser() {
        const user = localStorage.getItem('admin_user')
        return user ? JSON.parse(user) : null
    }
}

export default authService
