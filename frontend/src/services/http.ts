import api from "../config/axios"

export const get =async <T = any>(url: string, id?: number) => {
    const finalUrl = id ? `${url}/${id}` : url
    return await api.get<T>(finalUrl).then(res => res.data)
}

export const post = async <T = any>(url: string, body: object) => {
    return await api.post<T>(url, body).then(res => res.data)
}

export const put = async<T = any>(url: string, id: number, body: object) => {
    return await api.put<T>(`${url}/${id}`, body).then(res => res.data)
}

export const remove =async <T = any>(url: string, id: number) => {
    return await api.delete<T>(`${url}/${id}`).then(res => res.data)
}