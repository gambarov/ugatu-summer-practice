<template>
    <div class="absolute inset-0 h-fit bg-white p-4">
        <div class="flex items-center mb-3">
            <Button icon="pi pi-arrow-left" @click="closeModal" class="p-button-rounded p-button-outlined mr-3" />
            <h1 class="text-2xl font-medium">Информация об оборудовании</h1>
        </div>

        <div v-if="!loading" class="flex  flex-col ">
            <div class="mr-3">
                <div class="flex flex-col ">
                    <label htmlFor="name">Наименование МТО</label>
                    <InputText type="text" v-model="data.name" disabled />
                </div>
                <div class="flex flex-col">
                    <label htmlFor="type">Тип</label>
                    <InputText type="text" v-model="type" disabled />
                </div>
                <div class="flex flex-col">
                    <label htmlFor="type">Идентификатор</label>
                    <InputText type="text" v-model="data.inventory_id" disabled />
                </div>
            </div>

            <div>
                <span class="text-xl leading-10">Комплекты</span>
                <div v-if="hasSets" class="flex flex-row overflow-auto">
                    <div class="rounded p-4 border-slate-500 shadow-md border mb-4  mr-3" v-for="set in sets">
                        <div class="flex flex-col">
                            <label htmlFor="type">Название</label>
                            <InputText type="text" :value="set.name" disabled />
                        </div>
                        <div class="flex flex-col">
                            <label htmlFor="type">Сотрудник</label>
                            <InputText type="text"
                                :value="set.employee.surname + ' ' + set.employee.name[0] + '. ' + set.employee.patronymic[0] + '.'"
                                disabled />
                        </div>
                    </div>
                </div>
                <h1 v-if="!hasSets">Нет комплектов</h1>
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
import { getEquipmentById } from '@/assets/api/equipment'
import { useRouter, useRoute } from 'vue-router'
export default {
    components: {
        Dialog,
        Button,
        InputText
    },
    props: {
        id: {
            default: 1
        }
    },
    setup(props) {
        // onBeforeMount(() => {
        //     getEquipmentById(props.id).then((response) => data.value=response.data.data).then(loading.value=false).catch((error) => { console.log(error) })
        // })
        const router = useRouter();
        const isDialogOpen = ref(true)
        const store = useStore();
        const data = ref({});
        const sets = ref([]);
        const type=ref();
        const loading = ref(true)
        getEquipmentById(props.id).then((response) => {
            data.value = response.data.data;
            sets.value = response.data.data.sets
            type.value = response.data.data.equipment_type.name
        })
            .then(loading.value = false).catch((error) => { console.log(error) })
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        return {
            isDialogOpen,
            closeModal,
            data, loading,
            sets,
            type,
            hasSets:computed(()=>{return sets.value.length})
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
.a{
    margin-bottom: 10px;
}
</style>
