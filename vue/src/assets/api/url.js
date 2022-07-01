import axios from "axios";
import { baseUrl } from "./baseUrl";
import store from "@/store/index.js";
let token;
if (JSON.parse(localStorage.getItem('user')) != null) {
    token = JSON.parse(localStorage.getItem('user')).token || '';
}

export const url = axios.create({
    baseURL: `${baseUrl}/api`,
    headers: { 'Authorization': `Bearer ${token}` }
})