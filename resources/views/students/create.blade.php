@extends('layouts.main')
@section('title', 'Add Student')

@section('content')
    <div class="card">
        <h2>Add student</h2>
        <p style="font-size:13px;color:#555">A login account is created with the default password <code>password</code>.</p>
        <form method="POST" action="{{ route('students.store') }}">
            @include('students._form', ['student' => new \App\Models\Student])
        </form>
    </div>
@endsection
