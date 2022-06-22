export default {
    state: {
        equipment:[{"id":1,"name":"Обеспечение1","type":"АО"},{"id":2,"name":"Обеспечение2","type":"ПО"},{"id":3,"name":"Обеспечение3","type":"ПО"},{"id":4,"name":"Обеспечение4","type":"ПО"}]
    },
    getters: {
        GET_EQUIPMENT(state){
            return state.equipment;
        },
        GET_EQUIPMENT_BY_ID:(state)=>(id)=>{
            return state.equipment.find(item=>item.id===id);
        }
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