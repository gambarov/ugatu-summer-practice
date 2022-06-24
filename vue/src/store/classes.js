import { getClasses } from "@/assets/api/classes";
export default {
    state: {
        classes:[],
    },
    getters: {
        GET_CLASSES(state){
            return state.classes;
        }
    },
    mutations: {
        SET_CLASSES(state,payload){
            payload=payload.map((item) =>{
                item.name=item.building+"-"+item.number;
                item.name+=item.letter?item.letter:'';
                return item;
            })
            state.classes=payload;
        },
        DELETE_CLASSES(state,payload){
            state.sets= state.sets.filter(item=>item.id!==payload.id);
        },
    },
    actions: {
        fetchClasses(context){
            return getClasses().then((response) => context.commit('SET_CLASSES', response.data)).catch((error) => console.log(error))
        },
        deleteSet(context,payload){
            context.commmit('DELETE_SET',payload)
        }
    },
  }