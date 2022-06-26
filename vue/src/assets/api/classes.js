import { url } from "./url"
export const getClasses=()=>{
    return url.get('/audiences')
}
export const postClass=(data)=>{
    return url.post('/audiences',data)
}
export const deleteClass=(id)=>{
    return url.delete('/audiences/'+id)
}