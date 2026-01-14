import api from './api'

export const penjualanService = {
    // Get sales report
    getReport(params = {}) {
        return api.get('/admin/penjualan', { params })
    },

    // Get dashboard summary
    getSummary() {
        return api.get('/admin/penjualan/summary')
    }
}

export default penjualanService
