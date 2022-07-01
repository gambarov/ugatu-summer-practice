<template>
    <Toast />
    <div class="">
        <div class="flex p-4 flex-row ">
            <div class="flex-auto">
                <Creation v-if="!loading" :creation="true" type="specs" :saveClass="addNew" @save="update" @closed="openDialog" />
                <EquipmentTable @change="change" @deleteElement="update" :delete="deletePlacement" :loading="loading"
                    name="placement" :columns="specsColumns" table="Характеристики" :info="info" />
                <Creation v-if="isDialogOpen" type="specs" @save="update" @closed="openDialog"
                    :saveClass="changeSpec" :info="creationInfo" :isOpen="isDialogOpen" :creation="false" :equipment="creationInfo.audience"/>
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
import { getSpecsByEquipment,postSpec} from '@/assets/api/specs';
import { patchEquipment } from '@/assets/api/equipment';
import { useRouter, useRoute } from 'vue-router'
import EquipmentTable from './EquipmentTable.vue';
import Creation from './modals/Creation.vue';
import { specsColumns } from '../assets/specsColumns.js'
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
            store.dispatch('fetchClasses').then(() => loading.value = false);
        })
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
            getSpecsByEquipment(props.id).then((response) => {
                // info.value = response.data.data.map((item) => {
                //     item.audience.name = item.audience.building + "-" + item.audience.number;
                //     item.audience.name+= item.audience.letter ? item.audience.letter : '';
                //     item.time = item.placed_at + ' - ';
                //     item.time += item.removed_at ? item.removed_at : '';
                //     return item;
                // })
                info.value = response.data.data
                loading.value = false;
            });
        }
        update();
        const change = (id) => {
            creationInfo.value = info.value.find((item) => item.id === id);
            openDialog(true)
        }
        const addNew = (infoSpec,measure,group,creation) => {
            if(creation===true){
               return postSpec({
                'name':infoSpec.name,
                'char_group_id': group.id,
                "char_measure_id": measure.id
            }); 
            }
            else{
                let temp={};
               let body=info.value.map((item)=>{
                temp[item.char.id]={
                    'value':item.value
                }
                    return {
                        [item.char.id]:{
                            'value':item.value
                        },
                    }
                });
                // body.push({
                //    [measure.id]:{
                //         'value':infoSpec.value
                //     } 
                // });
                temp[measure.id]={
                    'value':infoSpec.value
                }
                console.log(temp);
               return patchEquipment(props.id,{
                'chars':[temp],
            });  
            }
            
        }
        const closeModal = () => {
            isDialogOpen.value = false;
            router.push({ name: 'mto' })
        }
        const changeSpec = (spec) => {
            let temp={};
               let body=info.value.map((item)=>{
                temp[item.char.id]={
                    'value':item.value
                }
                    return {
                        [item.char.id]:{
                            'value':item.value
                        },
                    }
                });
                temp[spec.char.id]={
                    'value':spec.value
                }
            return patchEquipment(props.id,{
                'chars':[temp],
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
            specsColumns,
            update,
            addNew,
            change,
            changeSpec,
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
