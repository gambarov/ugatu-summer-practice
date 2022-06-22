export default {
    state: {
        sets:[],
    },
    getters: {
        GET_SETS(state){
            return state.sets;
        }
    },
    mutations: {
        SET_SETS(state,payload){
            state.equipment=payload;
        },
        DELETE_SET(state,payload){
            state.equipment= state.equipment.filter(item=>item.id!==payload.id);
        },
    },
    actions: {
        fetchSets(context,payload){
            context.commmit('SET_EQUIPMENT',payload)
        },
        deleteSet(context,payload){
            context.commmit('DELETE_EQUIPMENT',payload)
        }
    },
  }