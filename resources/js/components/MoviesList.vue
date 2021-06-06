<template>
  <div>
    
    <!-- Add Movie Btn -->
    <button class="btn btn-primary mb-2" @click="$router.push({ path: '/new' })">Add new movie</button>
    
    <!-- Movies To Watch In The Future -->
    <div class="list">
      <!-- List Header -->
      <div class="list__header">
        <h2 class="list__header__title">Watch List</h2>
        &nbsp;
        <h2 v-if="unwatchedMovies.length">({{ unwatchedMovies.length }})</h2>
      </div>

      <!-- Movie Items -->
      <div class="list__content" v-if="unwatchedMovies.length">
        <movie-details
          class="list__content__item"
          v-for="movie in unwatchedMovies"
          :key="movie.id"
          :movie="movie">
        </movie-details>
      </div>
      <div v-else class="list__no-data">
        <span>No movies to watch in the future</span>
      </div>
    </div>
    
    <!-- Movies Watched In The Past -->
    <div class="list">
      <!-- List Header -->
      <div class="list__header">
        <h2 class="list__title">Watched List</h2>
        &nbsp;
        <h2 v-if="watchedMovies.length">({{ watchedMovies.length }})</h2>
      </div>

      <!-- Movie Items -->
      <div class="list__content" v-if="watchedMovies.length">
        <movie-details
          class="list__content__item"
          v-for="movie in watchedMovies"
          :key="movie.id"
          :movie="movie">
        </movie-details>
      </div>
      <div v-else class="list__no-data">
        <span>No movies watched in the past</span>
      </div>
    </div>

  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  created () {
    this.loadMovies()
  },
  methods: {
    ...mapActions([
      'loadMovies'
    ])
  },
  computed: {
    ...mapGetters([
      'watchedMovies',
      'unwatchedMovies'
    ])
  }
}
</script>

<style lang="scss" scoped>
@mixin mobile {
  @media only screen and (max-width: 600px) {
    @content;
  }
}

.list {
  &__header {
    display: flex;
    align-items: center;

    &__title {
      color: rgb(54, 54, 54);
    }
  }

  &__content {
    display: flex;
    justify-content: flex-start;
    flex-flow: row wrap;

    @include mobile {
      flex-direction: column;
      align-items: center;

      &__item {
        margin-right: 0rem;
        margin-bottom: 1rem;
      }
    }

    &__item {
      margin-right: 1.5rem;
      margin-bottom: 1rem;
    }
  }

  &__no-data {
    display: flex;
    justify-content: flex-start;
    align-items: center;

    & span {
      font-weight: bold;
    }
  }

}
</style>