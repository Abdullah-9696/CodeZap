import React, { useEffect, useState } from "react";
import { API, getCsrfCookie } from "../axios";

// Check if user is authenticated
const ProtectedRoute = ({ children }) => {
  const [allowed, setAllowed] = useState(false);
  const [checked, setChecked] = useState(false);
  const token = localStorage.getItem("token");
  const APP_BASE = import.meta.env.VITE_APP_BASE || "http://127.0.0.1:8000";
  const LOGIN_URL = `${APP_BASE}/login`;

  useEffect(() => {
    const verifySessionIfNeeded = async () => {
      if (token) {
        setAllowed(true);
        setChecked(true);
        return;
      }
      try {
        await getCsrfCookie();
        await API.get('/profile');
        // Session is valid with Sanctum cookies
        setAllowed(true);
      } catch {
        setAllowed(false);
      } finally {
        setChecked(true);
      }
    };
    verifySessionIfNeeded();
  }, [token]);

  useEffect(() => {
    if (checked && !allowed) {
      window.location.href = LOGIN_URL;
    }
  }, [checked, allowed, LOGIN_URL]);

  if (!checked) return null;
  if (!allowed) return null;
  return children;
};

export default ProtectedRoute;
