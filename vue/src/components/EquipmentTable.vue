<template>
  <div>
  <ConfirmDialog></ConfirmDialog>

  <div id="printMe">
    <div class="item" v-for="(row, index) in selectedRows" :key="index">
      <div class="column">
        <div class="align-items-center">
          <p>{{row.inventory_id}}</p>
          <!-- TODO: Добавить нормальную ссылку на страницу оборудования -->
          <qrcode-vue :value="row" render-as="svg"></qrcode-vue>
        </div>
      </div>
    </div>
  </div>
 
  <DataTable  v-model:filters="filters" class="card" :value="info" :paginator="true" :rows="10" dataKey="id" :rowHover="true" filterDisplay="menu"
    :loading="loading" v-model:selection="selectedRows"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
    :rowsPerPageOptions="[10, 25, 50]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
    responsiveLayout="scroll">
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex flex-row items-center ">
          <h5 class="m-0 text-xl mr-3">{{ table }}</h5>

        </div>

        <span class="p-input-icon-left">
          <i class="pi pi-search" />
          <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
        </span>
        <Button v-if="isSelectedEmpty" label="Удалить выбранное" icon="pi pi-trash" class="p-button-danger" :disabled="isEmpty"
          @click="confirmDeleteSelected" />
        <Button v-if="isSelectedEmpty" v-print="'#printMe'" label="Распечатать QR-код" @click="printQrcode" class="p-button bg-blue-500" />
      </div>
    </template>
    <template #empty> Нет оборудования </template>
    <template #loading> Загрузка... </template>
    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
    <Column style="word-wrap: break-word; max-width:300px; white-space: initial;" v-for="column in columns" :field="column.field" :header="column.header" sortable></Column>
    <Column headerStyle="width: 4rem; text-align: center"
      bodyStyle="display:flex;text-align: center; overflow: visible">
      <template #body="slotProps">
        <Button @click="showInfo(slotProps.data)" icon="pi pi-eye" className="p-button-rounded p-button-primary mr-2" />
        <Button icon="pi pi-trash" @click="confirm2(slotProps.data.id)" className="p-button-rounded p-button-danger" />
      </template>
    </Column>
  </DataTable>
  </div>

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
import QrcodeVue from 'qrcode.vue'
import print from 'vue3-print-nb'

export default {
  components: {
    DataTable,
    Column,
    InputText,
    Button,
    Dialog,
    ConfirmDialog,
    QrcodeVue
  },
  directives: {
    print   
  },
  emits: ['deleteElement','change'],
  props: {
    table: String,
    name: String,
    delete: Function,
    saveSelected: Function,
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
    const filters = ref({
            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        });
    const isDialogOpen = ref(false);
    const selectedRows = ref([]);
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
          props.delete(id, props.info).then(() => { emit('deleteElement') }).catch((error)=>console.log(error))
          // store.dispatch('deleteEquipment',id);

        },
        reject: () => {
        }
      });
    }
    const confirmDeleteSelected = () => {
      confirm.require({
        message: 'Вы хотите удалить выбранные записи?',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        acceptClass: 'p-button-danger',
        accept: () => {
          let forSave = props.info.filter((item) => !selectedRows.value.some((remove) => remove.id === item.id));
          forSave = forSave.map((item) => {
            return item.id
          })
          props.saveSelected(forSave)
            .then(() => { emit('deleteElement') })
        },
        reject: () => {
        }
      });
    }
    const showInfo = (data) => {
      // router.push({ name: props.name + 'Info', params: { id: data.id } })
      if(props.name==='employee'||props.name==='placement'||props.name==='work'){
        emit('change',data.id)
      }
      else{
        router.push({ path:`/category/${props.name}/info/${data.id}`} )
      }
    }
    return {
      data,
      selectedRows,
      isDialogOpen,
      openDialog,
      confirmDeleteSelected,
      isEmpty,
      mtoColumns,
      showInfo,
      confirm2,
      isSelectedEmpty:computed(()=>{return selectedRows.value.length}),
      filters
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

@media print
{
   #printMe { display: table; text-align: justify; }

   .item {
    display:inline-block;
    margin-right: 1.2rem;
   }

   .column {
    display: block;
   }

   .align-items-center {
    display: table-cell;
    vertical-align: middle;
   }
}

@media screen
{
   #printMe { display: none; } 
}
</style>