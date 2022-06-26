<template>
    <Toolbar class="mb-3">
        <template #start>
            <Button label="Добавить" icon="pi pi-plus" class="p-button bg-blue-400 mr-3" @click="openDialog(true)" />
        </template>
    </Toolbar>
    <Dialog class="" header="Добавить комплект" v-model:visible="isDialogOpen" :modal="true">
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
    emits: ['save'],
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
    },
    setup(props, { emit }) {
        onMounted(() => {
            store.dispatch('fetchEquipment')
        })
        const store = useStore();
        // const selectedEquipment = ref(props.equipment);
        // const filteredEquipment = ref();

        // const equipment = store.getters.GET_EQUIPMENT;
        const isDialogOpen = ref(false);
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        const newEquipment = ref({
            name: '',
            building: '',
            letter: ''
        })
        // const searchEquipment = (event) => {
        //     if (!event.query.trim().length) {
        //         filteredEquipment.value = [...equipment];
        //     }
        //     else {
        //         filteredEquipment.value = equipment.filter((item) => {
        //             return item.name.toLowerCase().includes(event.query.toLowerCase());
        //         });
        //     }
        // }
        const addNew = () => {
            let flag = 1;
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
                default:
                    break;
            }
        };
        return {
            setsColumns,
            newEquipment, isDialogOpen, openDialog,
            deleteSet,
            equipment: computed(() => store.getters.GET_EQUIPMENT),
            // searchEquipment,
            // filteredEquipment,
            // selectedEquipment,
            addNew,
            isCreation: computed(() => props.creation),
            isClass: computed(() => props.type === 'class'),
            isEmployee: computed(() => props.type === 'employee')
        }
    }
}
</script>