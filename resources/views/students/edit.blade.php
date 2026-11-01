@extends('layouts.app')
@section('title', 'Edit student')

@section('content')
<div class="page-head"><div><h1>Edit {{ $student->full_name }}</h1><p>{{ $student->student_number }}</p></div></div>

<div class="card">
    <form method="POST" action="{{ route('students.update', $student) }}" novalidate>
        @csrf @method('PUT')
        @include('students._form')
        <div class="form-actions">
            <button class="btn" type="submit">Update student</button>
            <a class="btn btn-ghost" href="{{ route('students.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
