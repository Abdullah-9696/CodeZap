import axios from "axios";

axios.defaults.withCredentials = true;

const API_BASE = import.meta.env.VITE_API_BASE || "http://127.0.0.1:8000/api";
const APP_BASE = import.meta.env.VITE_APP_BASE || "http://127.0.0.1:8000";

export const API = axios.create({
  baseURL: API_BASE,
  withCredentials: true,
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
});

API.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

API.interceptors.request.use((config) => {
  const storedToken = localStorage.getItem('token');
  const devToken = import.meta.env.VITE_DEV_TOKEN;
  const token = storedToken || devToken;
  config.headers = config.headers || {};
  if (token) {
    // Use Bearer token auth without cookies to avoid CSRF checks
    config.headers.Authorization = `Bearer ${token}`;
    config.withCredentials = false;
  } else {
    // No token: fall back to cookie-based session which requires CSRF
    config.withCredentials = true;
  }
  return config;
});

export const getCsrfCookie = () =>
  axios.get(`${APP_BASE}/sanctum/csrf-cookie`, { withCredentials: true });

export default API;
