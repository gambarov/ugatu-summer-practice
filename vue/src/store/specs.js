import { getSpecs, getMeasures,getGroups } from "@/assets/api/specs";
export default {
    state: {
        specs:[],
        measures:[],
        groups:[]
    },
    getters: {
        GET_SPECS(state){
            return state.specs;
        },
        GET_MEASURES(state){
            return state.measures;
        },
        GET_GROUPS(state){
            return state.groups;
        },
    },
    mutations: {
        SET_SPECS(state,payload){
            state.specs=payload;
        },
        SET_MEASURES(state,payload){
            state.measures=payload;
        },
        SET_GROUPS(state,payload){
            state.groups=payload;
        },
    },
    actions: {
        fetchSpecs(context){
            return Promise.all([getSpecs(),getMeasures(),getGroups()]).then((response) => {
                context.commit('SET_SPECS', response[0].data.data);
                context.commit('SET_MEASURES', response[1].data.data);
                context.commit('SET_GROUPS', response[2].data.data);

        });
            // return getSPECs().then((response) => context.commit('SET_SPECS', response.data.data)).catch((error) => console.log(error))
        },
    },
  }