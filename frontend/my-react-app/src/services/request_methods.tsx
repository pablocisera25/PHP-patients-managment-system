import { httpClient } from "../axios/http";

interface RequestOptions {
    url:string;
    method: 'GET' | 'POST' | 'PUT' | 'DELETE' | 'PATCH';
    headers?: HeadersInit;
    body?: any;
}

export const getData = async(options: RequestOptions) => {
    try {
        const response = await httpClient.get(options.url, {
            headers: options.headers
        })

        if(response.status >= 200 && response.status < 300)
        {
            return response.data;
        }else{
            throw new Error('Unexpected response status: ' + response.status);
        }

        return response;
    } catch (error) {
        console.error('GET error: ', error);
        throw error;
    }
}

export const postData = async(options: RequestOptions) => {
    try{
        const response = await httpClient.post(options.url, options.body,{
            headers: options.headers,
        })

        if (response.status >= 200 && response.status < 300) {
            return response.data;
        } else {
            throw new Error('Unexpected response status: ' + response.status);
        }
    }catch(error){
        console.error('POST error: ', error);
        throw error;
    }
}