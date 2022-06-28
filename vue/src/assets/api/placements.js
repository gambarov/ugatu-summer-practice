import { url } from "./url"
export const getPlacements=(data)=>{
    return url.post('/placements',data)
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