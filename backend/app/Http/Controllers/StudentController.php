<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->paginate(3); // Pagination
        $courses = Course::all(); // For select box in add form
        return view('admin.dashboard', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'courses' => 'required|array'
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $student->courses()->attach($request->courses);

        return redirect()->back()->with('success', 'Student added successfully.');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'courses' => 'required|array'
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $student->courses()->sync($request->courses);

        return redirect()->back()->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->courses()->detach();
        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }
}
