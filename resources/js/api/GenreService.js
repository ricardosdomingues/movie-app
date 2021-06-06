import ApiService from './ApiService'

const GenreService = {
  query (params = {}) {
    return new Promise((resolve, reject) => {
      ApiService.query('genres', params)
        .then(response => resolve(response.data.data))
        .catch(errors => reject(errors))
    })
  }
}

export default GenreService
