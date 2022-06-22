<template>
<div class="flex flex-col">
  <Toolbar>
    <template #start>
      <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      <Button label="Удалить выбранное" icon="pi pi-trash" class="p-button-danger" :disabled="isEmpty"
        @click="deleteSelected" />
    </template>
  </Toolbar>
  <DataTable :value="data" :paginator="true" :rows="10" dataKey="id" :rowHover="true" filterDisplay="menu"
    :loading="loading" v-model:selection="selectedRows"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
    :rowsPerPageOptions="[10, 25, 50]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
    responsiveLayout="scroll">
    <template #header>
      <div class="flex justify-between items-center">
        <h5 class="m-0">{{table}}</h5>
        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText placeholder="Keyword Search" />
        </span>
      </div>
    </template>
    <template #empty> Нет оборудования </template>
    <template #loading> Загрузка... </template>
    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
    <Column v-for="column in columns" :field="column.field" :header="column.header" sortable></Column>
    <Column headerStyle="width: 4rem; text-align: center"
      bodyStyle="display:flex;text-align: center; overflow: visible">
      <template #body="slotProps">
        <Button @click="showInfo(slotProps.data)" icon="pi pi-eye" className="p-button-rounded p-button-primary mr-2" />
        <Button icon="pi pi-pencil" className="p-button-rounded p-button-success mr-2" />
        <Button icon="pi pi-trash" className="p-button-rounded p-button-danger" />
      </template>
    </Column>
  </DataTable>
  <Dialog header="Добавить МТО" v-model:visible="isDialogOpen" :modal="true">
    <div class="flex flex-col">
      <div class="flex flex-col mb-4">
        <label htmlFor="name">Наименование МТО</label>
        <InputText id="name" v-model="newEquipment.name" required />
      </div>
      <div class="flex flex-col">
        <label htmlFor="type">Тип</label>
        <Dropdown v-model="newEquipment.type" :options="types" placeholder="Выберите тип МТО" />
      </div>
    </div>
    <template #footer>
      <Button label="Отмена" icon="pi pi-times" @click="openDialog(false)" class="p-button-text" />
      <Button label="Сохранить" icon="pi pi-check" @click="addNewEquipment" class="p-button-success"  />
    </template>
  </Dialog>
</div>
  
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
import { ref, computed,watch,onMounted } from "vue";
import { useRouter, useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { mtoColumns } from "@/assets/mtoColumns";

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
  props:{
    table:String,
    data:{
      default:[]
    },
    columns:{
      default:[]
    },
  },
  setup(props) {
    onMounted(()=>{  console.log(props.columns)})
    const store=useStore();
    const router = useRouter()
    const isEmpty = computed(() => {
      return selectedRows === null;
    })
    const types = ["АО", "ПО"];
    const isDialogOpen = ref(false);
    const loading = ref(true);
    const newEquipment = ref({
    })
    const selectedRows = ref();
    
    const data = ref([]);
    data.value=props.data
    loading.value = false;
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const addNewEquipment = () => {
      data.value.push(newEquipment.value);
      newEquipment.value = {};
      isDialogOpen.value = false;
    };
    const deleteSelected = () => {
      data.value = data.value.filter(eq => !selectedRows.value.includes(eq))
    }
    const showInfo=(data)=>{
      console.log(data)
      router.push({ name: 'info',params:{id:data.id}})

    }
    return {
      data,
      loading,
      selectedRows,
      isDialogOpen,
      openDialog,
      newEquipment,
      addNewEquipment,
      types,
      deleteSelected,
      isEmpty,
      mtoColumns,
      showInfo
    };
  },
};
</script>

<style>
button {
  background-color: rgb(143, 73, 73);
}
</style>