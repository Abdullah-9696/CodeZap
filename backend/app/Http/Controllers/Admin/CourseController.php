<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::paginate(3); // 3 courses per page

        if ($request->ajax()) {
            return response()->json($courses); // For lazy loading
        }

        return view('admin.courses.index', compact('courses'));
    }


    public function create() {
        return view('admin.courses.create');
    }

 public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'platform' => 'required|string|max:255',
        'level' => 'nullable|string|max:100',
        'tags' => 'nullable|string|max:255',
        'link' => 'nullable|url',
        'linkyoutube' => [
            'required',
            'url',
            'regex:/^(https:\/\/www\.youtube\.com\/|https:\/\/youtu\.be\/).+$/'
        ],
    ], [
        'linkyoutube.regex' => 'YouTube link must be a valid YouTube URL (https://www.youtube.com/ or https://youtu.be/)',
    ]);

    Course::create($request->all());

    return redirect()->route('admin.courses.index')->with('success', 'Course added successfully.');
}

    public function edit(Course $course) {
        return view('admin.courses.edit', compact('course'));
    }
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'platform' => 'required|string|max:255',
        'level' => 'nullable|string|max:100',
        'tags' => 'nullable|string|max:255',
        'link' => 'nullable|url',
        'linkyoutube' => [
            'required',
            'url',
            'regex:/^(https:\/\/www\.youtube\.com\/|https:\/\/youtu\.be\/).+$/'
        ],
    ], [
        'linkyoutube.regex' => 'YouTube link must be a valid YouTube URL (https://www.youtube.com/ or https://youtu.be/)',
    ]);

    $course = Course::findOrFail($id);
    $course->update($request->all());

    return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
}


    public function destroy(Course $course) {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success','Course deleted!');
    }
}
