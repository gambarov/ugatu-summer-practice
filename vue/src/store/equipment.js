import { getEquipment } from "@/assets/api/equipment";
export default {
    state: {
        equipment: [],
    },
    getters: {
        GET_EQUIPMENT(state) {
            return state.equipment;
        },
    },
    mutations: {
        SET_EQUIPMENT(state, payload) {
            state.equipment = payload;
        },
        DELETE_EQUIPMENT(state, payload) {
            // console.log(state.equipment.filter(item => item.value.id != payload))
            state.equipment = state.equipment.filter(item => item.id != payload);
            console.log(state.equipment.length)
        },
    },
    actions: {
        fetchEquipment(context) {
            return getEquipment().then((response) => context.commit('SET_EQUIPMENT', response.data.data)).catch((error) => console.log(error))
        },
        deleteEquipment(context, payload) {
            context.commit('DELETE_EQUIPMENT', payload)
        }
    },
}