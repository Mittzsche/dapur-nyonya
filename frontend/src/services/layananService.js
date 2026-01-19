import api from './api'

export const layananService = {
    // Get all layanan (public)
    getAll() {
        return api.get('/layanan')
    },

    // Get single layanan by ID
    getById(id) {
        return api.get(`/layanan/${id}`)
    },

    // Admin: Create layanan
    create(formData) {
        return api.post('/admin/layanan', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
    },

    // Admin: Update layanan
    update(id, formData) {
        formData.append('_method', 'PUT')
        return api.post(`/admin/layanan/${id}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
    },

    // Admin: Delete layanan
    delete(id) {
        return api.delete(`/admin/layanan/${id}`)
    }
}

export default layananService
