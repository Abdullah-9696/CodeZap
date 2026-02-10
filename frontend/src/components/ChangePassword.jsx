import React, { useState } from "react";
import { API, getCsrfCookie } from "../axios";

function ChangePassword() {
  const [form, setForm] = useState({ current_password: "", new_password: "", new_password_confirmation: "" });
  const [message, setMessage] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const token = localStorage.getItem('token');
      if (!token) {
        await getCsrfCookie();
      }
      const res = await API.post("/profile/change-password", form);
      setMessage(res.data.message);
      setForm({ current_password: "", new_password: "", new_password_confirmation: "" });
    } catch (err) {
      setMessage(err.response?.data?.message || "Password update failed");
    }
  };

  return (
    <div className="container mt-5" style={{ maxWidth: "600px" }}>
      <h3>Change Password</h3>
      {message && <div className="alert alert-info">{message}</div>}

      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label>Current Password</label>
          <input type="password" className="form-control" value={form.current_password} onChange={e => setForm({...form, current_password: e.target.value})}/>
        </div>
        <div className="mb-3">
          <label>New Password</label>
          <input type="password" className="form-control" value={form.new_password} onChange={e => setForm({...form, new_password: e.target.value})}/>
        </div>
        <div className="mb-3">
          <label>Confirm New Password</label>
          <input type="password" className="form-control" value={form.new_password_confirmation} onChange={e => setForm({...form, new_password_confirmation: e.target.value})}/>
        </div>
        <button className="btn btn-warning w-100">Change Password</button>
      </form>
    </div>
  );
}

export default ChangePassword;
