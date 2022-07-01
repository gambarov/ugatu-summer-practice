import { url } from "./url"
export const getSpecsByEquipment=(id)=>{
    return url.get(`/equipment/${id}/chars`)
}
export const getSpecs=()=>{
    return url.get(`/chars`)
}
export const getMeasures=()=>{
    return url.get(`/char/measures`)
}
export const getGroups=()=>{
    return url.get(`/char/groups`)
}
export const postSpec=(data)=>{
    return url.post('/chars',data)
}
export const getSpecsById=(id)=>{
    return url.get('/specs/'+id)
}
export const deleteSpec=(id)=>{
    return url.delete('/specs/'+id)
}
export const patchSpec=(id,data)=>{
    return url.patch('/specs/'+id,data)
}