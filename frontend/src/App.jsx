import { Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Home from "./components/Home";
import Courses from "./components/Courses";
import Skills from "./components/Skills";
import Footer from "./components/Footer";
import Profile from "./components/Profile";
import Login from "./components/Login";
import AuthCallback from "./components/AuthCallback";
import ChangePassword from "./components/ChangePassword";
import UploadCourse from "./components/UploadCourse";
import ManageSkills from "./components/ManageSkills";
import ForgotPassword from "./components/ForgotPassword";
import AdminCourses from "./components/AdminCourses";
import ProtectedRoute from "./components/ProtectedRoute";
function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/courses" element={<Courses />} />
        <Route path="/skills" element={<Skills />} />
        <Route path="/login" element={<Login />} />
        <Route path="/auth/callback" element={<AuthCallback />} />
        <Route path="/profile" element={<ProtectedRoute><Profile /></ProtectedRoute>} />
        <Route path="/change-password" element={<ChangePassword />} />
        <Route path="/forgot-password" element={<ForgotPassword />} />
        <Route path="/admin/courses" element={<AdminCourses />} />
        <Route path="/manage-skills" element={<ManageSkills />} />
        <Route path="/upload-course" element={<UploadCourse />} />
      </Routes>
      <Footer />
    </>
  );
}

export default App;