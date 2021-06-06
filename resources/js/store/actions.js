import { MovieService } from '../api/MovieService'
import GenreService from '../api/GenreService'

const loadMovies = ({ commit }) => {
  MovieService.query()
    .then((movies) => {
      commit('SET_MOVIES', movies)
    })
}

const loadGenres = ({ commit }) => {
  GenreService.query()
    .then((genres) => {
      commit('SET_GENRES', genres)
    })
}

const create = ({ commit }, data) => {
  return new Promise((resolve, reject) => {
    MovieService.store(data)
    .then((movie) => {
      commit('ADD_MOVIE', movie)
      resolve(movie)
    })
    .catch((errors) => {
      reject(errors)
    })
  })
}

const update = ({ commit }, { movie, data }) => {
  return new Promise((resolve, reject) => {
    MovieService.update(movie.id, data)
    .then((movie) => {
      commit('UPDATE_MOVIE', movie)
      resolve(movie)
    })
    .catch((errors) => {
      reject(errors)
    })
  })
}

const destroy = ({ commit }, movie) => {
  MovieService.destroy(movie.id)
    .then(() => {
      commit('DELETE_MOVIE', movie)
    })
}

const markAsViewed = ({ commit }, { movie, watched }) => {
  return new Promise((resolve, reject) => {
    MovieService.update(movie.id, { watched })
      .then((movie) => {
        commit('UPDATE_MOVIE', movie)
        resolve(movie)
      })
      .catch((errors) => {
        reject(errors)
      })
  })
}

export default {
  loadMovies,
  loadGenres,
  create,
  update,
  destroy,
  markAsViewed
}
