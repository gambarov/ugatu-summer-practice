<template>
  <div>
    <Header />
    <div class="flex relative p-4">
      <Menu :model="items" class="mr-4" />
      <router-view class="flex-auto" />
    </div>
  </div>
</template>
<script>
import Menu from "primevue/menu";
import Header from "./components/Header.vue";
import { useRouter, useRoute } from 'vue-router'
export default {
  components: {
    Menu,
    Header,
  },
  setup() {
    const router = useRouter()
    const route = useRoute()
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
            label: "Размещение",
            icon: "pi pi-history",
            command: () => { router.push({ name: 'history' }) },
          },
        ],
      },
    ];
    return { items };
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
</style>
