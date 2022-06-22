<template>
<div class="absolute inset-0 test bg-white p-4">
    <div class="flex items-center">
      <Button icon="pi pi-arrow-left" @click="closeModal" class="p-button-rounded p-button-outlined mr-3" />
      <h1 class="text-2xl font-medium">Информация об оборудовании</h1>  
    </div>
    
     <div class="flex  flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Наименование МТО</label>
            </div>
            <div class="flex flex-col">
                <label htmlFor="type">Тип</label>
            </div>
     </div>
</div>
    <!-- <Dialog class="test" header="Информация" v-model:visible="isDialogOpen" :modal="true">
        <div class="flex h-96 flex-col ">
            <div class="flex flex-col mb-4">
                <label htmlFor="name">Наименование МТО</label>
            </div>
            <div class="flex flex-col">
                <label htmlFor="type">Тип</label>
            </div>
        </div>
        <template #footer>
            <Button label="Отмена" @click="closeModal" icon="pi pi-times" class="p-button-text" />
            <Button label="Сохранить" icon="pi pi-check" class="p-button-success" />
        </template>
    </Dialog> -->
</template>
<script>
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { setsColumns } from "@/assets/setsColumns";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import router from '@/router';
import { useRouter, useRoute } from 'vue-router'
export default {
    components: {
        Dialog,
        Button
    },
    props: {
        id: {
            default: 1
        }
    },
    setup(props) {
        const isDialogOpen = ref(true)
        const store = useStore();
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const info = computed(() => store.getters.GET_EQUIPMENT_BY_ID(props.id));
        console.log(props.id);
        return {
            isDialogOpen,
            closeModal
        }
    },
};
</script>
<style lang="scss">
button {
    background-color: rgb(143, 73, 73);
}

.test {
    width: 100%;
    height: 100%;
}
</style>
