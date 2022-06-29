<template>
    <Toast />
    <div class="flex p-4 flex-row ">
        <div class="flex-auto">
            <Creation type="work" :saveClass="addNew" @save="update" v-if="!loading" @closed="openDialog" />
            <EquipmentTable @change="change" @deleteElement="update" :delete="deleteWork" :loading="loading" name="work"
                :columns="worksColumns" table="Работы" :info="info" />
            <Creation v-if="isDialogOpen" type="work" @save="update" @closed="openDialog" :saveClass="changeWork"
                :info="creationInfo" :isOpen="isDialogOpen" :creation="false" :equipment="creationInfo.work_type"
                :status="creationInfo.work_status" :employee="creationInfo.employee"/>
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
import { postWork, getWorks, deleteWork,patchWork } from '@/assets/api/works';
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import Creation from './modals/Creation.vue';
import { worksColumns } from '@/assets/worksColumns';
import equipment from '@/store/equipment';
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
        const route = useRoute();
        const isDialogOpen = ref(false)
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        const store = useStore();
        const info = ref([]);
        const type = ref();
        const loading = ref(true)
        const creationInfo = ref();
        let category='';
        if(route.fullPath.includes('mto')){
            category='equipment'
        }
        else category='set'
        const update = () => {
            loading.value = true;
            getWorks(props.id, category).then((response) => {
                info.value = response.data.data.map((item) => {
                    item.time = item.started_at + ' - ';
                    item.time += item.ended_at ? item.ended_at : '';
                    if (item.employee.surname != null && item.employee.patronymic != null && item.employee.name != null) {
                        item.employee.employeeInitials = item.employee.surname + " " + item.employee.name[0] + "." + item.employee.patronymic[0] + ".";
                    }
                    return item;
                })
                loading.value = false;
            });
            // store.dispatch('fetchTypes');
        }
        update();
        const change = (id) => {
            creationInfo.value = info.value.find((item) => item.id === id);
            openDialog(true)
        }
        const addNew = (status, type) => {

            return postWork({
                "workable_id": props.id,
                "workable_type": category,
                "work_type_id": type.id,
                "work_status_id": status.id,
                "employee_id": store.getters.GET_USER_ID

            });
        }
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const changeWork = (status, type,employee, work) => {
            let body = {
                "employee_id": employee.id,
                "started_at": work.started_at,
                "work_type_id": type.id,
                "work_status_id": status.id,
                "workable_type":category
            }
            if (work.ended_at != null) {
                body.ended_at = work.ended_at
            }
            return patchWork(work.id, body).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: error.response.data.error.message, life: 3000 });
            })
        }
        const showSuccess = () => {
            toast.add({ severity: 'success', summary: 'Изменения сохранены', life: 2000 });
        }
        return {
            isDialogOpen,
            openDialog,
            info, loading,
            type,
            worksColumns,
            // updateEquipment,
            update,
            addNew,
            deleteWork,
            changeWork,
            change,
            creationInfo
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
