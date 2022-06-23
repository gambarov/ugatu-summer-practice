import { url } from "./url"
export const getSets=()=>{
    return url.get('/sets')
}