<template>
  <Toolbar>
    <template #start>
      <Button
        label="Добавить"
        icon="pi pi-plus"
        class="p-button bg-blue-400 mr-3"
        @click="addEquipment()"
      />
      <Button
        label="Удалить выбранное"
        icon="pi pi-trash"
        class="p-button-danger"
        :disabled="isEmpty"
        @click="deleteSelected"
      />
    </template>
  </Toolbar>
  <DataTable
    :value="data"
    :paginator="true"
    :rows="10"
    dataKey="id"
    :rowHover="true"
    filterDisplay="menu"
    :loading="loading"
    v-model:selection="selectedRows"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
    :rowsPerPageOptions="[10, 25, 50]"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
    responsiveLayout="scroll"
  >
    <template #header>
      <div class="flex justify-between items-center">
        <h5 class="m-0">МТО</h5>
        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText placeholder="Keyword Search" />
        </span>
      </div>
    </template>
    <template #empty> Нет оборудования </template>
    <template #loading> Загрузка... </template>
    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
    <Column field="id" header="№" sortable></Column>
    <Column field="name" header="Название" sortable></Column>
    <Column field="type" header="Тип" sortable></Column>
    <Column
      headerStyle="width: 4rem; text-align: center"
      bodyStyle="display:flex;text-align: center; overflow: visible"
    >
      <template #body>
        <Button
          icon="pi pi-eye"
          className="p-button-rounded p-button-primary mr-2"
        />
        <Button
          icon="pi pi-pencil"
          className="p-button-rounded p-button-success mr-2"
        />
        <Button
          icon="pi pi-trash"
          className="p-button-rounded p-button-danger"
        />
      </template>
    </Column>
  </DataTable>
  <Dialog header="Добавить МТО" v-model:visible="isDialogOpen" :modal="true">
    <div class="flex flex-col">
      <div class="flex flex-col mb-4">
      <label htmlFor="name">Наименование МТО</label>
      <InputText id="name" v-model="newEquipment.name" required autoFocus />
    </div>
    <div class="flex flex-col">
      <label htmlFor="type">Тип</label>
      <Dropdown v-model="newEquipment.type" :options="types" placeholder="Выберите тип МТО" />
    </div>
    </div>
    
    <template  #footer>
		<Button label="Отмена" icon="pi pi-times" class="p-button-text"/>
    <Button label="Сохранить" icon="pi pi-check" @click="addNewEquipment" class="p-button-success" autofocus />
	</template>
  </Dialog>
</template>

<script>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import Dropdown from 'primevue/dropdown';
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { ref, computed } from "vue";
export default {
  components: {
    DataTable,
    Column,
    InputText,
    Button,
    Dialog,
    Toolbar,
    Dropdown,
  },
  setup() {
    const isEmpty = computed(() => {
  return selectedRows === null; 
})
    const types=["АО","ПО"];
    const equipmentTemplate={
      name:'',
      type:null,
    }
    const isDialogOpen = ref(true);
    const loading = ref(true);
    const newEquipment=ref({
      name:'',
      type:null,
    })
    const selectedRows = ref();
    const data = ref([]);
    for (let i = 0; i < 4; i++) {
      data.value.push({
        id: i + 1,
        name: `Обеспечение${i + 1}`,
        type: Math.random() > 0.5 ? "ПО" : "АО",
      });
    }
    loading.value = false;
    const addEquipment = () => {
      isDialogOpen.value = true;
    };
    const addNewEquipment = () => {
      data.value.push(newEquipment.value);
      newEquipment.value=equipmentTemplate;
      isDialogOpen.value=false;
    };
    const deleteSelected=()=>{
      data.value=data.value.filter(eq => !selectedRows.value.includes(eq))
    }
    return {
      data,
      loading,
      selectedRows,
      isDialogOpen,
      addEquipment,
      newEquipment,
      addNewEquipment, 
      types,
      deleteSelected,
      isEmpty
    };
  },
};
</script>

<style>
button {
  background-color: rgb(143, 73, 73);
}
</style>