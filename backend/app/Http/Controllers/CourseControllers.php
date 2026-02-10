<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseControllers extends Controller
{
    public function index(Request $request)
    {
        // Get pagination query params
        $perPage = $request->get('per_page', 10);  // default 10 per page
        $page = $request->get('page', 1);

        // Paginate courses
        $courses = Course::paginate($perPage, ['*'], 'page', $page);

        return response()->json($courses);
    }


    // Store a new course
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


    // Show a single course
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    // Update a course
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

    // Delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(null, 204);
    }
}
