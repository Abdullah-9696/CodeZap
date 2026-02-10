@extends('layouts.admin')

@section('content')
<h2>Add Course</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-4">
    @csrf

    {{-- Title --}}
    <div class="form-group w-full">
        <label class="block mb-1 font-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control w-full border p-2 rounded" placeholder="Enter course title" required>
    </div>

    {{-- Platform + Level in one line --}}
    <div class="form-group w-full flex gap-2 flex-wrap">
        <div class="flex-1">
            <label class="block mb-1 font-semibold">Platform <span class="text-danger">*</span></label>
            <input type="text" name="platform" class="form-control w-full border p-2 rounded" placeholder="Platform (e.g., Udemy)" required>
        </div>
        <div style="width: 100px;">
            <label class="block mb-1 font-semibold">Level</label>
            <input type="text" name="level" class="form-control w-full border p-2 rounded" placeholder="Beginner / Intermediate">
        </div>
    </div>

    {{-- Tags --}}
    <div class="form-group w-full">
        <label class="block mb-1 font-semibold">Tags</label>
        <input type="text" name="tags" class="form-control w-full border p-2 rounded" placeholder="Separate tags with commas">
    </div>

    {{-- Link --}}
    <div class="form-group w-full">
        <label class="block mb-1 font-semibold">Link (optional)</label>
        <input type="url" name="link" class="form-control w-full border p-2 rounded" placeholder="Enter course link">
    </div>

    {{-- YouTube Link --}}
    <div class="form-group w-full">
        <label class="block mb-1 font-semibold">YouTube Link (optional)</label>
        <input type="url" name="linkyoutube" class="form-control w-full border p-2 rounded" placeholder="Enter YouTube tutorial link">
    </div>

    <button type="submit" class="btn btn-success">Add Course</button>
</form>
@endsection
