@extends('layouts.admin')

@section('content')
    <h1>All Skills (Frontend)</h1>
    <ul class="list-group">
        @foreach($skills as $skill)
            <li class="list-group-item">
                <strong>{{ $skill->title }}</strong>
                <p>{{ $skill->description }}</p>
            </li>
        @endforeach
    </ul>
@endsection
