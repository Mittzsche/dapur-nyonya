import api from './api'

export const pemesananService = {
    // Public: Create pemesanan
    create(data) {
        return api.post('/pemesanan', data)
    },

    // Admin: Get all pemesanan
    getAll(params = {}) {
        return api.get('/admin/pemesanan', { params })
    },

    // Admin: Get single pemesanan
    getById(id) {
        return api.get(`/admin/pemesanan/${id}`)
    },

    // Admin: Update pemesanan
    update(id, data) {
        return api.put(`/admin/pemesanan/${id}`, data)
    },

    // Admin: Update status
    updateStatus(id, status) {
        return api.patch(`/admin/pemesanan/${id}/status`, { status })
    },

    // Admin: Delete pemesanan
    delete(id) {
        return api.delete(`/admin/pemesanan/${id}`)
    }
}

export default pemesananService
