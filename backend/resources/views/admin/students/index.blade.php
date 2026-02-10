@extends('layouts.admin')

@section('content')

<a href="{{ route('admin.students.create') }}" class="btn btn-primary mb-3">Add New Student</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Courses</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>
                @foreach($student->courses as $course)
                    {{ $course->title }}<br>
                @endforeach
            </td>
            <td>
                {{-- Edit Icon --}}
                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>

                {{-- Delete Icon --}}
                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?')" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
