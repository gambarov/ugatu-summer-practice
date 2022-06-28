<template>
    <Toast />
    <div class="">
        <div class="flex p-4 flex-row ">
            <div class="flex-auto">
                <Creation v-if="!loading" type="placement" :saveClass="addNew" @save="update" @closed="openDialog"
                     />
                <EquipmentTable @change="change" @deleteElement="update" :delete="deletePlacement" :loading="loading"
                    name="placement" :columns="placementColumns" table="Размещение" :info="info" />
                <Creation v-if="isDialogOpen" type="placement" @save="update" @closed="openDialog"
                    :saveClass="changePlacement" :info="creationInfo" :isOpen="isDialogOpen" :creation="false" :equipment="creationInfo.audience"/>
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
import { postPlacement, getPlacementsEquipment, deletePlacement, patchPlacement } from '@/assets/api/placements';
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
        onBeforeMount(() => {
            loading.value = true;
            store.dispatch('fetchEquipment');
            store.dispatch('fetchClasses').then(()=>loading.value = false);
        })
        const toast = useToast();
        const router = useRouter();
        const isDialogOpen = ref(false)
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        const store = useStore();
        const creationInfo=ref();
        const data = ref({});
        const type = ref();
        const info = ref([]);
        const loading = ref(true);
        const update = () => {
            loading.value = true;
            getPlacementsEquipment(props.id).then((response) => {
                info.value = response.data.data.map((item) => {
                    item.audience.name = item.audience.building + "-" + item.audience.number;
                    item.audience.name+= item.audience.letter ? item.audience.letter : '';
                    item.time = item.placed_at + ' - ';
                    item.time += item.removed_at ? item.removed_at : '';
                    return item;
                })
                loading.value = false;
            });
        }
        update();
        const change = (id) => {
            creationInfo.value = info.value.find((item) => item.id === id);
            openDialog(true)
        }
        const addNew = (info,placement) => {
            
            return postPlacement({
                'equipment_id': props.id,
                "audience_id": placement.id
            });
        }
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const changePlacement = (placement,audience) => {
            return patchPlacement(placement.id,{
                "audience_id": audience.id,
                "removed_at":placement.removed_at,
                "placed_at":placement.placed_at,
            }).then(() => showSuccess()).catch(() => {
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
            info,
            type,
            placementColumns,
            hasSets: computed(() => { return sets.value.length }),
            changePlacement,
            update,
            addNew,
            deletePlacement,
            change,
            creationInfo,
            openDialog
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
