<template>
  <EquipmentTable :columns="setsColumns" table="Комплекты" :data="info"/>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { setsColumns } from "@/assets/setsColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const store=useStore();
    const info=computed(()=>store.getters.GET_SETS);
    return{
        info,
        setsColumns
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
