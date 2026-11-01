@extends('layouts.app')
@section('title', 'Edit course')

@section('content')
<div class="page-head"><div><h1>Edit {{ $course->code }}</h1><p>{{ $course->title }}</p></div></div>
<div class="card">
    <form method="POST" action="{{ route('courses.update', $course) }}" novalidate>
        @csrf @method('PUT')
        @include('courses._form')
        <div class="form-actions">
            <button class="btn" type="submit">Update course</button>
            <a class="btn btn-ghost" href="{{ route('courses.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
