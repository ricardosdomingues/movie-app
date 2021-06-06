const genres = state => state.genres

const watchedMovies = state => state.movies.filter((movie) => movie.watched_at !== null)

const unwatchedMovies = state => state.movies.filter((movie) => movie.watched_at === null)

export default {
  genres,
  watchedMovies,
  unwatchedMovies
}
