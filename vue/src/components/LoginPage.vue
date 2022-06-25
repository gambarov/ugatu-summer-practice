<template>
  <div class="flex flex-col">
    <h1>Login</h1>
  </div>
</template>
<script>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import AutoComplete from 'primevue/autocomplete';
import { useStore } from 'vuex'
import { ref,onMounted, computed } from "vue";
import { setsColumns } from "@/assets/setsColumns";
import { deleteSet, postSet } from "@/assets/api/sets"
export default {
    components:{
        InputText,
        Button
    }
}
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
.ty{
  min-width:50vw;
}
</style>