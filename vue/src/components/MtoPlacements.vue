<template>
    <Toast />

    <div class="">
        <div  class="flex p-4 flex-row ">
            <!-- <div class="mr-3 flex-auto">
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
            </div> -->
            <div class="flex-auto">
                <Creation type="placement" :saveClass="addNew" @save="update" />
                <EquipmentTable :loading="loading" name="sets" :columns="placementColumns" table="Размещение"
                    :info="sets" />
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
import { postPlacement } from '@/assets/api/placements';
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import Creation from './modals/Creation.vue';
import { placementColumns } from '@/assets/placementColumns';
export default {
    components: {
        Dialog,
        Button,
        InputText,
        EquipmentTable,
        Toast,
        Creation
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
        const update = () => {
            loading.value = true;
            store.dispatch('fetchClasses').then(() => {
                loading.value = false;
                info.value = store.getters.GET_CLASSES;
            });
        }
        update();
        const addNew = (placement) => {
            return postPlacement({
                'equipment_id': props.id,
                "audience_id": placement.id
            });
        }
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
            placementColumns,
            hasSets: computed(() => { return sets.value.length }),
            updateEquipment,
            update,
            addNew
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
