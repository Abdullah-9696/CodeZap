import axios from "axios";

axios.defaults.baseURL = "http://127.0.0.1:8000";
axios.defaults.withCredentials = true; // Enable credentials for CORS

// Fetch CSRF token
export const fetchCsrfToken = async () => {
  try {
    await axios.get("/sanctum/csrf-cookie");
    console.log("CSRF token fetched");
  } catch (error) {
    console.error("Error fetching CSRF token:", error);
    throw error;
  }
};

// Fetch courses
export const fetchCourses = async (page = 1, perPage = 3, endpoint = "/courses") => {
  try {
    const response = await axios.get(`${endpoint}?page=${page}&per_page=${perPage}`, {
      headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
    });
    return response.data;
  } catch (error) {
    console.error("Error fetching courses:", error);
    throw error;
  }
};

// Login
export const login = async (email, password) => {
  await fetchCsrfToken();
  try {
    const response = await axios.post(
      "/login",
      { email, password },
      {
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      }
    );
    const user = response.data.user; // Adjust based on your API response
    if (user && user.role) {
      localStorage.setItem("userRole", user.role);
    }
    return response.data;
  } catch (error) {
    console.error("Login error:", error);
    throw error;
  }
};

// Register and Logout
export const register = async (name, email, password) => {
  await fetchCsrfToken();
  try {
    const response = await axios.post(
      "/register",
      { name, email, password },
      {
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      }
    );
    return response.data;
  } catch (error) {
    console.error("Register error:", error);
    throw error;
  }
};

export const logout = async () => {
  await fetchCsrfToken();
  try {
    const response = await axios.post(
      "/admin/logout",
      {},
      {
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      }
    );
    localStorage.removeItem("userRole");
    return response.data;
  } catch (error) {
    console.error("Logout error:", error);
    throw error;
  }
};