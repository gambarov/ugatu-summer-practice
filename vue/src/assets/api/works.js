import { url } from "./url"
export const getWorks=(data)=>{
    return url.post('/works',data)
}
export const postWork=(data)=>{
    return url.post('/works',data)
}
export const deleteWork=(id)=>{
    return url.delete('/works/'+id)
}
export const patchWork=(id,data)=>{
    return url.patch('/works/'+id,data)
}