import { createRouter, createWebHistory } from 'vue-router'
import Mto from "../components/categories/Mto.vue";
import SetsTable from "../components/categories/SetsTable.vue";
import ClassesTable from "../components/categories/ClassesTable.vue";
import HistoryTable from "../components/categories/HistoryTable.vue";
import EmployeeTable from "../components/categories/EmployeeTable.vue";
import EquipmentInfo from "../components/EquipmentInfo.vue";
import SetsInfo from "../components/SetsInfo.vue";
import LoginPage from "../components/LoginPage.vue";
import MtoPlacements from "../components/MtoPlacements.vue"
import MtoWorks from "../components/MtoWorks.vue"
import TabMenu from "../components/TabMenu.vue"


const routes = [
  {
    path: '/',
    name: 'default',
    component: Mto
  },
  {
    path: '/login',
    name: 'login',
    component: LoginPage
  },
  {
    path: '/category/mto',
    name: 'mto',
    component: Mto,
  },
  {
    path: '/category/mto/info/:id',
    name: 'mtoInfo',
    components: {
      default: TabMenu,
    },
    props: true,
    children: [{
      path: 'placements',
      props: true,
      components: {
        tabs: MtoPlacements
      },
    },
    {
      path: '',
      props: true,
      components: {
        tabs: EquipmentInfo
      },
    },
    {
      path: 'works',
      props: true,
      components: {
        tabs: MtoWorks
      },
    },
    ]
  },
  {
    path: '/category/sets/info/:id',
    name: 'setsInfo',
    component: SetsInfo,
    props: true,
  },
  {
    path: '/category/sets',
    name: 'sets',
    component: SetsTable,
  },
  {
    path: '/category/classes',
    name: 'classes',
    component: ClassesTable,
  },
  {
    path: '/category/history',
    name: 'history',
    component: HistoryTable,
  },
  {
    path: '/category/employees',
    name: 'employees',
    component: EmployeeTable,
  },
]

const isAuthenticated = () => {
  let user = JSON.parse(localStorage.getItem('user'))
  if (user != null) {
    return true
  }
  return false;
}
const router = createRouter({
  history: createWebHistory(),
  routes
})
router.beforeEach((to, from, next) => {
  if (to.name !== 'login' && !isAuthenticated()) next({ name: 'login' })
  else next()
})
export default router
