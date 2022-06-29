import { url } from "./url"
export const getEquipment=()=>{
    return url.get('/equipment');
}
export const getTypes=()=>{
    return url.get('/equipment/types');
}
export const getEquipmentById=(id)=>{
    return url.get('/equipment/'+id)
}
export const postEquipment=(data)=>{
    return url.post('/equipment',data)
}
export const deleteEquipment=(id)=>{
    return url.delete('/equipment/'+id)
}
export const patchEquipment=(id,data)=>{
    return url.patch('/equipment/'+id,data)
}