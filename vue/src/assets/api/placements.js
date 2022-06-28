import { url } from "./url"
export const getPlacements=()=>{
    return url.get('/placements')
}
export const getPlacementsEquipment=(id)=>{
    return url.get('/placements/equipment/'+id)
}
export const postPlacement=(data)=>{
    return url.post('/placements',data)
}
export const deletePlacement=(id)=>{
    return url.delete('/placements/'+id)
}
export const patchPlacement=(id,data)=>{
    return url.patch('/placements/'+id,data)
}