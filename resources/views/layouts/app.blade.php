<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Welcome') · CampusDesk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

{{-- ============ HEADER + NAVIGATION ============ --}}
<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-mark">&gt;_</span> CampusDesk
        </a>

        <nav class="nav" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

            @auth
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

                @can('view students')
                    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
                @endcan

                @canany(['view courses', 'view assigned courses', 'view available courses'])
                    <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        @can('view assigned courses') My Courses @else Courses @endcan
                    </a>
                @endcanany

                @canany(['view registrations', 'view own registrations'])
                    <a href="{{ route('registrations.index') }}" class="{{ request()->routeIs('registrations.*') ? 'active' : '' }}">Registrations</a>
                @endcanany

                @can('manage users')
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
                @endcan
            @endauth
        </nav>

        <div class="header-actions">
            @auth
                <div class="user-chip">
                    {{ auth()->user()->name }}
                    <small>{{ auth()->user()->roleName() }}</small>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn">Log in</a>
            @endauth
        </div>
    </div>
</header>

{{-- ============ CONTENT ============ --}}
<main>
    <div class="container">
        @include('partials.flash')
        @yield('content')
    </div>
</main>

{{-- ============ FOOTER ============ --}}
<footer class="site-footer"> 
    <div class="container footer-inner">
        <span>&copy; {{ date('Y') }} CampusDesk · Student Management System</span>
        <span> <a href="https://laravel.com" target="_blank" rel="noopener"></a></span>
    </div>
</footer>
</body>
</html>
