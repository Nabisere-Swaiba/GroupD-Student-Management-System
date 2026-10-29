@extends('layouts.main')
@section('title', 'Add Course')

@section('content')
    <div class="card">
        <h2>Add course</h2>
        <form method="POST" action="{{ route('courses.store') }}">
            @include('courses._form', ['course' => new \App\Models\Course])
        </form>
    </div>
@endsection
