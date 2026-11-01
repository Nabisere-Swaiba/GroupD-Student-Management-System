@extends('layouts.app')
@section('title', 'Home')

@section('content')
{{-- ============ HERO ============ --}}
<section class="hero">
    <span class="pill"><span class="dot"></span> Semester I · 2026/2027 registration is open</span>

    <div class="terminal">
        <div class="terminal-bar"><span></span><span></span><span></span></div>
        <div class="terminal-body">
            <div class="prompt">&gt; what do you need to manage today?</div>
            <a class="term-opt" href="{{ auth()->check() ? route('dashboard') : route('login') }}"><b>1</b> manage students &amp; user access</a>
            <a class="term-opt" href="{{ auth()->check() ? route('dashboard') : route('login') }}"><b>2</b> manage courses &amp; lecturers</a>
            <a class="term-opt" href="{{ auth()->check() ? route('dashboard') : route('login') }}"><b>3</b> register for a course</a>
        </div>
    </div>

    <div class="hero-cards">
        <div class="tile dark">
            <div class="big">{{ $stats['students'] }}</div>
            <div class="sm">students enrolled</div>
        </div>
        <div class="tile photo" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 9 12 4 2 9l10 5 10-5Z"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/><path d="M22 9v6"/>
            </svg>
        </div>
        <div class="tile lime">
            <div class="big">{{ $stats['courses'] }}</div>
            <div class="sm">courses on offer</div>
        </div>
        <div class="tile code">
<span>$student</span><span>&nbsp;&nbsp;->courses()</span><span>&nbsp;&nbsp;->get();</span>
        </div>
    </div>

    
</section>

{{-- ============ LECTURERS ============ --}}
<section>
    <div class="section-title">
        <span class="pill">Our lecturers</span>
        <h2 style="font-size:1.9rem">Specialists, not generalists.</h2>
        <p class="muted">Every course has a dedicated lecturer who knows the subject inside out.</p>
    </div>

    <div class="grid">
        @forelse ($lecturers as $lecturer)
            <article class="person">
                <div class="avatar">{{ $lecturer->initials }}</div>
                <div class="person-body">
                    <div class="person-top">
                        <div>
                            <h3>{{ $lecturer->name }}</h3>
                            <small>Lecturer · Makerere University Business School</small>
                        </div>
                        <a class="btn btn-ghost btn-sm" href="{{ auth()->check() ? route('courses.index') : route('login') }}">Browse courses</a>
                    </div>
                    <div class="person-stats">
                        <div><b>{{ $lecturer->courses->count() }}</b><small>courses taught</small></div>
                        <div><b>{{ $lecturer->courses->sum('students_count') }}</b><small>registered students</small></div>
                    </div>
                    <div>
                        @foreach ($lecturer->courses as $course)
                            <span class="tag">{{ $course->code }}</span>
                        @endforeach
                    </div>
                </div>
            </article>
        @empty
            <div class="card empty">No lecturers yet. Run <code>php artisan migrate:fresh --seed</code>.</div>
        @endforelse
    </div>
</section>
@endsection
