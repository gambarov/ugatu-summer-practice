import { url } from "./url"
export const postUser=(data)=>{
    return url.post('/login',data)
}