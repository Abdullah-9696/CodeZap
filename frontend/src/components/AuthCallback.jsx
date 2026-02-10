import React, { useEffect } from "react";

function AuthCallback() {
  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const token = params.get('token');
    if (token) {
      localStorage.setItem('token', token);
      window.location.replace('/profile');
    } else {
      window.location.href = '/login';
    }
  }, []);

  return (
    <div className="d-flex justify-content-center align-items-center vh-100 bg-light">
      <div className="text-center">
        <p>Finalizing authentication...</p>
      </div>
    </div>
  );
}

export default AuthCallback;


