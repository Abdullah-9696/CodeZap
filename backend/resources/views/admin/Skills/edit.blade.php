@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Skill</h2>
    <form action="{{ route('admin.skills.update', $skill->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $skill->title }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required>{{ $skill->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="link" value="{{ $skill->link }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Link Text</label>
            <input type="text" name="linkText" value="{{ $skill->linkText }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Skill</button>
    </form>
</div>
@endsection
