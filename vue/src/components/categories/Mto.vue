<template>
  <EquipmentTable :columns="mtoColumns" table="Мто" :data="info"/>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { mtoColumns } from "@/assets/mtoColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const store=useStore();
    const info=computed(()=>store.getters.GET_EQUIPMENT); 
    return{
        info,
        mtoColumns
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
