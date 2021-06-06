<template>
  <div>
    <h1>{{ title }} </h1>
    <form>

      <!-- Form title -->
      <div class="form-row">
        <div class="form-group col-6">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" placeholder="Title" v-model="form.title" @input="formErrors.clear('title')">
          <small class="text text-danger" v-if="formErrors.has('title')">
            {{ formErrors.get('title')[0] }}
          </small>
        </div>
      </div>

      <!-- Form description -->
      <div class="form-row">
        <div class="form-group col-6">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" placeholder="Description" v-model="form.description" @input="formErrors.clear('description')"></textarea>
          <small class="text text-danger" v-if="formErrors.has('description')">
            {{ formErrors.get('description')[0] }}
          </small>
        </div>
      </div>

      <!-- Form Genres -->
      <div class="form-row">
        <div class="form-group col-6">
          <label for="genres">Genres</label>
          <select multiple class="form-control" id="genres" v-model="form.genres" @change="formErrors.clear('genres')">
            <option
              v-for="genre in genres"
              :key="genre.id"
              :value="genre.id"
            >
              {{ genre.name }}
            </option>
          </select>
          <small class="text text-danger" v-if="formErrors.has('genres')">
            {{ formErrors.get('genres')[0] }}
          </small>
        </div>
      </div>

      <!-- Form Release Date -->
      <div class="form-row">
        <div class="form-group col-6">
          <label for="releaseDate">Release Date</label>
          <input type="date" class="form-control" id="releaseDate" placeholder="Release Date" v-model="form.release_date" @input="formErrors.clear('release_date')">
          <small class="text text-danger" v-if="formErrors.has('release_date')">
            {{ formErrors.get('release_date')[0] }}
          </small>
        </div>
      </div>

      <!-- Form Watched -->
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="watchedInput" v-model="form.watched">
          <label class="form-check-label" for="watchedInput">
            Watched
          </label>
        </div>
      </div>

      <!-- Form Actions -->
      <div>
        <button class="btn btn-primary" @click.prevent="$router.go(-1)">Cancel</button>
        <button @click.prevent="submit" type="submit" class="btn btn-primary">{{ btnSubmitText }}</button>
      </div>
    </form>
  </div>
</template>
<script>
import Errors from '../utils/Errors'
import { mapActions, mapGetters } from 'vuex'
import { MovieService } from '../api/MovieService'

export default {
  data () {
    return {
      selectedMovie: null,
      form: {
        title: '',
        description: '',
        genres: [],
        release_date: null,
        watched: false
      },
      formErrors: new Errors()
    }
  },
  created () {
    this.loadGenres()
  },
  methods: {
    ...mapActions([
      'loadGenres',
      'create',
      'update'
    ]),
    fillForm () {
      const data = JSON.parse(JSON.stringify(this.selectedMovie))
        if (data.genres.length) {
          data.genres = data.genres.map((genre) => genre.id)
        }
        data.watched = data.watched_at !== null
        this.form = data
    },
    submit () {
      const promise = this.isUpdating
        ? this.update({ movie: this.selectedMovie, data: this.form })
        : this.create(this.form)

      promise
        .then(() => {
          this.$router.push({ path: '/' })
        })
        .catch((errors) => {
          if (errors.response.status === 422) {
            this.formErrors.record(errors.response.data.errors)
          }
        })
    },
  },
  computed: {
    ...mapGetters([
      'genres'
    ]),
    isUpdating () {
      return this.selectedMovie !== null
    },
    title () {
      return this.isUpdating ? 'Edit movie' : 'Create movie'
    },
    btnSubmitText () {
      return this.isUpdating ? 'Edit' : 'Create'
    }
  },
  watch: {
    isUpdating (value) {
      if (value) {
        this.fillForm()
      }
    },
    selectedMovie () {
      this.fillForm()
    }
  },
  beforeRouteEnter (to, from, next) {
    if (to.params.id !== undefined) {
      next((vm) => {
        MovieService.get(to.params.id)
          .then((movie) => {
            vm.selectedMovie = movie
            next()
          })
          .catch(() => {
            next(from)
          })
      })
    } else {
      next()
    }
  },
  beforeRouteUpdate (to, from, next) {
    if (to.params.id !== undefined) {
      MovieService.get(to.params.id)
        .then((movie) => {
          this.selectedMovie = movie
          next()
        })
        .catch(() => {
          next(from)
        })
    } else {
      next()
    }
  }
}
</script>