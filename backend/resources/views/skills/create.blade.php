@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Skill Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Skill Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Skill Link</label>
            <input type="url" name="link" class="form-control">
        </div>

        <div class="mb-3">
            <label for="linkText" class="form-label">Link Text</label>
            <input type="text" name="linkText" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Skill</button>
        <a href="{{ route('skills.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
