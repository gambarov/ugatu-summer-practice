<template>
  <div class="flex flex-1 flex-col">
    <Creation type="class" @save="update" :saveClass="addNewClass"/>
    <EquipmentTable @deleteElement="update" :delete="deleteClass" :loading="loading" :info="info"
      :columns="classesColumns" table="Аудитории" />
  </div>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import Creation from "@/components/modals/Creation.vue"
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import Dropdown from 'primevue/dropdown';
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { classesColumns } from "@/assets/classesColumns";
import { postClass, deleteClass } from "@/assets/api/classes";
export default {
  components: {
    EquipmentTable,
    InputText,
    Button,
    Dialog,
    Toolbar,
    Dropdown,
    Creation
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
    const update = () => {
      loading.value = true;
      store.dispatch('fetchClasses').then(() => {
        loading.value = false;
        info.value = store.getters.GET_CLASSES;
      });
    }
    update();
const addNewClass = (className) => {
        return postClass({
                    "building": className.building,
          "number": className.number,
          "letter": className.letter
        });}
   
    return {
      info,
      classesColumns,
      loading,
      isDialogOpen,
      openDialog,
      newEquipment,
      addNewClass,
      deleteClass,
      update
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
