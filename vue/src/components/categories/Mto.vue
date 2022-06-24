<template>
  <EquipmentTable :loading="loading" :columns="mtoColumns" table="Мто" :info="info" />
</template>
<script>
import EquipmentTable from "../EquipmentTable.vue";
import { useStore } from 'vuex'
import { ref, computed, onMounted } from "vue";
import { mtoColumns } from "@/assets/mtoColumns";
export default {
  components: {
    EquipmentTable,
  },
  setup() {
    const loading = ref(true);
    const store = useStore();
    const info = ref();
    store.dispatch('fetchEquipment').then(() => {
      loading.value = false;
      info.value = store.getters.GET_EQUIPMENT;
    }
    ); 
    return {
      info,
      mtoColumns,
      loading
    }
  },
};
</script>
<style lang="scss">
button {
  background-color: rgb(143, 73, 73);
}
</style>
