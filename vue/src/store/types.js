import { getTypes,getStatuses } from "@/assets/api/works";
export default {
    state: {
        works:[],
        types:[],
        statuses:[],
    },
    getters: {
        GET_TYPES(state){
            return state.types;
        },
        GET_STATUSES(state){
            return state.statuses;
        }
    },
    mutations: {
        SET_WORKS(state,payload){
            payload=payload.map((work)=>{
                if(work.employee!=null){
                    work.employeeInitials=work.employee.surname+" "+work.employee.name[0]+"."+work.employee.patronymic[0]+".";
                }
                return work;
            })
            state.works=payload;
        },
        SET_TYPES(state,payload){
            state.types=payload;
        },
        SET_STATUSES(state,payload){
            state.statuses=payload;
        },
    },
    actions: {
        fetchTypes(context){
            return Promise.all([getTypes(),getStatuses()]).then((response) => {
                context.commit('SET_TYPES', response[0].data.data);
                context.commit('SET_STATUSES', response[1].data.data);

        });
            return getTypes().then((response) => context.commit('SET_TYPES', response.data.data)).catch((error) => console.log(error))
        },
    },
  }