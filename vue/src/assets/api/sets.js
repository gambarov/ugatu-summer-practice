import { url } from "./url"
export const getSets=()=>{
    return url.get('/sets')
}
export const postSet=(data)=>{
    return url.post('/sets',data)
}
export const getSetsById=(id)=>{
    return url.get('/sets/'+id)
}
export const deleteSet=(id)=>{
    return url.delete('/sets/'+id)
}
export const patchSet=(id,data)=>{
    return url.patch('/sets/'+id,data)
}