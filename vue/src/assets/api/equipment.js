import { url } from "./url"
export const getEquipment=()=>{
    return url.get('/equipment')
}
export const getEquipmentById=(id)=>{
    return url.get('/equipment/'+id)
}