<template>
    <Toast />
    <div class="absolute inset-0 h-fit bg-white p-4">
        <div class="flex items-center mb-3">
            <Button icon="pi pi-arrow-left" @click="closeModal" class="p-button-rounded p-button-outlined mr-3" />
            <h1 class="text-2xl font-medium">Информация об оборудовании</h1>
        </div>
        <div v-if="!loading" class="flex  flex-row ">
            <div class="mr-3 flex-auto">
                <div class="flex flex-col ">
                    <label htmlFor="name">Наименование МТО</label>
                    <InputText type="text" v-model="data.name" />
                </div>
                <div class="flex flex-col">
                    <label htmlFor="type">Тип</label>
                    <InputText type="text" v-model="type" />
                </div>
                <div class="flex flex-col mb-3">
                    <label htmlFor="type">Идентификатор</label>
                    <InputText type="text" v-model="data.inventory_id" />
                </div>
                <Button label="Обновить данные" @click="updateEquipment" class="p-button-success" />
            </div>
            <div class="flex-auto">
                <EquipmentTable :loading="loading" name="sets" :columns="setsColumns" table="Комплекты" :info="sets" />
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
import { useToast } from "primevue/usetoast";
import { getEquipmentById, patchEquipment } from '@/assets/api/equipment'
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import { setsColumns } from '@/assets/setsColumns';
export default {
    components: {
        Dialog,
        Button,
        InputText,
        EquipmentTable,
        Toast
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
        const sets = ref([]);
        const type = ref();
        const loading = ref(true)
        getEquipmentById(props.id).then((response) => {
            data.value = response.data.data;
            if (response.data.data.sets != null) {
                sets.value = response.data.data.sets
                sets.value = sets.value.map((set) => {
                if(set.employee!=null){
                    set.employeeInitials = set.employee.surname + " " + set.employee.name[0] + "." + set.employee.patronymic[0] + ".";
                }
                    return set;
                })
            }
            type.value = response.data.data.equipment_type.name
        })
            .then(loading.value = false).catch((error) => { console.log(error) })
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const updateEquipment = () => {
            patchEquipment(props.id, data.value).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            })
        }
        const showSuccess = () => {
            toast.add({ severity: 'success', summary: 'Изменения сохранены', life: 2000 });
        }
        return {
            isDialogOpen,
            closeModal,
            data, loading,
            sets,
            type,
            setsColumns,
            hasSets: computed(() => { return sets.value.length }),
            updateEquipment
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
