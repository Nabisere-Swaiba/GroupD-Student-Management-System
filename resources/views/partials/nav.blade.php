<header class="nav">
    <div class="nav-inner">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="logo">S</span> Student Management System
            @auth
                <span class="tag">{{ auth()->user()->getRoleNames()->first() }}</span>
            @endauth
        </a>

        @auth
            <nav class="links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

                @can('manage students')
                    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
                @endcan

                @canany(['manage courses', 'view assigned courses', 'view available courses'])
                    <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Courses</a>
                @endcanany

                @canany(['manage registrations', 'view own registrations'])
                    <a href="{{ route('registrations.index') }}" class="{{ request()->routeIs('registrations.*') ? 'active' : '' }}">Registrations</a>
                @endcanany
            </nav>

            <div class="nav-right">
                <span class="who">{{ auth()->user()->name }}</span>
                <a class="plain" href="{{ route('profile.show') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-sm">Logout</button>
                </form>
            </div>
        @endauth
    </div>
</header>
