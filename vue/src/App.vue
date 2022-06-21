<template>
  <div>
    <Header />
    <div class="flex p-4">
      <Menu :model="items" class="mr-4" />
      <router-view  class="flex-auto"/>
    </div>
  </div>
</template>
<script>
import Menu from "primevue/menu";
import Header from "./components/Header.vue";
export default {
  components: {
    Menu,
    Header,
  },
  setup() {
    let items = [
      {
        label: "Разделы",
        items: [
          {
            label: "МТО",
            icon: "pi pi-desktop",
            command: () => {},
          },
          {
            label: "Комплекты",
            icon: "pi pi-box",
            command: () => {},
          },
          {
            label: "Аудитории",
            icon: "pi pi-user",
            command: () => {},
          },
          {
            label: "Размещение",
            icon: "pi pi-history",
            command: () => {},
          },
        ],
      },
    ];
    return { items };
  },
};
</script>
<style lang="scss">
button{
  background-color: rgb(143, 73, 73);
}
</style>
