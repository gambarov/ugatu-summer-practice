<template>
  <div class="flex flex-col">
    <Toolbar class="mb-3">
      <template #start>
        <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      </template>
    </Toolbar>
    <EquipmentTable @deleteElement="update" :delete="deleteSet" name="sets" :loading="loading" :columns="setsColumns"
      table="Комплекты" :info="info" />
  </div>
  <Dialog class="" header="Добавить комплект" v-model:visible="isDialogOpen" :modal="true">
    <div class="flex ty flex-col p-dialog-content">
      <div class="flex flex-col mb-4">
        <label htmlFor="name">Наименование комплекта</label>
        <InputText id="name" v-model="newEquipment.name" required />
      </div>
      <div class="flex flex-col mb-4">
        <label htmlFor="name">Оборудование</label>
        <AutoComplete class="p-fluid bg-blue-500" :multiple="true" v-model="selectedEquipment" :suggestions="filteredEquipment" @complete="searchEquipment($event)"
          :dropdown="true" field="name" forceSelection>
          <template #item="slotProps">
            <div class="flex flex-row justify-between">
              <span class="ml-2"> {{ slotProps.item.name }}</span>
              <span>{{ slotProps.item.inventory_id }}</span>
            </div>
          </template>
        </AutoComplete>
      </div>
    </div>
    <template #footer>
      <Button label="Отмена" icon="pi pi-times" @click="openDialog(false)" class="p-button-text" />
      <Button label="Сохранить" icon="pi pi-check" @click="addNewSet" class="p-button-success" />
    </template>
  </Dialog>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
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
    AutoComplete
  },
  setup() {
    onMounted(()=>{
      store.dispatch('fetchEquipment')
    })
    const loading = ref(true);
    const info = ref();
    const selectedEquipment = ref();
    const filteredEquipment = ref();
    const store = useStore();
    const equipment=store.getters.GET_EQUIPMENT;
    const isDialogOpen = ref(true);
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const newEquipment = ref({
      name: ''
    })
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
    const searchEquipment = (event) => {
      if (!event.query.trim().length) {
        filteredEquipment.value = [...equipment];
      }
      else {
        filteredEquipment.value = equipment.filter((item) => {
          return item.name.toLowerCase().includes(event.query.toLowerCase());
        });
      }
    }
    const addNewSet = () => {
      if (newEquipment.value.name != null) {
        postSet({
          "name": newEquipment.value.name,
        }).then(() => {
          loading.value = true;
          store.dispatch('fetchSets').then(() => {
            loading.value = false;
            info.value = store.getters.GET_SETS;
          })
        })
        isDialogOpen.value = false;
      }
    };
    return {
      info,
      loading,
      setsColumns,
      newEquipment, isDialogOpen, openDialog,
      deleteSet,
      equipment:computed(()=>store.getters.GET_EQUIPMENT),
      update,
      searchEquipment,
      filteredEquipment,
      selectedEquipment,
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
