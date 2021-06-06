<template>
  <div>

    <div class="card">
      <!-- Card Thumbnail -->
      <img
        class="card__thumbnail"
        src="https://i.ibb.co/FDGqCmM/papers-co-ag74-interstellar-wide-space-film-movie-art-33-iphone6-wallpaper.jpg"
        alt="Card image cover"
      >
      <div class="card-body">
        <!-- Card Title -->
        <div class="card__title">
          <h4>{{ movie.title }}</h4>
          <div class="card__menu dropdown show">
            <a class="fas fa-ellipsis-v dropdown-toggle" id="menuItems" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
            <div class="dropdown-menu" aria-labelledby="menuItems">
              <a class="dropdown-item" @click.prevent="edit">Edit</a>
              <a class="dropdown-item" data-toggle="modal" :data-target="`#confirmDeleteModal-${movie.id}`">Delete</a>
            </div>
          </div>
        </div>

        <!-- Card Subtitle -->
        <div class="card__subtitle">
          {{ genres }}
        </div>

        <!-- Card Description -->
        <div class="card__info">
          <h5>Summary</h5>
          <span class="card__info__content">
            {{ movie.description }}
          </span>
        </div>

        <!-- Card Release Date -->
        <div class="card__info">
          <h5>Release Date</h5>
          <span class="card__info__content">
            {{ movie.release_date }}
          </span>
        </div>

        <!-- Card Watched at -->
        <div class="card__info" v-if="movie.watched_at">
          <h5>Watched At</h5>
          <span class="card__info__content">
            {{ movie.watched_at.substring(0, 16) }}
          </span>
        </div>

        <!-- Card Actions -->
        <div>
          <button class="btn btn-primary" @click="markAsViewed({ movie, watched: movie.watched_at === null})">{{ movieAction }}</button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" :id="`confirmDeleteModal-${movie.id}`" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" :id="`confirmDeleteModal-${movie.id}`">Delete Movie {{ movie.title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete {{ movie.title }}?
            <br>
            This operation cannot be undone.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="destroy(movie)">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex'

export default {
  props: {
    movie: {
      type: Object,
      required: true
    }
  },
  computed: {
    genres () {
      return this.movie.genres
        .map((genre) => genre.name)
        .join(' / ')
    },
    movieAction () {
      return this.movie.watched_at ? 'Add to Watch List' : 'Add to Watched List'
    }
  },
  methods: {
    ...mapActions([
      'markAsViewed',
      'destroy'
    ]),
    edit () {
      this.$router.push({ path: `/edit/${this.movie.id}`, params: { id: this.movie.id } })
    }
  }
}
</script>

<style lang="scss" scoped>
$border-radius-size: 15px;

.card {
  width:300px;
  border-radius: $border-radius-size;

  &__thumbnail {
    border-top-right-radius: $border-radius-size;
    border-top-left-radius: $border-radius-size;
    object-fit: cover;
    background-size: contain;
    background-size: cover;
    width: 100%;
    height: 300px;
  }

  &__title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.25rem;

    & h4 {
      margin-bottom: 0;
    }
  }

  &__subtitle {
    color: grey;
    margin-bottom: 0.75rem;
    font-size: 0.9em;
  }

  &__info {
    margin-bottom: 1rem;

    & h5 {
      margin-bottom: 0.25rem;
    }
  }

  &__info__content {
    color: grey;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  &__menu {
    font-size: 1.2rem;
    ::after {
      display: none;
    }
    &:hover {
      cursor: pointer;
    }

    & .dropdown-menu {
      transform: translate3d(-100px, 23px, 0px);
    }
  }
}
</style>