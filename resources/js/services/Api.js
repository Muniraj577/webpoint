import axios from "axios";
import appConfig from "../app.config.js";

const apiBaseClient = axios.create({
    baseURL: appConfig.siteUrl,
    withCredentials: false,
    timeout: 150000,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    }
});

const apiClient = axios.create({
    baseURL: appConfig.apiUrl,
    withCredentials: false,
    timeout: 150000,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    }
});

export {
    apiBaseClient,
    apiClient
}
