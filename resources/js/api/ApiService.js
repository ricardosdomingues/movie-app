import axios from 'axios'

const ApiService = {

  query (resource, params) {
    return axios.get(resource, { params })
  },

  get (resource, slug = '', params = {}) {
    return axios.get(slug !== '' ? `${resource}/${slug}` : resource, { params })
  },

  post (resource, params, options = {}) {
    return axios.post(`${resource}`, params, options)
  },

  patch (resource, params, options = {}) {
    return axios.patch(`${resource}`, params, options)
  },

  put (resource, params) {
    return axios.put(`${resource}`, params)
  },

  delete (resource) {
    return axios.delete(resource)
  }
}

export default ApiService
