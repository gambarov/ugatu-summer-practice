import { getSets } from "@/assets/api/sets";
import { baseUrl } from "@/assets/api/baseUrl";
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
            payload=payload.map((set)=>{
                if(set.employee!=null){
                    set.employeeInitials=set.employee.surname+" "+set.employee.name[0]+"."+set.employee.patronymic[0]+".";

                }
                set.url=baseUrl+'/category/sets/info/'+set.id;
                return set;
            })
            state.sets=payload;
        },
        DELETE_SET(state,payload){
            state.sets= state.sets.filter(item=>item.id!==payload.id);
        },
    },
    actions: {
        fetchSets(context){
            return getSets().then((response) => context.commit('SET_SETS', response.data.data)).catch((error) => console.log(error))
        },
        deleteSet(context,payload){
            context.commmit('DELETE_SET',payload)
        }
    },
  }