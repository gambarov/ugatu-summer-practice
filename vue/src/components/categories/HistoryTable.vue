<template>
  <EquipmentTable :columns="placementColumns" table="Аудитории" :data="info"/>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { placementColumns } from "@/assets/placementColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const store=useStore();
    const info=[];
    return{
        info,
        placementColumns
    }
  },
};
</script>

