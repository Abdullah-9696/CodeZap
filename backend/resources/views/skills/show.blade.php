@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Skill Details</h1>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $skill->title }}</h4>
            <p class="card-text">{{ $skill->description }}</p>
            <p><strong>Link:</strong> <a href="{{ $skill->link }}" target="_blank">{{ $skill->linkText }}</a></p>
        </div>
    </div>

    <a href="{{ route('skills.index') }}" class="btn btn-primary mt-3">Back to Skills</a>
</div>
@endsection
