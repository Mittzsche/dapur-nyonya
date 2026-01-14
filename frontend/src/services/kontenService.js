import api from './api'

export default {
  // Public
  getAll() {
    return api.get('/konten')
  },
  
  getByKey(key) {
    return api.get(`/konten/${key}`)
  },

  // Admin
  update(key, data) {
    return api.put(`/admin/konten/${key}`, data)
  },

  bulkUpdate(contents) {
    return api.post('/admin/konten/bulk', { contents })
  },

  // Upload image for konten
  uploadImage(key, file) {
    const formData = new FormData()
    formData.append('image', file)
    return api.put(`/admin/konten/${key}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
  }
}
