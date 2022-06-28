<template>
    <div class="absolute p-4 inset-0 h-fit bg-white ">
        <div class="flex items-center mb-3">
            <Button icon="pi pi-arrow-left" @click="closeModal" class="p-button-rounded p-button-outlined mr-3" />
            <h1 class="text-2xl font-medium">Информация об оборудовании</h1>
        </div>
        <TabMenu :model="items" v-model:activeIndex="active"/>
        <router-view class="" name="tabs"></router-view>
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
        TabMenu
    },
    props: {
        id: {
            default: 1
        }
    },
    setup(props) {
        const router = useRouter();
        const active=ref(0);
        active.value=0;
        const items = ref([
            {
                label: 'Информация',
                icon: 'pi pi-fw pi-home',
                 command: () => { router.push({ path: `/category/mto/info/${props.id}` }) }
            },
            {
                label: 'Размещение',
                icon: 'pi pi-fw pi-calendar',
                command: () => { router.push({ path: `/category/mto/info/${props.id}/placements` }) }
            },
            {
                label: 'Работы',
                icon: 'pi pi-fw pi-briefcase',
                command: () => { router.push({ path: `/category/mto/info/${props.id}/works` }) }
            },
             {
                label: 'Характеристики',
                icon: 'pi pi-fw pi-cog',
                command: () => { router.push({ path: `/category/mto/info/${props.id}/specs` }) }
            },
        ]);
        const closeModal = () => {
            router.push({ name: 'mto' })
        }
        return {
            closeModal,
            items,
            active
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
