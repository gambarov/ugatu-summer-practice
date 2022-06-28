<template>
    <Toolbar class="mb-3">
        <template #start>
            <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
        </template>
    </Toolbar>
    <Dialog  @after-hide="close" class="" header="Добавить запись" v-model:visible="isDialogOpen" :modal="true">
        <div v-if="isClass" class="flex flex-col ">
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
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Тип</label>
                <InputText id="name" v-model="newEquipment.audience_type" required />
            </div>
        </div>
        <div v-if="isEmployee" class="flex flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Имя</label>
                <InputText id="name" v-model="newEquipment.name" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Фамилия</label>
                <InputText id="name" v-model="newEquipment.surname" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Отчество</label>
                <InputText id="name" v-model="newEquipment.patronymic" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Почта</label>
                <InputText id="name" v-model="newEquipment.email" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Пароль</label>
                <InputText id="name" v-model="newEquipment.password" required />
            </div>
        </div>
        <div v-if="isPlacement" class="flex flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Класс</label>
                <AutoComplete class="p-fluid bg-blue-500" v-model="selectedEquipment" :suggestions="filteredEquipment"
                    @complete="searchEquipment($event)" :dropdown="true" field="name" :forceSelection="true">
                    <template #item="slotProps">
                        <div class="flex flex-row justify-between">
                            <span class="ml-2"> {{ slotProps.item.name }}</span>
                            <span>{{ slotProps.item.inventory_id }}</span>
                        </div>
                    </template>
                </AutoComplete>
            </div>
            <div v-if="!isCreation" class="flex flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">От</label>
                <InputText id="name" v-model="newEquipment.placed_at" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">До</label>
                <InputText id="name" v-model="newEquipment.removed_at" required />
            </div>
        </div>
        </div>
        <div v-if="isWork" class="flex flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Тип работ</label>
                <InputText id="name" v-model="newEquipment.work_type" required />
            </div>
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Статус работ</label>
                <InputText id="name" v-model="newEquipment.work_status" required />
            </div>
        </div>
        <template #footer>
            <Button label="Отмена" icon="pi pi-times" @click="openDialog(false)" class="p-button-text" />
            <Button label="Сохранить" icon="pi pi-check" @click="addNew" class="p-button-success" />
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
    emits: ['save','closed'],
    props: {
        equipment: {
            default: []
        },
        saveClass: Function,
        creation: {
            default: true,
        },
        type: {
            default: 'default',
        },
        info: {
            default: {}
        },
        isOpen:{
            default:false
        }
    },
    setup(props, { emit }) {
        onMounted(() => {

            switch (props.type) {
            case 'class':
                store.dispatch('fetchEquipment').then(()=>{equipment = store.getters.GET_EQUIPMENT});
                break;
            case 'placement':
                store.dispatch('fetchClasses').then(()=>{equipment = store.getters.GET_CLASSES});
                break;
        }
            // store.dispatch('fetchEquipment').then(()=>{equipment = store.getters.GET_EQUIPMENT});
            // store.dispatch('fetchClasses');
        })
        const store = useStore();
        const selectedEquipment = ref(props.equipment);
        const filteredEquipment = ref();
        let equipment;
        const isDialogOpen = ref(false);
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        if(props.isOpen){
            openDialog(true);
        }
        const close=()=>{
            emit('closed',false)
        }
        const newEquipment = ref(props.info)
        const searchEquipment = (event) => {
            if (!event.query.trim().length) {
                filteredEquipment.value = [...equipment];
                console.log(equipment)
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
        const addNew = () => {
            switch (props.type) {
                case 'employee':
                    props.saveClass(newEquipment.value).then(() => emit('save'));
                    isDialogOpen.value = false;
                    break;
                case 'class':
                    if (newEquipment.value.building != '' && newEquipment.value.number != '' || props.creation === false) {
                        // const equipmentIds = selectedEquipment.value.map((eq) => {
                        //     return eq.id;
                        // })
                        props.saveClass(newEquipment.value).then(() => emit('save'));
                        isDialogOpen.value = false;
                    }
                    break;
                case 'placement':
                    if (selectedEquipment.value != null || props.creation === false) {
                        props.saveClass(newEquipment.value,selectedEquipment.value).then(() => emit('save'));
                        isDialogOpen.value = false;
                    }
                    break;
                default:
                    break;
            }
        };
        return {
            setsColumns,
            newEquipment, isDialogOpen, openDialog,
            deleteSet,
            equipment,
            searchEquipment,
            filteredEquipment,
            selectedEquipment,
            addNew,
            isCreation: computed(() => props.creation),
            isClass: computed(() => props.type === 'class'),
            isEmployee: computed(() => props.type === 'employee'),
            isPlacement: computed(() => props.type === 'placement'),
            isWork: computed(() => props.type === 'work'),
            close
        }
    }
}
</script>