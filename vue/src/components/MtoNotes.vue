<template>
    <Toast />
    <div class="">
        <div class="flex p-4 flex-row ">
            <div class="flex-auto">
                <Creation v-if="!loading" :creation="true" type="notes" :saveClass="addNew" @save="update"
                    @closed="openDialog" />
                <EquipmentTable @change="change" @deleteElement="update" :delete="deleteNote" :loading="loading"
                    name="work" :columns="notesColumns" table="Заметки" :info="info" />
                <Creation v-if="isDialogOpen" type="notes" @save="update" @closed="openDialog" :saveClass="changeNote"
                    :info="creationInfo" :isOpen="isDialogOpen" :creation="false" />
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

import { getNotes, deleteNote, postNote,patchNote } from '@/assets/api/notes';
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import Creation from './modals/Creation.vue';
import { notesColumns } from '@/assets/notesColumns';
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
        // onBeforeMount(() => {
        //     loading.value = true;
        //     store.dispatch('fetchEquipment');
        //     store.dispatch('fetchClasses').then(() => loading.value = false);
        // })
        const toast = useToast();
        const router = useRouter();
        const isDialogOpen = ref(false)
        const openDialog = (value) => {
            isDialogOpen.value = value;
        };
        const store = useStore();
        const creationInfo = ref();
        const data = ref({});
        const type = ref();
        const info = ref([]);
        const loading = ref(true);
        const update = () => {
            loading.value = true;
            getNotes().then((response) => {
                info.value = response.data.data
                loading.value = false;
            });
        }
        update();
        const change = (id) => {
            creationInfo.value = info.value.find((item) => item.id === id);
            openDialog(true)
        }
        const addNew = (note) => {
            return postNote({
                'text':note.text,
                'equipment_id':props.id,
                'employee_id':store.getters.GET_USER_ID
                }).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            });
        }
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const changeNote = (note) => {
            return patchNote(note.id, {
                'text':note.text,
            }).then(() => showSuccess()).catch(() => {
                toast.add({ severity: 'error', summary: 'Ошибка', life: 3000 });
            });
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
            notesColumns,
            update,
            addNew,
            change,
            changeNote,
            creationInfo,
            openDialog,deleteNote,patchNote
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
