<template>
  <div class="flex flex-1 flex-col">
    <Toolbar class="mb-3">
      <template  #start>
        <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      </template>
    </Toolbar>
    <EquipmentTable @deleteElement="updateEq" :delete="deleteEquipment" name="mto" :loading="loading"
      :columns="mtoColumns" table="МТО" :info="info" :qrCode="true"/>
  </div>

  <Dialog header="Добавить МТО" v-model:visible="isDialogOpen" :modal="true">
    <div class="flex flex-col">
      <div class="flex flex-col mb-4">
        <label htmlFor="name">Наименование МТО</label>
        <InputText id="name" v-model="newEquipment.name" required />
      </div>
      <div class="flex flex-col mb-4">
        <label htmlFor="name">Идентификатор</label>
        <InputText id="name" v-model="newEquipment.id" required />
      </div>
      <div class="flex flex-col">
        <label htmlFor="type">Тип</label>
        <AutoComplete class="p-fluid bg-blue-500" v-model="selectedType" :suggestions="filteredType"
          @complete="searchType($event)" :dropdown="true" field="name" :forceSelection="true">
          <template #item="slotProps">
            <div class="flex flex-row justify-between">
              <span class="ml-2"> {{ slotProps.item.name }}</span>
            </div>
          </template>
        </AutoComplete>
      </div>
    </div>
    <template #footer>
      <Button label="Отмена" icon="pi pi-times" @click="openDialog(false)" class="p-button-text" />
      <Button label="Сохранить" icon="pi pi-check" @click="addNewEquipment" class="p-button-success" />
    </template>
  </Dialog>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import Dropdown from 'primevue/dropdown';
import AutoComplete from "primevue/autocomplete";
import { useStore } from 'vuex'
import { ref, computed, onBeforeMount } from "vue";
import { mtoColumns } from "@/assets/mtoColumns";
import { postEquipment, deleteEquipment } from "@/assets/api/equipment";
export default {
  components: {
    EquipmentTable,
    InputText,
    Button,
    Dialog,
    Toolbar,
    Dropdown,
    AutoComplete
  },
  setup() {
    onBeforeMount(() => {
    })
    const loading = ref(true);
    const store = useStore();
    const info = ref();
    const selectedType = ref();
    const filteredType = ref();
    const types = ref([]);
    const isDialogOpen = ref(false);
    const newEquipment = ref({
    })
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const addNewEquipment = () => {
      if (newEquipment.value.id != null && newEquipment.value.name != null && selectedType.value != null) {
        const body = {
          "inventory_id": newEquipment.value.id,
          "name": newEquipment.value.name,
          "equipment_type_id": selectedType.value.id
        }
        postEquipment(body).then(() => {
          loading.value = true;
          store.dispatch('fetchEquipment').then(() => {
            loading.value = false;
            info.value = store.getters.GET_EQUIPMENT;
          })
        })
        isDialogOpen.value = false;
      }
    };
    const updateEq = () => {
      loading.value = true;
      store.dispatch('fetchEquipment').then(() => {
        loading.value = false;
        info.value = store.getters.GET_EQUIPMENT;
        types.value = store.getters.GET_EQUIPMENT_TYPES;
      });
    }
    updateEq();
    const searchType = (event) => {
      if (!event.query.trim().length) {
        filteredType.value = [...types.value];
      }
      else {
        filteredType.value = types.value.filter((item) => {
          if (item.name.toLowerCase().includes(event.query.toLowerCase())) {
            return true;
          }
          return false;
        });
      }
    }
    return {
      info,
      mtoColumns,
      loading,
      postEquipment,
      deleteEquipment,
      updateEq,
      addNewEquipment,
      newEquipment,
      openDialog,
      types,
      isDialogOpen,
      filteredType,
      selectedType,
      searchType
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
