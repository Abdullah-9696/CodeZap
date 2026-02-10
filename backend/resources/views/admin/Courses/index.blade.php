@extends('layouts.admin')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="container mt-4">
    <h2>All Courses</h2>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-success mb-3">Add New Course</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
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
            @forelse($courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td title="{{ $course->description }}">{{ Str::limit($course->description, 50) }}</td>
                <td>{{ $course->platform }}</td>
                <td>{{ $course->level }}</td>
                <td>{{ $course->tags }}</td>
                <td>
                    @if($course->link)
                        <a href="{{ $course->link }}" target="_blank">Visit</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($course->linkyoutube)
                        <a href="{{ $course->linkyoutube }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Watch on YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td class="text-end">
                    {{-- Edit Icon --}}
                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Delete Icon --}}
                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">No courses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
