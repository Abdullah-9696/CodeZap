import { useState, useEffect } from "react";

const sampleSkills = Array.from({ length: 30 }, (_, i) => ({
  id: i + 1,
  title: ["React Basics", "JavaScript", "Python", "Node.js", "CSS", "HTML", "Django", "Laravel"][i % 8],
  description: `Practice and improve your ${["React", "JS", "Python", "Node", "CSS", "HTML", "Django", "Laravel"][i % 8]} skills.`,
  link: [
    "https://www.udemy.com",
    "https://www.coursera.org",
    "https://www.edx.org",
  ][i % 3],
  linkText: "Learn More",
  linkyoutube: [
    "https://www.youtube.com/@freecodecamp",
    "https://www.youtube.com/@TraversyMedia",
    "https://www.youtube.com/@TheNetNinja",
    "https://www.youtube.com/@programmingwithmosh",
  ][i % 4],
}));

function Skills() {
  const [skills, setSkills] = useState([]);
  const [page, setPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const perPage = 3;

  const fetchSkills = (pageNumber = 1) => {
    setLoading(true);
    setTimeout(() => {
      const start = (pageNumber - 1) * perPage;
      const end = start + perPage;
      setSkills(sampleSkills.slice(start, end));
      setLastPage(Math.ceil(sampleSkills.length / perPage));
      setLoading(false);
    }, 500);
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
            {skills.map((skill) => (
              <div key={skill.id} className="col-md-4 mb-4">
                <div className="card h-100">
                  <div className="card-body">
                    <h5 className="card-title">{skill.title}</h5>
                    <p className="card-text">{skill.description}</p>
                    <a
                      href={skill.link}
                      className="btn btn-outline-primary me-2"
                      target="_blank"
                      rel="noreferrer"
                    >
                      {skill.linkText}
                    </a>
                    <a
                      href={skill.linkyoutube}
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
          <p className="text-center">No skills found.</p>
        )}

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
      </div>
    </section>
  );
}

export default Skills;
