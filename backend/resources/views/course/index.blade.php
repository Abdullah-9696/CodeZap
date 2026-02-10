@extends('layouts.admin')

@section('content')
<h2>Courses</h2>
<a href="{{ route('admin.courses.create') }}" class="btn btn-primary mb-3">Add Course</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    @forelse($courses as $course)
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $course->title }}</h5>

                {{-- Platform + Level in one line --}}
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="badge bg-light text-dark py-1 px-2" style="min-width: 70px;">{{ $course->platform }}</span>
                    <span class="badge bg-info text-dark py-1 px-2">{{ $course->level }}</span>
                </div>

                {{-- Tags --}}
                <p class="mb-2">
                    @foreach(explode(',', $course->tags) as $tag)
                        <span class="badge bg-secondary me-1 mb-1">{{ trim($tag) }}</span>
                    @endforeach
                </p>

                {{-- Links --}}
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @if($course->link)
                        <a href="{{ $course->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                    @endif
                    @if($course->linkyoutube)
                        <a href="{{ $course->linkyoutube }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill">▶ Watch</a>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm flex-fill">Edit</a>
                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm w-100" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted">
        No courses added yet.
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>
@endsection
