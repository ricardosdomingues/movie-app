import Vue from 'vue'
import VueRouter from 'vue-router'

import MoviesList from '../components/MoviesList.vue'
import MovieForm from '../components/MovieForm.vue'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'movies',
      component: MoviesList
    },
    {
      path: '/new',
      name: 'newMovie',
      component: MovieForm
    },
    {
      path: '/edit/:id',
      name: 'editMovie',
      component: MovieForm
    }
  ]
});

export default router