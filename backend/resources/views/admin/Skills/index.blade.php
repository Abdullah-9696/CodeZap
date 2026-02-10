@extends('layouts.admin')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="container mt-4">
    <h2>All Skills</h2>
    <a href="{{ route('admin.skills.create') }}" class="btn btn-success mb-3">Add New Skill</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
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
            @forelse($skills as $skill)
                <tr>
                    <td><span class="badge bg-dark">{{ $loop->iteration + ($skills->currentPage()-1)*$skills->perPage() }}</span></td>
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
                        {{-- Edit Icon --}}
                        <a href="{{ route('admin.skills.edit', $skill->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Delete Icon --}}
                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this skill?')" title="Delete">
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

    {{-- Pagination links --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $skills->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
