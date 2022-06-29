import { url } from "./url"
export const getClasses=()=>{
    return url.get('/audiences')
}
export const getTypes=()=>{
    return url.get('/audience/types')
}
export const getClassById=(id)=>{
    return url.get('/audiences/'+id)
}
export const postClass=(data)=>{
    return url.post('/audiences',data)
}
export const deleteClass=(id)=>{
    return url.delete('/audiences/'+id)
}
export const patchClass=(id,data)=>{
    return url.patch('/audiences/'+id,data)
}