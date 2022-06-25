<template>
  <div class="flex flex-col">
    <Toolbar class="mb-3">
      <template #start>
        <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      </template>
    </Toolbar>
    <Dialog header="Добавить МТО" v-model:visible="isDialogOpen" :modal="true">
      <div class="flex flex-col">
        <div class="flex flex-col mb-4">
          <label htmlFor="name">Корпус</label>
          <InputText id="name" v-model="newEquipment.building" required />
        </div>
        <div class="flex flex-col mb-4">
          <label htmlFor="name">Номер</label>
          <InputText id="name" v-model="newEquipment.number" required />
        </div>
        <div class="flex flex-col mb-4">
          <label htmlFor="name">Литер</label>
          <InputText id="name" v-model="newEquipment.letter" required />
        </div>
      </div>
      <template #footer>
        <Button label="Отмена" icon="pi pi-times" @click="openDialog(false)" class="p-button-text" />
        <Button label="Сохранить" icon="pi pi-check" @click="addNewClass" class="p-button-success" />
      </template>
    </Dialog>
    <EquipmentTable :loading="loading" :info="info" :columns="classesColumns" table="Аудитории" />
  </div>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import Dropdown from 'primevue/dropdown';
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { classesColumns } from "@/assets/classesColumns";
import { postClass } from "@/assets/api/classes";
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
    const info = ref();
    const store = useStore();
    const isDialogOpen = ref(false);
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const newEquipment = ref({
      letter: ' '
    })
    store.dispatch('fetchClasses').then(() => {
      loading.value = false;
      info.value = store.getters.GET_CLASSES;
    });
    const addNewClass = () => {
      if (newEquipment.value.building != null && newEquipment.value.number != null) {
        postClass({
          "building": newEquipment.value.building,
          "number": newEquipment.value.number,
          "letter": newEquipment.value.letter
        }).then(() => {
          loading.value = true
          store.dispatch('fetchClasses').then(() => {
            loading.value = false;
            info.value = store.getters.GET_CLASSES;
          })
        })
          .catch(error => console.log(error))
        isDialogOpen.value = false;
      }
    };
    return {
      info,
      classesColumns,
      loading,
      isDialogOpen,
      openDialog,
      newEquipment,
      addNewClass
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
