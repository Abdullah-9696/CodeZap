@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add New Skill</h2>
    <form action="{{ route('admin.skills.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="link" class="control">
        </div>
       <div class="mb-3">
    <label class="form-label fw-bold">Link Text</label>
    <input type="text" name="linkText" class="control rounded-3"
           value="{{ old('linkText', $skill->linkText ?? '') }}">
</div>

        <button type="submit" class="btn btn-success">Add Skill</button>
    </form>
</div>
@endsection
