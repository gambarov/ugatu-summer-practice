<template>
  <EquipmentTable :columns="classesColumns" table="Аудитории" :data="info"/>
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed } from "vue";
import { classesColumns } from "@/assets/classesColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const store=useStore();
    const info=[];
    return{
        info,
        classesColumns
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
