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
        $students = Student::with('courses')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
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

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        $studentCourses = $student->courses->pluck('id')->toArray();
        return view('admin.students.edit', compact('student', 'courses', 'studentCourses'));
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

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->courses()->detach();
        $student->delete();

      return redirect()->route('admin.dashboard')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }
}
