import api from './api'

export default {
    // Public
    getAll() {
        return api.get('/testimoni')
    },

    // Admin
    getAdminAll() {
        return api.get('/admin/testimoni')
    },

    create(formData) {
        return api.post('/admin/testimoni', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    update(id, formData) {
        return api.post(`/admin/testimoni/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },

    delete(id) {
        return api.delete(`/admin/testimoni/${id}`)
    }
}
