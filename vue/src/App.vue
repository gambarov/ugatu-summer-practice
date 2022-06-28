<template>
  <div>
    <Header />
    <div class="flex relative p-4">
      <Menu v-if="isLogedIn" :model="items" class="mr-4" />
      <router-view class="" />
    </div>
  </div>
</template>
<script>
import Menu from "primevue/menu";
import Header from "./components/Header.vue";
import { useRouter, useRoute } from 'vue-router'
import { ref } from "vue";
import { useStore } from 'vuex'
import { computed } from "@vue/reactivity";
export default {
  components: {
    Menu,
    Header,
  },
  setup() {
    const store=useStore();
    const router = useRouter()
    const route = useRoute();
    // store.dispatch('fetchUser',{name:'aaa'})
    let items = [
      {
        label: "Разделы",
        items: [
          {
            label: "МТО",
            icon: "pi pi-desktop",
            command: () => { router.push({ name: 'mto'}) }
          },
          {
            label: "Комплекты",
            icon: "pi pi-box",
            command: () => { router.push({ name: 'sets'}) },
          },
          {
            label: "Аудитории",
            icon: "pi pi-user",
            command: () => { router.push({ name: 'classes' }) },
          },
          {
            label: "Сотрудники",
            icon: "pi pi-id-card",
            command: () => { router.push({ name: 'employees' }) },
          },
        ],
      },
    ];
    if(store.getters.GET_RIGHTS!==true){
      items=items[0]['items'].filter((item)=>item.label!=="Сотрудники");
    }
    console.log(route.fullPath)
    return { items, isLogedIn:computed(()=>{return route.fullPath!=='/login'?true:false}) };
  },
};
</script>
<style lang="scss">
#app{
  font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
button {
  background-color: rgb(143, 73, 73);
}
.card {
  border: 1px solid #dee2e6;
  border-radius: 3px;
}
</style>
