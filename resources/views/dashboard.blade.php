@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1>Hello, {{ auth()->user()->name }}</h1>
        <p>You are signed in as <span class="badge badge-{{ auth()->user()->roleName() }}">{{ auth()->user()->roleName() }}</span></p>
    </div>
</div>

{{-- ================= ADMIN ================= --}}
@if ($mode === 'admin')
    <div class="grid grid-4" style="margin-bottom:1.5rem">
        <div class="stat"><div class="num">{{ $stats['students'] }}</div><div class="lbl">Students</div></div>
        <div class="stat lime"><div class="num">{{ $stats['courses'] }}</div><div class="lbl">Courses</div></div>
        <div class="stat white"><div class="num">{{ $stats['registrations'] }}</div><div class="lbl">Registrations</div></div>
        <div class="stat"><div class="num">{{ $stats['users'] }}</div><div class="lbl">User accounts</div></div>
    </div>

    <div class="card">
        <div class="page-head" style="margin-bottom:1rem">
            <h2 style="margin:0">Latest registrations</h2>
            @can('manage registrations')
                <a class="btn btn-sm" href="{{ route('registrations.create') }}">+ New registration</a>
            @endcan
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Student</th><th>Course</th><th>Registered</th></tr></thead>
                <tbody>
                @forelse ($latest as $r)
                    <tr>
                        <td>{{ $r->student->full_name }}</td>
                        <td><span class="tag">{{ $r->course->code }}</span> {{ $r->course->title }}</td>
                        <td>{{ $r->registered_at?->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty">No registrations yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{-- ================= LECTURER ================= --}}
@elseif ($mode === 'lecturer')
    <div class="card">
        <h2>My assigned courses</h2>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Code</th><th>Title</th><th>Students</th><th></th></tr></thead>
                <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td><span class="tag">{{ $course->code }}</span></td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->students_count }} / {{ $course->capacity }}</td>
                        <td class="actions"><a class="btn btn-ghost btn-sm" href="{{ route('courses.show', $course) }}">View students</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">No courses have been assigned to you yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{-- ================= STUDENT ================= --}}
@else
    @if (! $student)
        <div class="alert alert-error">Your account has no student profile yet. Please contact the administrator.</div>
    @else
        <div class="grid grid-3" style="margin-bottom:1.5rem">
            <div class="stat"><div class="num">{{ $myCourses->count() }}</div><div class="lbl">Courses registered</div></div>
            <div class="stat lime"><div class="num">{{ $myCourses->sum('credit_units') }}</div><div class="lbl">Credit units</div></div>
            <div class="stat white"><div class="num" style="font-size:1.2rem">{{ $student->student_number }}</div><div class="lbl">Student number</div></div>
        </div>

        <div class="card">
            <div class="page-head" style="margin-bottom:1rem">
                <h2 style="margin:0">My courses</h2>
                <a class="btn btn-sm" href="{{ route('courses.index') }}">Browse available courses</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Code</th><th>Title</th><th>Lecturer</th><th>Credits</th></tr></thead>
                    <tbody>
                    @forelse ($myCourses as $course)
                        <tr>
                            <td><span class="tag">{{ $course->code }}</span></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->lecturer?->name ?? '—' }}</td>
                            <td>{{ $course->credit_units }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty">You have not registered for any course yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endif
@endsection
