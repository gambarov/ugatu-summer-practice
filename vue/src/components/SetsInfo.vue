<template>
    <Toast></Toast>
    <div class=" bg-white p-4">
        <div v-if="!loading" class="flex  flex-row ">
            <div class="mr-3 flex-auto">
                <div class="flex flex-col ">
                    <label htmlFor="name">Наименование комплекта</label>
                    <InputText type="text" v-model="data.name" />
                </div>
                <div class="flex flex-col mb-3">
                    <label htmlFor="name">Сотрудник</label>
                    <AutoComplete class="p-fluid bg-blue-500" v-model="selectedEmployee" :suggestions="filteredEmployee"
                        @complete="searchEmployee($event)" :dropdown="true" field="employeeInitials"
                        :forceSelection="true">
                        <template #item="slotProps">
                            <div class="flex flex-row justify-between">
                                <span class="ml-2"> {{ slotProps.item.employeeInitials }}</span>
                            </div>
                        </template>
                    </AutoComplete>
                </div>
                <div class="flex flex-col mb-3">
                    <label htmlFor="type">Инвентарный номер</label>
                    <InputText type="text" v-model="data.inventory_id" />
                </div>
                <Button label="Обновить данные" @click="updateSet" class="p-button-success" />
            </div>

            <div class="flex-auto">
                <SetCreation :creation="false" @save="update" :saveEquipment="saveNewEquipment" :equipment="equipment">
                </SetCreation>
                <EquipmentTable :saveSelected="saveNewEquipment" @deleteElement="update" :delete="deleteEqFromSet"
                    :loading="loading" name="mto" :columns="mtoColumns" table="МТО" :info="equipment" />
            </div>
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
import AutoComplete from 'primevue/autocomplete';
import { useToast } from "primevue/usetoast";
import { getSetsById, patchSet } from '@/assets/api/sets';
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import SetCreation from './modals/SetCreation.vue';
import { mtoColumns } from '@/assets/mtoColumns';
export default {
    components: {
        Dialog,
        Button,
        InputText,
        EquipmentTable,
        Toast,
        SetCreation,
        AutoComplete
    },
    props: {
        id: {
            default: 1
        }
    },
    setup(props) {
        onBeforeMount(()=>
        {
            store.dispatch('fetchEmployees').then(() => { employees = store.getters.GET_EMPLOYEES; });
        })
        const toast = useToast();
        const router = useRouter();
        const isDialogOpen = ref(true)
        const store = useStore();
        const data = ref({});
        const equipment = ref([]);
        const type = ref();
        const loading = ref(true);
        let employees;
        const selectedEmployee = ref();
        const filteredEmployee = ref();
        const searchEmployee = (event) => {
            if (!event.query.trim().length) {
                filteredEmployee.value = [...employees];
            }
            else {
                filteredEmployee.value = employees.filter((item) => {
                    if (item.name.toLowerCase().includes(event.query.toLowerCase()) || item.surname.toLowerCase().includes(event.query.toLowerCase()) || item.patronymic.toLowerCase().includes(event.query.toLowerCase())) {
                        return true;
                    }
                    return false;
                });
            }
        }
        const loadSet = () => {
            getSetsById(props.id).then((response) => {
                data.value = response.data.data;
                if (data.value.employee) {
                    data.value.employee.employeeInitials = data.value.employee.surname + " " + data.value.employee.name[0] + "." + data.value.employee.patronymic[0] + ".";
                }
                equipment.value = data.value.equipment;
                selectedEmployee.value=data.value.employee
                loading.value = false
            }).catch((error) => { console.log(error) })
        }
        loadSet();
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'sets' })
        }
        const updateSet = () => {
            patchSet(props.id, { 'name': data.value.name, 'inventory_id': data.value.inventory_id,'employee_id':selectedEmployee.value.id }).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            })
        }
        const showSuccess = () => {
            toast.add({ severity: 'success', summary: 'Изменения сохранены', life: 2000 });
        }
        const update = () => {
            loading.value = true;
            loadSet();
        }
        const deleteEqFromSet = (id, array) => {
            let equipmentIds = array.map((item) => {
                return item.id
            })
            equipmentIds = equipmentIds.filter((item) =>
                item !== id);
            return patchSet(props.id, { 'equipment': equipmentIds }).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            })
        }
        const saveNewEquipment = (forSave) => {
            return patchSet(props.id, { 'equipment': forSave }).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            })
        }
        return {
            isDialogOpen,
            closeModal,
            data, loading,
            equipment,
            type,
            mtoColumns,
            updateSet,
            deleteEqFromSet,
            update,
            saveNewEquipment,
            selectedEmployee,
            filteredEmployee,
            searchEmployee
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