const express = require("express");
const cors = require("cors");
const app = express();

// Allow requests from your frontend origin
app.use(cors({
  origin: "http://localhost:5173",
  methods: ["GET", "POST", "PUT", "DELETE"],
  allowedHeaders: ["Content-Type", "Authorization"],
}));

app.get("/courses", (req, res) => {
  // Your database query logic here
  res.json([
    { id: 1, title: "Course 1", description: "Description", link: "http://example.com", linkText: "Learn" },
    // Add more courses
  ]);
});

app.get("/skills", (req, res) => {
  // Your database query logic here
  res.json([
    { id: 1, name: "Skill 1", proficiency: "Advanced" },
    // Add more skills
  ]);
});

app.listen(8000, () => {
  console.log("Server running on http://127.0.0.1:8000");
});