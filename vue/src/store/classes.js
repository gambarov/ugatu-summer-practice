import { getClasses, getTypes } from "@/assets/api/classes";
export default {
    state: {
        classes:[],
        classes_types:[]
    },
    getters: {
        GET_CLASSES(state){
            return state.classes;
        },
        GET_CLASSES_TYPES(state){
            return state.classes_types;
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
        SET_CLASSES_TYPES(state,payload){
            state.classes_types=payload;
        },
        DELETE_CLASSES(state,payload){
            state.sets= state.sets.filter(item=>item.id!==payload.id);
        },
    },
    actions: {
        fetchClasses(context){
            return Promise.all([getClasses(),getTypes()]).then((response) => {
                context.commit('SET_CLASSES', response[0].data.data);
                context.commit('SET_CLASSES_TYPES', response[1].data.data);})
        },
        deleteSet(context,payload){
            context.commmit('DELETE_SET',payload)
        }
    },
  }