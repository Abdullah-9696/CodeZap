<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all records
        $students = Student::all();
        $courses  = Course::all();
        $skills   = Skill::all();
        
        return view('admin.dashboard', compact('students', 'courses', 'skills'));
    }
}
