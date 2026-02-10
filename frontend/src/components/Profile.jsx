import React, { useEffect, useState } from 'react';
import { API, getCsrfCookie } from '../axios';
import reactLogo from '../assets/react.svg';
import { useNavigate } from 'react-router-dom';

const APP_BASE = import.meta.env.VITE_APP_BASE || 'http://127.0.0.1:8000';

function Profile() {
  const [profile, setProfile] = useState({ name: '', email: '', profile_picture: '' });
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [image, setImage] = useState(null);
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const fetchProfile = async () => {
      const token = localStorage.getItem('token');
      try {
        if (!token) {
          await getCsrfCookie();
        }
        const res = await API.get(`/profile`, {
          headers: token ? { Authorization: `Bearer ${token}` } : undefined,
          withCredentials: token ? false : true,
        });
        setProfile(res.data.data);
        setName(res.data.data.name);
        setEmail(res.data.data.email);
      } catch (e) {
        setMessage(e.response?.data?.message || 'Failed to load profile');
        if (e.response?.status === 401) {
          window.location.href = '/login';
        }
      }
    };
    fetchProfile();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!name.trim() || !email.trim()) {
      setMessage("Please enter valid Name and Email");
      return;
    }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    if (image) formData.append('profile_picture', image);

    try {
      const token = localStorage.getItem('token');
      const headers = token
        ? { 'Content-Type': 'multipart/form-data', Authorization: `Bearer ${token}` }
        : { 'Content-Type': 'multipart/form-data' };
      const withCredentials = token ? false : true;

      if (!token) {
        await getCsrfCookie();
      }

      const res = await API.post(`/profile/update`, formData, {
        headers,
        withCredentials,
      });

      setProfile(res.data.data.user);
      setMessage(res.data.message);

      // 🔥 Force full page reload to Home after update
      window.location.href = "/";

    } catch (e) {
      setMessage(e.response?.data?.message || 'Failed to update');
    }
  };

  return (
    <div className="profile-dashboard">
      <div className="profile-header">
        <h2>My Profile</h2>
      </div>

      <div className="container profile-container">
        <div className="row">
          {/* Left Profile Card */}
          <div className="col-lg-4 col-md-5">
            <div className="profile-card">
              <div className="text-center">
                <img
                  src={profile.profile_picture ? `${APP_BASE}${profile.profile_picture}` : reactLogo}
                  alt="Profile"
                  className="profile-avatar"
                />
                <h4 className="mt-3">{profile.name || "Your Name"}</h4>
                <p className="text-muted">{profile.email || "your@email.com"}</p>
              </div>
            </div>
          </div>

          {/* Right Edit Form */}
          <div className="col-lg-8 col-md-7">
            <div className="edit-form">
              {message && <div className="alert alert-info">{message}</div>}
              <h5 className="mb-4">Edit Profile</h5>
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label className="form-label">Name</label>
                  <input
                    className="form-control modern-input"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                  />
                </div>
                <div className="mb-3">
                  <label className="form-label">Email</label>
                  <input
                    type="email"
                    className="form-control modern-input"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                  />
                </div>
                <div className="mb-3">
                  <label className="form-label">Profile Picture</label>
                  <input
                    type="file"
                    accept="image/*"
                    className="form-control modern-input"
                    onChange={(e) => setImage(e.target.files[0])}
                  />
                </div>
                <button className="btn btn-gradient w-100" type="submit">
                  Save Changes
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Profile;
