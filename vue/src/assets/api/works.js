import { url } from "./url"
export const getWorks=(id,type)=>{
    return url.get(`/works/workable/${id}?workable_type=${type}`)
}
export const getTypes=()=>{
    return url.get(`/work/types`)
}
export const getStatuses=()=>{
    return url.get(`/work/statuses`)
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