<template>
    <Toast />
    <div class="absolute p-4 inset-0 h-fit bg-white ">
        <div class="flex items-center mb-3">
            <Button icon="pi pi-arrow-left" @click="closeModal" class="p-button-rounded p-button-outlined mr-3" />
            <h1 class="text-2xl font-medium">Информация об оборудовании</h1>
        </div>
        <div class=" bg-white p-4">
            <div class="flex  flex-row ">
                <div class="mr-3 flex-auto">
                    <div class="flex flex-col ">
                        <label htmlFor="name">Корпус</label>
                        <InputText type="text" v-model="data.building" />
                    </div>
                    <div class="flex flex-col">
                        <label htmlFor="type">Номер</label>
                        <InputText type="text" v-model="data.number" />
                    </div>
                    <div class="flex flex-col mb-3">
                        <label htmlFor="type">Литер</label>
                        <InputText type="text" v-model="data.letter" />
                    </div>
                    <div class="flex flex-col mb-3">
                        <label htmlFor="type">Тип</label>
                        <AutoComplete class="p-fluid bg-blue-500" v-model="selectedEquipment"
                            :suggestions="filteredEquipment" @complete="searchEquipment($event)" :dropdown="true"
                            field="name" :forceSelection="true">
                            <template #item="slotProps">
                                <div class="flex flex-row justify-between">
                                    <span class="ml-2"> {{ slotProps.item.name }}</span>
                                    <span>{{ slotProps.item.inventory_id }}</span>
                                </div>
                            </template>
                        </AutoComplete>
                    </div>
                    <Button label="Обновить данные" @click="updateClass" class="p-button-success" />
                </div>
            </div>
        </div>
        <div class="flex-auto">
            <EquipmentTable :loading="loading" name="sets" :columns="mtoColumns" table="МТО" :info="data.equipment" />
        </div>
    </div>
</template>
<script>
import { useStore } from 'vuex'
import { ref, computed, onBeforeMount } from "vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Toast from 'primevue/toast';
import TabMenu from 'primevue/tabmenu';
import Dropdown from 'primevue/dropdown';
import AutoComplete from 'primevue/autocomplete';
import { useToast } from "primevue/usetoast";
import { getClassById, patchClass } from '@/assets/api/classes'
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import { mtoColumns } from '@/assets/mtoColumns';
export default {
    components: {
        Dialog,
        Button,
        InputText,
        EquipmentTable,
        Toast,
        TabMenu,
        Dropdown,
        AutoComplete
    },
    props: {
        id: {
            default: 1
        }
    },
    setup(props) {
        const toast = useToast();
        const router = useRouter();
        const isDialogOpen = ref(true)
        const store = useStore();
        const data = ref({});
        const type = ref();
        const loading = ref(true);
        const selectedEquipment = ref();
        const filteredEquipment=ref();
        const types = ref([]);
        getClassById(props.id).then((response) => {
            data.value = response.data.data;
            selectedEquipment.value=data.value.audience_type
            // if (response.data.data.sets != null) {
            //     sets.value = response.data.data.sets
            //     sets.value = sets.value.map((set) => {
            //     if(set.employee!=null){
            //         set.employeeInitials = set.employee.surname + " " + set.employee.name[0] + "." + set.employee.patronymic[0] + ".";
            //     }
            //         return set;
            //     })
            // }
            // type.value = response.data.data.equipment_type.name
        }).then(() => {
            store.dispatch('fetchClasses').then(() => {
                types.value = store.getters.GET_CLASSES_TYPES
            })
        }).then(loading.value = false).catch((error) => { console.log(error) })
        const searchEquipment = (event) => {
            if (!event.query.trim().length) {
                filteredEquipment.value = [...types.value];
            }
            else {
                filteredEquipment.value = types.value.filter((item) => {
                    if (item.name.toLowerCase().includes(event.query.toLowerCase()) || item.inventory_id.toLowerCase().includes(event.query.toLowerCase())) {
                        return true;
                    }
                    return false;
                });
            }
        }
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'classes' })
        }
        const updateClass = () => {
            patchClass(props.id, {
                audience_type_id: selectedEquipment.value.id,
                building: data.value.building,
                letter: data.value.letter,
                number: data.value.number
            }).then(() => showSuccess()).catch((error) => {
                toast.add({ severity: 'error', summary: error.response.data.error.message, life: 3000 });
            })
        }
        const showSuccess = () => {
            toast.add({ severity: 'success', summary: 'Изменения сохранены', life: 2000 });
        }
        return {
            isDialogOpen,
            closeModal,
            data, loading,
            type,
            mtoColumns,
            updateClass,
            types,
            searchEquipment,
            selectedEquipment,
            filteredEquipment
        }
    },
};
</script>
<style lang="scss">
button {
    background-color: rgb(143, 73, 73);
}

.test {
    box-shadow: 12px 12px 2px 1px rgba(0, 0, 255, .2);

}

.a {
    margin-bottom: 10px;
}
</style>
