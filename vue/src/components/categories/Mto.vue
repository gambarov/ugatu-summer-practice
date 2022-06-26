<template>
  <div class="flex flex-1 flex-col">
    <Toolbar class="mb-3">
      <template #start>
        <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      </template>
    </Toolbar>
    <EquipmentTable @deleteElement="updateEq" :delete="deleteEquipment" name="mto" :loading="loading"
      :columns="mtoColumns" table="Мто" :info="info" />
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
        <Dropdown v-model="newEquipment.type" optionLabel="name" :options="types" placeholder="Выберите тип МТО" />
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
import { useStore } from 'vuex'
import { ref, computed, onMounted } from "vue";
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
  },
  setup() {
    const loading = ref(true);
    const store = useStore();
    const info = ref();
    const types = [{ name: "ПО", code: 1 }, { name: "АО", code: 2 }];
    const isDialogOpen = ref(false);
    const newEquipment = ref({
      type: { name: "ПО", code: 1 },
      name: ''
    })
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const addNewEquipment = () => {
      if (newEquipment.value.id != null && newEquipment.value.name != null) {
        postEquipment({
          "inventory_id": newEquipment.value.id,
          "name": newEquipment.value.name,
          "equipment_type_id": newEquipment.value.type.code
        }).then(() => {
          loading.value = true;
          store.dispatch('fetchEquipment').then(() => {
            loading.value = false;
            info.value = store.getters.GET_EQUIPMENT;
          })
        })
        isDialogOpen.value = false;
      }
    };
    store.dispatch('fetchEquipment').then(() => {
      loading.value = false;
      info.value = store.getters.GET_EQUIPMENT;
    });
    const updateEq = () => {
      loading.value = true;
      store.dispatch('fetchEquipment').then(() => {
        loading.value = false;
        info.value = store.getters.GET_EQUIPMENT;
      });
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
      isDialogOpen

    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
