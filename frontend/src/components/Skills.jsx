import { useState, useEffect } from "react";
import axios from "axios";

function Skills() {
  const [skills, setSkills] = useState([]);
  const [page, setPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);

  const perPage = 3; // 3 skills per page

  const fetchSkills = async (pageNumber = 1) => {
    setLoading(true);
    try {
      const res = await axios.get(`http://127.0.0.1:8000/skills?page=${pageNumber}&per_page=${perPage}`);
      if (res.data && res.data.data) {
        setSkills(res.data.data);
        setLastPage(res.data.last_page);
      } else {
        setSkills([]);
        setLastPage(1);
      }
    } catch (err) {
      console.error(err);
      setSkills([]);
      setLastPage(1);
    }
    setLoading(false);
  };

  useEffect(() => {
    fetchSkills(page);
  }, [page]);

  return (
    <section id="skills" className="skills-section py-5">
      <div className="skills-container">
        <h2 className="mb-4">Improve Your Coding Skills</h2>

        {loading ? (
          <div className="text-center my-3">
            <div className="spinner-border text-primary" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
          </div>
        ) : skills.length > 0 ? (
          <div className="row">
            {skills.map((skill, index) => (
              <div key={index} className="col-md-4 mb-4">
                <div className="card h-100">
                  <div className="card-body">
                    <h5 className="card-title">{skill.title}</h5>
                    <p className="card-text">{skill.description}</p>
                    <a href={skill.link} className="btn btn-outline-primary">{skill.linkText}</a>
                  </div>
                </div>
              </div>
            ))}
          </div>
        ) : (
          <p className="text-center">No skills found.</p>
        )}

        {/* Pagination */}
        <div className="d-flex justify-content-center mt-3">
          <button
            className="btn btn-secondary me-2"
            onClick={() => setPage(prev => Math.max(prev - 1, 1))}
            disabled={page === 1 || loading}
          >
            Previous
          </button>
          <span className="align-self-center mx-2">Page {page} of {lastPage}</span>
          <button
            className="btn btn-secondary ms-2"
            onClick={() => setPage(prev => Math.min(prev + 1, lastPage))}
            disabled={page === lastPage || loading}
          >
            Next
          </button>
        </div>
      </div>
    </section>
  );
}

export default Skills;
