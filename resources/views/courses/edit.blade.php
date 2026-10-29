@extends('layouts.main')
@section('title', 'Edit Course')

@section('content')
    <div class="card">
        <h2>Edit course</h2>
        <form method="POST" action="{{ route('courses.update', $course) }}">
            @method('PUT')
            @include('courses._form')
        </form>
    </div>
@endsection
