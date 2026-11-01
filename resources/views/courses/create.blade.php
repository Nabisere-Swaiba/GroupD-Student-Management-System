@extends('layouts.app')
@section('title', 'Add course')

@section('content')
<div class="page-head"><div><h1>Add course</h1></div></div>
<div class="card">
    <form method="POST" action="{{ route('courses.store') }}" novalidate>
        @csrf
        @include('courses._form')
        <div class="form-actions">
            <button class="btn" type="submit">Save course</button>
            <a class="btn btn-ghost" href="{{ route('courses.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
