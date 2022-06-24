import { url } from "./url"
export const getClasses=()=>{
    return url.get('/audiences')
}
export const postClass=(data)=>{
    return url.post('/audiences',data)
}