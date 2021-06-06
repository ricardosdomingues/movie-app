import Vue from 'vue'

const SET_MOVIES = (state, movies) => {
  state.movies = movies
}

const SET_GENRES = (state, genres) => {
  state.genres = genres
}

const ADD_MOVIE = (state, movie) => {
  state.movies.push(movie)
}

const UPDATE_MOVIE = (state, movie) => {
  const index = state.movies.findIndex(_movie => _movie.id === movie.id)

  if (index !== -1) {
    Vue.set(state.movies, index, movie)
  }
}

const DELETE_MOVIE = (state, movie) => {
  state.movies = state.movies.filter((m) => m.id !== movie.id)
}

export default {
  SET_MOVIES,
  SET_GENRES,
  ADD_MOVIE,
  UPDATE_MOVIE,
  DELETE_MOVIE
}
