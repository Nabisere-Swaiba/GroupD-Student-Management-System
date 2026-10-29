@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <section class="hero">
        <span class="eyebrow">{{ auth()->user()->getRoleNames()->implode(', ') ?: 'no role' }} &middot; dashboard</span>
        <h1>Welcome, <span class="accent">{{ auth()->user()->name }}</span></h1>
        <p>Role: <strong>{{ auth()->user()->getRoleNames()->implode(', ') ?: 'none' }}</strong></p>
    </section>

    <div class="band">
        @foreach ($stats as $label => $value)
            <div class="stat"><strong>{{ $value }}</strong><span>{{ $label }}</span></div>
        @endforeach
    </div>

    <div class="cards">
        @can('manage students')
            <a class="card" href="{{ route('students.index') }}" style="text-decoration:none;color:inherit">
                <h3>Students</h3>
                <p>View, add, edit and remove student records.</p>
                <span class="more">Open students &rarr;</span>
            </a>
        @endcan

        @canany(['manage courses', 'view assigned courses', 'view available courses'])
            <a class="card" href="{{ route('courses.index') }}" style="text-decoration:none;color:inherit">
                <h3>Courses</h3>
                <p>Browse course units and their details.</p>
                <span class="more">Open courses &rarr;</span>
            </a>
        @endcanany

        @canany(['manage registrations', 'view own registrations'])
            <a class="card" href="{{ route('registrations.index') }}" style="text-decoration:none;color:inherit">
                <h3>Registrations</h3>
                <p>See and manage course registrations.</p>
                <span class="more">Open registrations &rarr;</span>
            </a>
        @endcanany
    </div>
@endsection
