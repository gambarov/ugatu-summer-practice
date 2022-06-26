import axios from "axios";
import store from "@/store/index.js";
export const url=axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {'Authorization': `Bearer ${store.getters.GET_TOKEN}`}
})