@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Edit Course</h1>

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.update', $course->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="form-group w-full">
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" class="form-control w-full border p-2 rounded" value="{{ $course->title }}" required>
        </div>

        {{-- Description --}}
        <div class="form-group w-full">
            <label class="block mb-1 font-semibold">Description</label>
            <input type="text" name="description" class="control w-full border p-2 rounded" value="{{ $course->description }}" required>
        </div>

        {{-- Platform + Level (same line) --}}
        <div class="form-group w-full flex gap-2">
            <div class="flex-1">
                <label class="block mb-1 font-semibold">Platform</label>
                <input type="text" name="platform" class="form-control w-full border p-2 rounded" value="{{ $course->platform }}" required>
            </div>
            <div style="width: 100px;">
                <label class="block mb-1 font-semibold">Level</label>
                <input type="text" name="level" class="form-control w-full border p-2 rounded" value="{{ $course->level }}">
            </div>
        </div>

        {{-- Tags --}}
        <div class="form-group w-full">
            <label class="block mb-1 font-semibold">Tags</label>
            <input type="text" name="tags" class="form-control w-full border p-2 rounded" value="{{ $course->tags }}">
        </div>

        {{-- Link --}}
        <div class="form-group w-full">
            <label class="block mb-1 font-semibold">Link (optional)</label>
            <input type="url" name="link" class="form-control w-full border p-2 rounded" value="{{ $course->link }}">
        </div>

        {{-- YouTube Link --}}
        <div class="form-group w-full">
            <label class="block mb-1 font-semibold">YouTube Link (optional)</label>
            <input type="url" name="linkyoutube" class="form-control w-full border p-2 rounded" value="{{ $course->linkyoutube }}">
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
