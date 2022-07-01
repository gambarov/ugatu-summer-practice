import { url } from "./url"
export const getNoteByEquipment=(id)=>{
    return url.get(`/equipment/${id}/chars`)
}
export const getNotes=()=>{
    return url.get(`/notes`)
}
export const postNote=(data)=>{
    return url.post('/notes',data)
}
export const getNoteById=(id)=>{
    return url.get('/note/'+id)
}
export const deleteNote=(id)=>{
    return url.delete('/notes/'+id)
}
export const patchNote=(id,data)=>{
    return url.patch('/notes/'+id,data)
}