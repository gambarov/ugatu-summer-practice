<template>
  <ConfirmDialog></ConfirmDialog>
    <DataTable class="card" :value="info" :paginator="true" :rows="10" dataKey="id" :rowHover="true"
      filterDisplay="menu" :loading="loading" v-model:selection="selectedRows"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      :rowsPerPageOptions="[10, 25, 50]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
      responsiveLayout="scroll">
      <template #header>
        <div class="flex justify-between items-center">
          <div class="flex flex-row items-center ">
            <h5 class="m-0 mr-3">{{ table }}</h5>
            <!-- <Button label="Удалить выбранное" icon="pi pi-trash" class="p-button-danger" :disabled="isEmpty"
        @click="deleteSelected" /> -->
          </div>

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
          <Button @click="showInfo(slotProps.data)" icon="pi pi-eye"
            className="p-button-rounded p-button-primary mr-2" />
          <Button icon="pi pi-pencil" className="p-button-rounded p-button-success mr-2" />
          <Button icon="pi pi-trash" @click="confirm2(slotProps.data.id)"
            className="p-button-rounded p-button-danger" />
        </template>
      </Column>
    </DataTable>

</template>

<script>
import ConfirmDialog from 'primevue/confirmdialog';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toolbar from "primevue/toolbar";
import Dropdown from 'primevue/dropdown';
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { useConfirm } from "primevue/useconfirm";
import { ref, computed, watch, onMounted } from "vue";
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
    ConfirmDialog
  },
  emits: ['deleteElement'],
  props: {
    table: String,
    name: String,
    delete: Function,
    info: {
      default: []
    },
    columns: {
      default: []
    },
    loading: {
      default: true
    }
  },
  setup(props, { emit }) {
    const confirm = useConfirm();
    const store = useStore();
    const router = useRouter()
    const isEmpty = computed(() => {
      return selectedRows === null;
    })
    const isDialogOpen = ref(false);
    const selectedRows = ref();
    const data = ref([]);
    data.value = props.info;
    const openDialog = (value) => {
      isDialogOpen.value = value;
    };
    const confirm2 = (id) => {
      confirm.require({
        message: 'Do you want to delete this record?',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        acceptClass: 'p-button-danger',
        accept: () => {
          console.log(id)
          props.delete(id).then(() => { emit('deleteElement') });
          // store.dispatch('deleteEquipment',id);

        },
        reject: () => {
        }
      });
    }
    const deleteSelected = () => {
      data.value = data.value.filter(eq => !selectedRows.value.includes(eq))
    }
    const showInfo = (data) => {
      console.log(data)
      router.push({ name: props.name + 'Info', params: { id: data.id } })

    }
    return {
      data,
      selectedRows,
      isDialogOpen,
      openDialog,
      deleteSelected,
      isEmpty,
      mtoColumns,
      showInfo,
      confirm2
    };
  },
};
</script>

<style>
button {
  background-color: rgb(143, 73, 73);
}

.card {
  border: 1px solid #dee2e6;
  border-radius: 3px;
}
</style>