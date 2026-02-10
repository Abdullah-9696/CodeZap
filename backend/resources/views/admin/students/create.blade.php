@extends('layouts.admin')

@section('content')
<h2>Add New Student</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.students.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="control" required>
    </div>

    <div class="mb-3">
        <label>Select Courses</label>
        @foreach($courses as $course)
            <div class="form-check">
                <input type="checkbox" name="courses[]" value="{{ $course->id }}" class="form-check-input">
                <label class="form-check-label">{{ $course->title }}</label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-success">Add Student</button>
</form>
@endsection
