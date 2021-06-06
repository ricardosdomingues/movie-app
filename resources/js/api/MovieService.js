import ApiService from './ApiService'

export const MovieService = {

  query (params = {}) {
    return new Promise((resolve, reject) => {
      ApiService.query('movies', params)
        .then(response => resolve(response.data.data))
        .catch(errors => reject(errors))
    })
  },

  get (slug, params = {}) {
    return new Promise((resolve, reject) => {
      ApiService.get('movies', slug, params)
        .then(response => resolve(response.data.data))
        .catch(errors => reject(errors))
    })
  },

  store (params) {
    return new Promise((resolve, reject) => {
      ApiService.post(`/movies`, params)
        .then(response => resolve(response.data.data))
        .catch(errors => reject(errors))
    })
  },

  update (resource, params) {
    return new Promise((resolve, reject) => {
      ApiService.put(`movies/${resource}`, params)
        .then(response => resolve(response.data.data))
        .catch(errors => reject(errors))
    })
  },

  destroy (resource) {
    return new Promise((resolve, reject) => {
      ApiService.delete(`movies/${resource}`)
        .then(() => resolve())
        .catch(errors => reject(errors))
    })
  }
}
