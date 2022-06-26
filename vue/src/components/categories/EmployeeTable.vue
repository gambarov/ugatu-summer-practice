<template>
  <div class="flex flex-1 flex-col">
    <Creation type="employee" @save="update" :saveClass="addNewEmployee" />
    <EquipmentTable @deleteElement="update" :delete="deleteEmployee" :loading="loading" :info="info"
      :columns="employeeColumns" table="Сотрудники" />
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
import { employeeColumns } from "@/assets/employeeColumns";
import { postEmployee, deleteEmployee } from "@/assets/api/employee";
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
      store.dispatch('fetchEmployees').then(() => {
        loading.value = false;
        info.value = store.getters.GET_EMPLOYEES;
      });
    }
    update();
    const addNewEmployee = (employee) => {
      return postEmployee({
        "surname": employee.surname,
        "name": employee.name,
        "patronymic": employee.patronymic,
        "email": employee.email,
        "password":employee.password,
        "role_id":1
      });
    }

    return {
      info,
      employeeColumns,
      loading,
      isDialogOpen,

      openDialog,
      newEquipment,
      addNewEmployee,
      deleteEmployee,
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
