@extends('layouts.app')
@section('title', 'Access denied')

@section('content')
    <div class="card auth-wrap" style="text-align:center">
        <span class="pill"><span class="dot"></span> 403 · Forbidden</span>
        <h1 style="margin-top:1rem">Access denied</h1>
        <p class="muted">
            {{ $exception->getMessage() ?: 'You do not have permission to view this page or record.' }}
        </p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn">Back to dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn">Log in</a>
        @endauth
    </div>
@endsection
