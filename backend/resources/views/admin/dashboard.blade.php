@extends('layouts.admin')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="container-fluid">

    {{-- DASHBOARD HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-speedometer2 me-2 text-primary"></i> Admin Dashboard
        </h2>
        <div>
            <a href="{{ route('change.password.form') }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-key me-1"></i> Change Password
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
              
            </form>
        </div>
    </div>

    {{-- SUCCESS/ERROR MESSAGES --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center p-4 bg-primary text-white rounded-4">
                <i class="bi bi-people-fill mb-3" style="font-size: 2.5rem;"></i>
                <h3 class="fw-bold">{{ $students->count() }}</h3>
                <p class="mb-0">Students</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center p-4 bg-success text-white rounded-4">
                <i class="bi bi-book-fill mb-3" style="font-size: 2.5rem;"></i>
                <h3 class="fw-bold">{{ $courses->count() }}</h3>
                <p class="mb-0">Courses</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center p-4 bg-warning text-dark rounded-4">
                <i class="bi bi-lightbulb-fill mb-3" style="font-size: 2.5rem;"></i>
                <h3 class="fw-bold">{{ $skills->count() }}</h3>
                <p class="mb-0">Skills</p>
            </div>
        </div>
    </div>

    {{-- STUDENTS TABLE --}}
    <div class="card shadow-lg border-0 mb-5 rounded-4">
        <div class="card-header bg-dark text-white fw-bold rounded-top-4">
            <i class="bi bi-person-lines-fill me-2"></i> Students
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Courses</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $index + 1 }}</span></td>
                            <td class="fw-bold">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                @foreach($student->courses as $course)
                                    {{ $course->title }}<br>
                                @endforeach
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- COURSES TABLE --}}
    <div class="card shadow-lg border-0 mb-5 rounded-4">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">
            <i class="bi bi-journal-bookmark-fill me-2"></i> Courses
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Platform</th>
                        <th>Level</th>
                        <th>Tags</th>
                        <th>Link</th>
                        <th>YouTube</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $index => $course)
                        <tr>
                            <td><span class="badge bg-dark">{{ $index + 1 }}</span></td>
                            <td class="fw-bold">{{ $course->title }}</td>
                            <td title="{{ $course->description }}">{{ Str::limit($course->description, 50) }}</td>
                            <td>{{ $course->platform }}</td>
                            <td>{{ $course->level }}</td>
                            <td>{{ $course->tags }}</td>
                            <td>
                                @if($course->link)
                                    <a href="{{ $course->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">Visit</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($course->linkyoutube)
                                    <a href="{{ $course->linkyoutube }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill">▶</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this course?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No courses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SKILLS TABLE --}}
    <div class="card shadow-lg border-0 mb-5 rounded-4">
        <div class="card-header bg-warning fw-bold rounded-top-4">
            <i class="bi bi-lightbulb-fill me-2"></i> Skills
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Link Text</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $index => $skill)
                        <tr>
                            <td><span class="badge bg-dark">{{ $index + 1 }}</span></td>
                            <td class="fw-bold">{{ $skill->title }}</td>
                            <td title="{{ $skill->description }}">{{ Str::limit($skill->description, 50) }}</td>
                            <td>
                                @if($skill->link)
                                    <a href="{{ $skill->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">Visit</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $skill->linkText ?? 'N/A' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.skills.edit', $skill->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this skill?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No skills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
