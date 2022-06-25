import { postUser } from "@/assets/api/user";
const currentUser = JSON.parse(localStorage.getItem('user')) || null

export default {
    state: {
        user: currentUser,
    },
    // getters: {
    //     GET_EQUIPMENT(state) {
    //         return state.equipment;
    //     },
    // },
    mutations: {
        SET_USER(state, payload) {
            localStorage.setItem('user', JSON.stringify(payload));
            state.user = payload;
        },
        DELETE_USER(state) {
            localStorage.removeItem('user');
            state.user = null;
        },
    },
    actions: {
        fetchUser(context) {
            context.commit('SET_USER', { name: 'john', token: '123' })
            // return postUser().then((response) => context.commit('SET_USER', response.data.data)).catch((error) => console.log(error))
        },
        deleteEquipment(context, payload) {
            context.commit('DELETE_EQUIPMENT', payload)
        }
    },
}