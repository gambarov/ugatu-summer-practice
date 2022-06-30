<template>
  <Menubar>
    <template #start>
      <h1>Магл</h1>

    </template>
    <template #end>
      <Button label="Профиль" v-if="loggedIn" icon="pi pi-user" type="button" class="p-button-rounded bg-blue-500"
        @click="toggle($event)" aria-haspopup="true" aria-controls="overlay_menu" />
      <!-- <div v-else>
        <Button label="Зарегистрироваться" class="p-button-text" />
        <Button label="Войти" class="p-button-success p-button-text" />
      </div> -->

    </template>
  </Menubar>
  <Menu id="overlay_menu" ref="menu" :model="items" :popup="true" />
</template>

<script>
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import Menu from 'primevue/menu';
import { ref, computed } from "vue";
import { useRouter, useRoute } from 'vue-router'
import { useStore } from 'vuex'
export default {
  components: {
    Menubar,
    Button,
    Menu
  },
  setup() {
    const router = useRouter();
    const menu = ref();
    const store = useStore();
    const toggle = (event) => {
      menu.value.toggle(event);
    };
    const logOff = () => {
      store.dispatch('deleteUser');
      router.push({ name: 'login' });
    }
    const items = ref([
      {
        label: 'Quit',
        icon: 'pi pi-fw pi-power-off',
        command: () => {
          logOff();
        }
      },
    ]);
    return {
      items,
      menu,
      toggle,
      loggedIn: computed(() => {
        return store.getters.GET_AUTHENTICATION;
      })
    };
  },
};
</script>

<style>
</style>