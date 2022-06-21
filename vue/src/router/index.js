import { createRouter, createWebHistory } from 'vue-router'
import TabView from "../components/TabView.vue"
const routes = [
  {
    path: '/',
    name: 'mto',
    component: TabView
  },
  {
    path: '/sets',
    name: 'sets',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: TabView,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
