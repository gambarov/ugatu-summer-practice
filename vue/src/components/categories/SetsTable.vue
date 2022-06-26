<template>
  <div class="flex flex-1 flex-col">
    <SetCreation :creation="true" @save="update" :saveEquipment="addNewSet" :equipment="[]"/>
    <EquipmentTable @deleteElement="update" :delete="deleteSet" name="sets" :loading="loading" :columns="setsColumns"
      table="Комплекты" :info="info" />
  </div>

</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import SetCreation from "../modals/SetCreation.vue";
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
  components: {
    EquipmentTable,
    InputText,
    Button,
    Dialog,
    Toolbar,
    AutoComplete,
    SetCreation
  },
  setup() {
    onMounted(()=>{
      store.dispatch('fetchEquipment')
    })
    const loading = ref(true);
    const info = ref();
    const store = useStore();
    store.dispatch('fetchSets').then(() => {
      loading.value = false;
      info.value = store.getters.GET_SETS;
    });
    const update = () => {
      loading.value = true;
      store.dispatch('fetchSets').then(() => {
        loading.value = false;
        info.value = store.getters.GET_SETS;
      });
    }
    const addNewSet = (equipment,name) => {
        return postSet({
          "name": name,
          "equipment":equipment
        });}
    return {
      info,
      loading,
      setsColumns,
      deleteSet,
      update,
      addNewSet
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
.ty{
  min-width:50vw;
}
</style>
