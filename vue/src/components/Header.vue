<template>
  <Menubar :model="items">
    <template #start>
        <h1>Инвентаризация</h1>
    </template>
  </Menubar>
</template>

<script>
import Menubar from 'primevue/menubar';
import { ref } from "vue";
export default {
  components: {
    Menubar,
  },
  setup() {
    const items = ref([]);

    return { items };
  },
};
</script>

<style>
</style>