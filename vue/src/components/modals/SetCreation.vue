<template>
    <Toolbar class="mb-3">
      <template #start>
        <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
      </template>
    </Toolbar>
    <Dialog class="" header="Добавить комплект" v-model:visible="isDialogOpen" :modal="true">
        <div class="flex ty flex-col p-dialog-content">
            <div v-if="isCreation" class="flex flex-col mb-4">
                <label htmlFor="name">Наименование комплекта</label>
                <InputText id="name" v-model="newEquipment.name" required />
            </div>
            <div v-if="isCreation" class="flex flex-col mb-4">
                <label htmlFor="name">Инвентарный номер</label>
                <InputText id="name" v-model="newEquipment.inventory_id" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Оборудование</label>
                <AutoComplete class="p-fluid bg-blue-500" :multiple="true" v-model="selectedEquipment"
                    :suggestions="filteredEquipment" @complete="searchEquipment($event)" :dropdown="true" field="name"
                    :forceSelection="true">
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
import { ref, onMounted, computed } from "vue";
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
    emits: ['save'],
    props:{
        equipment:{
            default:[]
        },
        saveEquipment:Function,
        creation:{
            default:true,
        }
    },
    setup(props,{emit}) {
        onMounted(() => {
            store.dispatch('fetchEquipment')
        })
        const selectedEquipment = ref(props.equipment);
        const filteredEquipment = ref();
        const store = useStore();
        const equipment = store.getters.GET_EQUIPMENT;
        const isDialogOpen = ref(false);
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        const newEquipment = ref({
            name: ''
        })
        const searchEquipment = (event) => {
            if (!event.query.trim().length) {
                filteredEquipment.value = [...equipment];
            }
            else {
                filteredEquipment.value = equipment.filter((item) => {
                    if(item.name.toLowerCase().includes(event.query.toLowerCase())||item.inventory_id.toLowerCase().includes(event.query.toLowerCase())){
                        return true;
                    }
                    return false;
                });
            }
        }
        const addNewSet = () => {
            if (newEquipment.value.name != ''||props.creation===false) {
                const equipmentIds = selectedEquipment.value.map((eq) => {
                    return eq.id;
                })
                props.saveEquipment(equipmentIds,newEquipment.value).then(()=>emit('save'));
                // postSet({
                //     "name": newEquipment.value.name,
                //     "equipment": equipmentIds
                // }).then(() => {
                //     loading.value = true;
                //     store.dispatch('fetchSets').then(() => {
                //         loading.value = false;
                //         info.value = store.getters.GET_SETS;
                //     })
                // })
                isDialogOpen.value = false;
            }
        };
        return {
            setsColumns,
            newEquipment, isDialogOpen, openDialog,
            deleteSet,
            equipment: computed(() => store.getters.GET_EQUIPMENT),
            searchEquipment,
            filteredEquipment,
            selectedEquipment,
            addNewSet,
            isCreation:computed(()=>props.creation)
            
        }
    }
}
</script>