import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { API, getCsrfCookie } from "../axios";

function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate();
  const APP_BASE = import.meta.env.VITE_APP_BASE || "http://127.0.0.1:8000";

  useEffect(() => {
    // Check if already logged in
    const token = localStorage.getItem("token");
    if (token) {
      navigate("/"); // Redirect to home if token exists
    }
  }, [navigate]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage(""); // Clear previous message

    try {
      await getCsrfCookie(); // Fetch CSRF token for Sanctum
      const response = await API.post("/api/login", {
        email,
        password,
      }, {
        withCredentials: true,
      });

      const { token, message: successMessage } = response.data;
      if (token) {
        localStorage.setItem("token", token);
        localStorage.setItem("authToken", "loggedIn");
        navigate("/"); // Redirect to home page on successful login
      } else {
        setMessage(successMessage || "Login successful, but no token received.");
      }
    } catch (error) {
      const errorMessage = error.response?.data?.message || "Login failed. Please try again.";
      setMessage(errorMessage);
    }
  };

  return (
    <div className="d-flex justify-content-center align-items-center vh-100 bg-light">
      <div className="text-center p-4 border rounded bg-white shadow-sm">
        <h2 className="mb-4">Login</h2>
        {message && <div className="alert alert-info mb-3">{message}</div>}
        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <input
              type="email"
              className="form-control"
              placeholder="Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          <div className="mb-3">
            <input
              type="password"
              className="form-control"
              placeholder="Password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <button type="submit" className="btn btn-primary w-100">
            Login
          </button>
        </form>
        <p className="mt-3">
          <a href={`${APP_BASE}/login/google`}>Login with Google</a> |{" "}
          <a href={`${APP_BASE}/login/facebook`}>Login with Facebook</a>
        </p>
      </div>
    </div>
  );
}

export default Login;