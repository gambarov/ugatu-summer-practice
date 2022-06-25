<template>
  <div class="flex p-4 items-center card flex-1 flex-col">
    <h1 class="font-semibold">Вход в систему</h1>
    <div class="tt">
      
      <div class=" p-inputgroup mt-3 mb-3 ">
        <span class="p-inputgroup-addon">
          <i class="pi pi-user"></i>
        </span>
        <InputText v-model="login" placeholder="Введите логин" />
      </div>
      <div class="p-inputgroup mb-3">
        <span class="p-inputgroup-addon">
          <i class="pi pi-lock"></i>
        </span>
        <Password class="flex" v-model="password" :feedback="false" placeholder="Введите пароль" toggleMask></Password>
      </div>
      <div class="flex flex-col justify-end">
        <Button @click="checkLogin" class="mb-3 p-button-success" label="Войти"/>
        <Button class="p-button-outlined" label="Зарегистрироваться"/>
      </div>
    </div>

  </div>
</template>
<script>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Password from 'primevue/password';
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import AutoComplete from 'primevue/autocomplete';
import { useStore } from 'vuex'
import { ref, onMounted, computed } from "vue";
import { setsColumns } from "@/assets/setsColumns";
import { deleteSet, postSet } from "@/assets/api/sets"
export default {
  components: {
    InputText,
    Button,
    Password
  },
  setup() {
    const login = ref();
    const password = ref();
    const store=useStore();
    const checkLogin=()=>{
      store.dispatch('fetchUser',{ name: login.value, password: password.value }).then(()=>console.log("lolf"))
    }
   return{
    login,password,checkLogin
  } 
  }
  
}
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}

.tt {
  min-width: 400px;
}
</style>