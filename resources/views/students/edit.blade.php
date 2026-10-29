@extends('layouts.main')
@section('title', 'Edit Student')

@section('content')
    <div class="card">
        <h2>Edit student</h2>
        <form method="POST" action="{{ route('students.update', $student) }}">
            @method('PUT')
            @include('students._form')
        </form>
    </div>
@endsection
