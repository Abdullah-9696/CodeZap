@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add New Course</h2>
    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf

        <!-- Title -->
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="control" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>


 <div class="box" 

style="display: flex; gap: 100px; flex-wrap: wrap;">
        <!-- Level Dropdown -->
         <!-- Level Dropdown -->
   <div class="mb-3">
            <label for="level" class="block text-gray-700 font-medium mb-2">Level</label>
            <<select name="level" id="level" class="w-full border border-gray-300 rounded px-3 py-2">
            
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Expert">Expert</option>
              
</select>

        </div>
        <!-- Platform -->
        <div class="mb-3">
            <label>Platform</label>
            <input type="text" name="platform" class="control">
        </div>
</div>
        <!-- App Level Dropdown -->
     

        <!-- Tags Input with Plus Function -->
        <div class="mb-3">
            <label>Tags</label>
            <div id="tags-container" class="flex flex-wrap gap-2 border border-gray-300 rounded p-2 mb-2">
                <!-- Added tags appear here -->
            </div>
            <div class="flex">
                <input type="text" id="tag-input" placeholder="Type tag" class="control flex-1">
                <button type="button" id="add-tag" class="btn btn-primary ml-2">Add</button>
            </div>
            <!-- Hidden input to submit tags as comma-separated -->
            <input type="hidden" name="tags" id="tags-hidden">
        </div>
   <div class="boxes" style="display: flex; gap: 100px; ">
        <!-- Link -->
        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="link" class="control">
    

        <!-- YouTube Link -->
        
            <label>YouTube Link</label>
            <input type="url" name="linkyoutube" class="control">
        </div>
        </div>

        <button type="submit" class="btn btn-success">Add Course</button>
    </form>
</div>


<!-- Tags JS -->
<script>
const tagInput = document.getElementById('tag-input');
const addTagBtn = document.getElementById('add-tag');
const tagsContainer = document.getElementById('tags-container');
const tagsHidden = document.getElementById('tags-hidden');

let tags = [];

function renderTags() {
    tagsContainer.innerHTML = '';
    tags.forEach((tag, index) => {
        const tagEl = document.createElement('span');
        tagEl.className = 'bg-gray-200 px-3 py-1 rounded flex items-center gap-2';
        tagEl.innerHTML = `
            ${tag} 
            <button type="button" class="btn-close text-red-600 font-bold" onclick="removeTag(${index})">&times;</button>
        `;
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
    if (value && !tags.includes(value)) {
        tags.push(value);
        tagInput.value = '';
        renderTags();
    }
});

// Optional: Add tag on Enter key press
tagInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        addTagBtn.click();
    }
});
</script>
@endsection