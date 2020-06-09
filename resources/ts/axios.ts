import axios from 'axios';

const instance = axios.create();

instance.interceptors.request.use((config) => {
    if (!config.headers['Content-Type']) {
        config.headers['Content-Type'] = 'application/json';
    }
    if (!config.headers['Accept']) {
        config.headers['Accept'] = 'application/json';
    }
    return config;
})

export default instance;
