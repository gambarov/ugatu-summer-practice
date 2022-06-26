import { getEmployees } from "@/assets/api/employee";
import { convertEmployee } from "@/assets/convertEmployee";
export default {
    state: {
        employees: [],
    },
    getters: {
        GET_EMPLOYEES(state) {
            return state.employees;
        },
    },
    mutations: {
        SET_EMPLOYEES(state, payload) {
            state.employees = convertEmployee(payload);
        },
        DELETE_EMPLOYEES(state, payload) {
            // console.log(state.employees.filter(item => item.value.id != payload))
            state.employees = state.employees.filter(item => item.id != payload);
            console.log(state.employees.length)
        },
    },
    actions: {
        fetchEmployees(context) {
            return getEmployees().then((response) => context.commit('SET_EMPLOYEES', response.data.data)).catch((error) => console.log(error))
        },
        deleteEmployees(context, payload) {
            context.commit('DELETE_EMPLOYEES', payload)
        }
    },
}