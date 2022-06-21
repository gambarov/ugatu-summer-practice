export default {
    state: {
        equipment:[]
    },
    getters: {
    },
    mutations: {
        SET_EQUIPMENT(state,payload){
            state.equipment=payload;
        },
        DELETE_EQUIPMENT(state,payload){
            state.equipment= state.equipment.filter(item=>item.id!==payload.id);
        },
    },
    actions: {
        fetchEquipment(context,payload){
            context.commmit('SET_EQUIPMENT',payload)
        },
        deleteEquipment(context,payload){
            context.commmit('DELETE_EQUIPMENT',payload)
        }
    },
  }