<template>
  <TabView>
	<TabPanel header="Header I">
		<EquipmentTable/>
	</TabPanel>
	<TabPanel header="Header II">
		Content II
	</TabPanel>
	<TabPanel header="Header III">
		Content III
	</TabPanel>
</TabView>
</template>

<script>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import EquipmentTable from "./EquipmentTable.vue";
export default {
    components:{
        TabView,
        TabPanel,
        EquipmentTable
    }
}
</script>

<style>

</style>