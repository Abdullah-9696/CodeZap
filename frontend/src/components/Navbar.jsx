import React, { useEffect, useState, useRef } from "react";
import { Link } from "react-router-dom";
import { API, getCsrfCookie } from "../axios";
import logo from "../assets/logo_image.png";

const APP_BASE = import.meta.env.VITE_APP_BASE || "http://127.0.0.1:8000";

function Navbar() {
  const [user, setUser] = useState(null);
  const [dropdownOpen, setDropdownOpen] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false); // only for mobile
  const [isMobile, setIsMobile] = useState(window.innerWidth < 992); // track screen size
  const dropdownRef = useRef(null);

  // Check screen size
  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth < 992);
      if (window.innerWidth >= 992) {
        setMenuOpen(false); // reset when back to desktop
      }
    };
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  // Fetch user info
  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const urlToken = params.get("token");
    if (urlToken) {
      localStorage.setItem("token", urlToken);
      if (window.location.pathname !== "/auth/callback") {
        window.location.replace("/profile");
        return;
      }
      const cleanUrl = window.location.pathname + window.location.hash;
      window.history.replaceState({}, "", cleanUrl || "/");
    }

    const fetchUser = async () => {
      const token = localStorage.getItem("token");
      if (!token) return;
      try {
        await getCsrfCookie();
        const res = await API.get(`/profile`);
        setUser(res.data.data);
        localStorage.setItem("authToken", "loggedIn");
      } catch {
        localStorage.removeItem("authToken");
      }
    };
    fetchUser();
  }, []);

  // Close dropdown if click outside
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (dropdownRef.current && !dropdownRef.current.contains(e.target)) {
        setDropdownOpen(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const toggleDropdown = () => setDropdownOpen(!dropdownOpen);
  const toggleMenu = () => { if (isMobile) setMenuOpen(!menuOpen); };

  return (
    <nav className="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
      <div className="container-fluid">
        {/* Logo */}
        <Link className="navbar-brand d-flex align-items-center" to="/">
          <img
            src={logo}
            alt="Logo"
            className="me-2"
            style={{ height: "40px" }}
          />
          <span className="fw-bold">CodeZap</span>
        </Link>

        {/* Mobile toggle button */}
        {isMobile && (
          <button className="navbar-toggler" type="button" onClick={toggleMenu}>
            <span className="navbar-toggler-icon"></span>
          </button>
        )}

        {/* Nav links */}
        <div
          className={`collapse navbar-collapse justify-content-end ${menuOpen && isMobile ? "show" : ""}`}
          id="navbarNav"
          style={{
            maxHeight: isMobile ? "80vh" : "none",
            overflowY: isMobile ? "auto" : "visible",
          }}
        >
          <ul className="navbar-nav align-items-center flex-column flex-lg-row gap-3">
            <li className="nav-item">
              <Link className="nav-link" to="/" onClick={() => setMenuOpen(false)}>
                Home
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/courses" onClick={() => setMenuOpen(false)}>
                Courses
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/skills" onClick={() => setMenuOpen(false)}>
                Skills
              </Link>
            </li>

            {/* Profile picture */}
            {user && user.profile_picture && (
              <li className="nav-item">
                <img
                  src={`${APP_BASE}${user.profile_picture}`}
                  alt={`${user.name}'s Profile`}
                  className="rounded-circle"
                  style={{
                    width: "35px",
                    height: "35px",
                    objectFit: "cover",
                    border: "2px solid #6f42c1",
                  }}
                />
              </li>
            )}

            {/* Dropdown for username */}
            {user && (
              <li className="nav-item dropdown" ref={dropdownRef}>
                <button
                  className="btn btn-link nav-link dropdown-toggle"
                  onClick={toggleDropdown}
                >
                  {user.name}
                </button>
                {dropdownOpen && (
                  <ul className="dropdown-menu dropdown-menu-end show">
                    <li>
                      <Link
                        to="/profile"
                        className="dropdown-item"
                        onClick={() => {
                          setDropdownOpen(false);
                          setMenuOpen(false);
                        }}
                      >
                        My Profile
                      </Link>
                    </li>
                    <li>
                      <Link
                        to="/change-password"
                        className="dropdown-item"
                        onClick={() => {
                          setDropdownOpen(false);
                          setMenuOpen(false);
                        }}
                      >
                        Change Password
                      </Link>
                    </li>
                  </ul>
                )}
              </li>
            )}
          </ul>
        </div>
      </div>
    </nav>
  );
}

export default Navbar;
