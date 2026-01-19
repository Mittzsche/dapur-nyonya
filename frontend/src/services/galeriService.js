import api from './api'

export default {
    // Public
    getAll() {
        return api.get('/galeri')
    },

    // Admin
    getAdminAll() {
        return api.get('/admin/galeri')
    },

    create(formData) {
        return api.post('/admin/galeri', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    update(id, formData) {
        return api.post(`/admin/galeri/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    delete(id) {
        return api.delete(`/admin/galeri/${id}`)
    }
}
