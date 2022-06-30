<template>
    <div>
    <Toast />
    <div class=" bg-white p-4">
        <div class="flex  flex-row ">
            <div class="mr-3 flex-auto">
                
                <div class="flex flex-col ">
                    <label htmlFor="name">Наименование МТО</label>
                    <InputText type="text" v-model="data.name" />
                </div>
                <div class="flex flex-col">
                    <label htmlFor="type">Тип</label>
                    <AutoComplete class="p-fluid bg-blue-500" v-model="selectedType" :suggestions="filteredType"
                        @complete="searchType($event)" :dropdown="true" field="name" :forceSelection="true">
                        <template #item="slotProps">
                            <div class="flex flex-row justify-between">
                                <span class="ml-2"> {{ slotProps.item.name }}</span>
                            </div>
                        </template>
                    </AutoComplete>
                </div>
                <div class="flex flex-col mb-3">
                    <label htmlFor="type">Идентификатор</label>
                    <InputText type="text" v-model="data.inventory_id" />
                </div>
                <Button label="Обновить данные" @click="updateEquipment" class="p-button bg-blue-500" />
            </div>
            <div class="flex-auto">
                <EquipmentTable :loading="loading" name="sets" :columns="setsColumns" table="Комплекты" :info="sets" />
            </div>
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
import TabMenu from 'primevue/tabmenu';
import AutoComplete from 'primevue/autocomplete';
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
        Toast,
        TabMenu,
        AutoComplete,
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
        const selectedType = ref();
        const filteredType = ref();
        const types = ref([]);
        const type = ref();
        const loading = ref(true);
        const items = ref([
            {
                label: 'Home',
                icon: 'pi pi-fw pi-home',
                to: '/'
            },
            {
                label: 'Calendar',
                icon: 'pi pi-fw pi-calendar',
                command: () => { router.push({ path: `/category/mto/info/${props.id}/placements` }) }
            },
        ]);
        getEquipmentById(props.id).then((response) => {
            data.value = response.data.data;
            if (response.data.data.sets != null) {
                sets.value = response.data.data.sets
                sets.value = sets.value.map((set) => {
                    if (set.employee != null) {
                        set.employeeInitials = set.employee.surname + " " + set.employee.name[0] + "." + set.employee.patronymic[0] + ".";
                    }
                    return set;
                })
            }
            selectedType.value=data.value.equipment_type
        }).then(()=>{
            store.dispatch('fetchEquipment').then(()=>{
                types.value=store.getters.GET_EQUIPMENT_TYPES;
            })
        })
            .then(loading.value = false).catch((error) => { console.log(error) })
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const updateEquipment = () => {
            patchEquipment(props.id, {
                equipment_type_id: selectedType.value.id,
                inventory_id: data.value.inventory_id,
                name: data.value.name,
            }).then(() => showSuccess()).catch((error) => {
                toast.add({ severity: 'error', summary: error.response.data.error.message, life: 3000 });
            })
        }
        const showSuccess = () => {
            toast.add({ severity: 'success', summary: 'Изменения сохранены', life: 2000 });
        }
        const searchType = (event) => {
      if (!event.query.trim().length) {
        filteredType.value = [...types.value];
      }
      else {
        filteredType.value = types.value.filter((item) => {
          if (item.name.toLowerCase().includes(event.query.toLowerCase())) {
            return true;
          }
          return false;
        });
      }
    }
        return {
            value: 'https://example.com',
            size: 300,
            isDialogOpen,
            closeModal,
            data, loading,
            sets,
            type,
            setsColumns,
            hasSets: computed(() => { return sets.value.length }),
            updateEquipment,
            items,
            searchType,
            selectedType,
            filteredType,
            types
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
