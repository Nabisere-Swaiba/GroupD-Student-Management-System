@extends('layouts.app')
@section('title', 'Log in')

@section('content')
<div class="auth-wrap">
    <div class="card">
        <span class="pill"><span class="dot"></span> Secure sign-in</span>
        <h1 style="margin-top:.8rem">Welcome back</h1>
        <p class="muted">Log in to manage students, courses and registrations.</p>

        <form method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf
            <div style="margin-bottom:1rem">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
            </div>
            <div style="margin-bottom:1rem">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required
                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
            </div>
            <label style="display:flex;gap:.5rem;align-items:center;font-weight:500">
                <input type="checkbox" name="remember" style="width:auto"> Remember me
            </label>
            <div class="form-actions">
                <button class="btn" type="submit">Log in</button>
                <a class="btn btn-ghost" href="{{ route('home') }}">Cancel</a>
            </div>
        </form>

        <div class="demo">
            <strong>Demo accounts</strong> (password: <code>password</code>)<br>
            <code>admin@campus.desk.test</code> · Administrator<br>
            <code>peter.tumusiime@campus.desk.test</code> · Lecturer<br>
            <code>aisha.namukasa@campus.desk.test</code> · Student
        </div>
    </div>
</div>
@endsection
