import { postUser } from "@/assets/api/user";
const currentUser = JSON.parse(localStorage.getItem('user')) || null

export default {
    state: {
        user: currentUser,
    },
    getters: {
        GET_USER(state) {
            return state.user;
        },
        GET_RIGHTS(state) {
            if(state.user!=null){
              return state.user.employee.role.id===1?true:false;  
            }
            return false
        },
        GET_TOKEN(state){
            if(state.user){
               return state.user.token
            }
            return ""
        },
        GET_AUTHENTICATION(state) {
            return state.user !== null ? true : false;
        },
    },
    mutations: {
        SET_USER(state, payload) {
            if (payload != null) {
                localStorage.setItem('user', JSON.stringify(payload));
                state.user = payload;
            }

        },
        DELETE_USER(state) {
            localStorage.removeItem('user');
            state.user = null;
        },
    },
    actions: {
        fetchUser(context, user) {
            // return new Promise((resolve,error)=>{context.commit('SET_USER', user);resolve('lolz')}) 
            return postUser(user).then((response) => context.commit('SET_USER', response.data))
        },
        deleteUser(context) {
            context.commit('DELETE_USER');
        }
    },
}