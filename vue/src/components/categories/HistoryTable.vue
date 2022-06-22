<template>
  <EquipmentTable :columns="historyColumns" table="Аудитории" :data="info"/>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { historyColumns } from "@/assets/historyColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const store=useStore();
    const info=[];
    return{
        info,
        historyColumns
    }
  },
};
</script>

