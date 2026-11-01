@extends('layouts.app')
@section('title', 'Add student')

@section('content')
<div class="page-head"><div><h1>Add student</h1><p>Creates the student record and their login account.</p></div></div>

<div class="card">
    <form method="POST" action="{{ route('students.store') }}" novalidate>
        @csrf
        @include('students._form')
        <div class="form-actions">
            <button class="btn" type="submit">Save student</button>
            <a class="btn btn-ghost" href="{{ route('students.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
