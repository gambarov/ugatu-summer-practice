import { createRouter, createWebHistory } from 'vue-router'
import Mto from "../components/categories/Mto.vue";
import SetsTable from "../components/categories/SetsTable.vue";
import ClassesTable from "../components/categories/ClassesTable.vue";
import HistoryTable from "../components/categories/HistoryTable.vue";
import EquipmentInfo from "../components/EquipmentInfo.vue";
import SetsInfo from "../components/SetsInfo.vue";

const routes = [
  {
    path: '/',
    name: 'default',
    component: Mto
  },
  {
    path: '/category/mto',
    name:'mto',
    component: Mto,
  },
  {
    path: '/category/mto/info/:id',
    name:'mtoInfo',
    component: EquipmentInfo,
    props:true,
  },
  {
    path: '/category/sets/info/:id',
    name:'setsInfo',
    component: SetsInfo,
    props:true,
  },
  {
    path: '/category/sets',
    name:'sets',
    component: SetsTable,
  },
  {
    path: '/category/classes',
    name:'classes',
    component: ClassesTable,
  },
  {
    path: '/category/history',
    name:'history',
    component: HistoryTable,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
