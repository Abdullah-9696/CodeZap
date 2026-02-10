@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">{{ $course->title }}</h1>
    <p class="mb-4">{{ $course->description }}</p>
    @if($course->link)
        <a href="{{ $course->link }}" class="text-blue-500 hover:underline" target="_blank">Visit Link</a>
    @endif
    <div class="mt-4">
        <a href="{{ route('courses.index') }}" class="text-gray-700 hover:underline">Back to Courses</a>
    </div>
</div>
@endsection
