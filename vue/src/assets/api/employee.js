import { url } from "./url"
export const getEmployees=()=>{
    return url.get('/employees')
}
export const postEmployee=(data)=>{
    return url.post('/employees',data)
}
export const patchEmployee=(id,data)=>{
    return url.patch('/employees/'+id,data)
}
export const deleteEmployee=(id)=>{
    return url.delete('/employees/'+id)
}