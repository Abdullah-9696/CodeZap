import { useState, useEffect } from "react";
import axios from "axios";

function Courses() {
  const [courses, setCourses] = useState([]);
  const [page, setPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const [searchQuery, setSearchQuery] = useState("");

  const perPage = 3; // courses per page

  // -------- Fetch Courses Function --------
const fetchCourses = async (pageNumber = 1) => {
  setLoading(true);
  try {
    const res = await axios.get(
      `http://127.0.0.1:8000/courses?page=${pageNumber}&per_page=${perPage}`,
      { withCredentials: true }
    );

    if (res.data && res.data.data) {
      setCourses(res.data.data);
      setLastPage(res.data.last_page);
    } else {
      setCourses([]);
      setLastPage(1);
    }
  } catch (err) {
    console.error("Failed to fetch courses:", err);
    setCourses([]);
    setLastPage(1);
  } finally {
    setLoading(false);
  }
};


  // Fetch courses on page change
  useEffect(() => {
    fetchCourses(page);
  }, [page]);

  // Filter courses based on search
  const filteredCourses = courses.filter(
    (course) =>
      course.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
      searchQuery === ""
  );

  return (
    <section id="courses" className="container py-5">
      <h2 className="mb-4">Courses</h2>

      <input
        type="text"
        className="form-control mb-4"
        placeholder="Search courses..."
        value={searchQuery}
        onChange={(e) => setSearchQuery(e.target.value)}
      />

      {loading ? (
        <div className="text-center my-3">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : filteredCourses.length > 0 ? (
        <div className="row">
          {filteredCourses.map((course) => (
            <div key={course.id} className="col-md-4 mb-4">
              <div className="card h-100">
                <div className="card-body">
                  <h5 className="card-title">{course.title}</h5>
                  <p className="card-text">{course.description}</p>
                  <p><strong>Platform:</strong> {course.platform}</p>
                  <p><strong>Level:</strong> {course.level}</p>
                  <a href={course.link} className="btn btn-outline-primary me-2" target="_blank" rel="noreferrer">Visit</a>
                  <a href={course.linkyoutube} className="btn btn-outline-primary" target="_blank" rel="noreferrer">YouTube</a>
                </div>
              </div>
            </div>
          ))}
        </div>
      ) : (
        <p className="text-center">No courses found.</p>
      )}

      {/* Pagination */}
      <div className="d-flex justify-content-center mt-3">
        <button
          className="btn btn-secondary me-2"
          onClick={() => setPage((prev) => Math.max(prev - 1, 1))}
          disabled={page === 1 || loading}
        >
          Previous
        </button>
        <span className="align-self-center mx-2">
          Page {page} of {lastPage}
        </span>
        <button
          className="btn btn-secondary ms-2"
          onClick={() => setPage((prev) => Math.min(prev + 1, lastPage))}
          disabled={page === lastPage || loading}
        >
          Next
        </button>
      </div>
    </section>
  );
}

export default Courses;
