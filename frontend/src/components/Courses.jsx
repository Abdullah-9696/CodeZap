import { useState, useEffect } from "react";

// Sample 30 courses with realistic links
const sampleCourses = Array.from({ length: 30 }, (_, i) => ({
  id: i + 1,
  title: `Course ${i + 1}`,
  description: `Learn and master Course ${i + 1} with practical exercises.`,
  platform: ["Udemy", "Coursera", "edX", "LinkedIn Learning"][i % 4],
  level: ["Beginner", "Intermediate", "Advanced"][i % 3],
  link: ["https://www.udemy.com", "https://www.coursera.org", "https://www.edx.org", "https://www.linkedin.com/learning"][i % 4],
  linkyoutube: [
    "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
    "https://www.youtube.com/watch?v=3fumBcKC6RE",
    "https://www.youtube.com/watch?v=V-_O7nl0Ii0",
  ][i % 3],
}));

function Courses() {
  const [courses, setCourses] = useState([]);
  const [page, setPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const [searchQuery, setSearchQuery] = useState("");

  const perPage = 3; // courses per page

  // Fetch Courses (mocked)
  const fetchCourses = (pageNumber = 1) => {
    setLoading(true);
    setTimeout(() => {
      const start = (pageNumber - 1) * perPage;
      const end = start + perPage;
      const paginatedCourses = sampleCourses.slice(start, end);
      setCourses(paginatedCourses);
      setLastPage(Math.ceil(sampleCourses.length / perPage));
      setLoading(false);
    }, 500);
  };

  useEffect(() => {
    fetchCourses(page);
  }, [page]);

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
                  <a
                    href={course.link}
                    className="btn btn-outline-primary me-2"
                    target="_blank"
                    rel="noreferrer"
                  >
                    Visit
                  </a>
                  <a
                    href={course.linkyoutube}
                    className="btn btn-outline-primary"
                    target="_blank"
                    rel="noreferrer"
                  >
                    YouTube
                  </a>
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
