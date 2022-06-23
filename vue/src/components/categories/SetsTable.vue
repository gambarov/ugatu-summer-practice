<template>
  <EquipmentTable :loading="loading" :columns="setsColumns" table="Комплекты" :info="info"/>
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
    const loading = ref(true);
    const info = ref();
    const store=useStore();
    store.dispatch('fetchSets').then(() => {
      loading.value = false;
      info.value = store.getters.GET_SETS;
    }
    ); 
    return{
        info,
        loading,
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
