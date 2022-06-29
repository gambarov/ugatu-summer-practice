import axios from "axios";
import store from "@/store/index.js";
const token=JSON.parse(localStorage.getItem('user')).token||'';
export const url=axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {'Authorization': `Bearer ${store.getters.GET_TOKEN}`}
})