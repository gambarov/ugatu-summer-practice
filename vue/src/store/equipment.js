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
            state.equipment = state.equipment.filter(item => item.id !== payload.id);
        },
    },
    actions: {
        fetchEquipment(context) {
            return getEquipment().then((response) => context.commit('SET_EQUIPMENT', response.data.data)).catch((error) => console.log(error))
        },
        deleteEquipment(context, payload) {
            context.commmit('DELETE_EQUIPMENT', payload)
        }
    },
}