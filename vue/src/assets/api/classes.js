import { url } from "./url"
export const getEquipment=()=>{
    return url.get('/equipment')
}