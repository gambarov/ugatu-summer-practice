import axios from "axios";
import store from "@/store/index.js";
let token;
if (JSON.parse(localStorage.getItem('user')) != null) {
    token = JSON.parse(localStorage.getItem('user')).token || '';
}

export const url = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: { 'Authorization': `Bearer ${token}` }
})