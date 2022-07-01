import { getEquipment,getTypes } from "@/assets/api/equipment";
export default {
    state: {
        equipment: [],
        equipmentTypes:[],
    },
    getters: {
        GET_EQUIPMENT(state) {
            return state.equipment;
        },
        GET_EQUIPMENT_TYPES(state) {
            return state.equipmentTypes;
        },
    },
    mutations: {
        SET_EQUIPMENT(state, payload) {
            payload=payload.map((item) =>{
                if(item.audience!=null){
                item.audience.name=item.audience.building+"-"+item.audience.number;
                item.audience.name+=item.audience.letter?item.audience.letter:''; 
                }

                return item;
            })
            state.equipment = payload;
        },
        SET_EQUIPMENT_TYPES(state,payload){
            state.equipmentTypes=payload;
        },
        DELETE_EQUIPMENT(state, payload) {
            // console.log(state.equipment.filter(item => item.value.id != payload))
            state.equipment = state.equipment.filter(item => item.id != payload);
            console.log(state.equipment.length)
        },
    },
    actions: {
        
        fetchEquipment(context) {
            return Promise.all([getEquipment(),getTypes()]).then((response) => {
                context.commit('SET_EQUIPMENT', response[0].data.data);
                context.commit('SET_EQUIPMENT_TYPES', response[1].data.data)});
            return getEquipment().then((response) => context.commit('SET_EQUIPMENT', response.data.data)).catch((error) => console.log(error))
        },
        deleteEquipment(context, payload) {
            context.commit('DELETE_EQUIPMENT', payload)
        }
    },
}