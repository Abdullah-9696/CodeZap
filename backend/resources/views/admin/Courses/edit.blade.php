@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Course</h2>
    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required>{{ $course->description }}</textarea>
        </div>

        <!-- Platform -->
        <div class="mb-3">
            <label>Platform</label>
            <input type="text" name="platform" class="form-control" value="{{ $course->platform }}">
        </div>

        <!-- Level Dropdown -->
        <div class="mb-3">
            <label for="level" class="block text-gray-700 font-medium mb-2">Level</label>
            <select name="level" id="level" class="form-control" required>
            
                <option value="Beginner" {{ $course->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="Intermediate" {{ $course->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="Expert" {{ $course->level == 'Expert' ? 'selected' : '' }}>Expert</option>
            
            </select>
        </div>

        <!-- Tags Input -->
        <div class="mb-3">
            <label>Tags</label>
            <div id="tags-container" class="flex flex-wrap gap-2 border border-gray-300 rounded p-2 mb-2">
                <!-- Preload existing tags -->
            </div>
            <div class="flex">
                <input type="text" id="tag-input" placeholder="Type tag" class="form-control flex-1">
                <button type="button" id="add-tag" class="btn btn-primary ml-2">Add</button>
            </div>
            <input type="hidden" name="tags" id="tags-hidden" value="{{ $course->tags }}">
        </div>

        <!-- Link -->
        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="link" class="form-control" value="{{ $course->link }}">
        </div>

        <!-- YouTube Link -->
        <div class="mb-3">
            <label>YouTube Link</label>
            <input type="url" name="linkyoutube" class="form-control" value="{{ $course->linkyoutube }}">
        </div>

        <button type="submit" class="btn btn-success">Update Course</button>
    </form>
</div>

<!-- Tags JS -->
<script>
const tagInput = document.getElementById('tag-input');
const addTagBtn = document.getElementById('add-tag');
const tagsContainer = document.getElementById('tags-container');
const tagsHidden = document.getElementById('tags-hidden');

let tags = [];

@if($course->tags)
    tags = "{{ $course->tags }}".split(',');
@endif

function renderTags() {
    tagsContainer.innerHTML = '';
    tags.forEach((tag, index) => {
        const tagEl = document.createElement('span');
        tagEl.className = 'bg-gray-200 px-3 py-1 rounded flex items-center gap-2';
        tagEl.innerHTML = `${tag} <button type="button" class="btn-close text-red-600 font-bold" onclick="removeTag(${index})">&times;</button>`;
        tagsContainer.appendChild(tagEl);
    });
    tagsHidden.value = tags.join(',');
}

function removeTag(index) {
    tags.splice(index, 1);
    renderTags();
}

addTagBtn.addEventListener('click', () => {
    const value = tagInput.value.trim();
    if(value && !tags.includes(value)){
        tags.push(value);
        tagInput.value = '';
        renderTags();
    }
});

// Preload tags on page load
renderTags();

// Optional: Add tag on Enter key press
tagInput.addEventListener('keypress', (e) => {
    if(e.key === 'Enter'){
        e.preventDefault();
        addTagBtn.click();
    }
});
</script>
@endsection
