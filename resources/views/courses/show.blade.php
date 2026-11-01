@extends('layouts.app')
@section('title', $course->code)

@section('content')
<div class="page-head">
    <div><h1>{{ $course->code }} — {{ $course->title }}</h1><p>Lecturer: {{ $course->lecturer?->name ?? 'Not assigned' }}</p></div>
    <a class="btn btn-ghost" href="{{ route('courses.index') }}">&larr; Back</a>
</div>

<div class="grid grid-2" style="margin-bottom:1.25rem">
    <div class="card">
        <h3>About this course</h3>
        <p class="muted">{{ $course->description ?: 'No description provided.' }}</p>
        <dl class="kv">
            <dt>Credit units</dt><dd>{{ $course->credit_units }}</dd>
            <dt>Capacity</dt><dd>{{ $course->capacity }} students</dd>
        </dl>
    </div>

    @can('register courses')
        <div class="card">
            <h3>Registration</h3>
            @if ($isRegistered)
                <p><span class="badge badge-student">You are registered for this course</span></p>
            @elseif ($course->isFull())
                <p><span class="badge badge-full">This course is full</span></p>
            @else
                <p class="muted">Seats are available. Register to secure your place.</p>
                <form method="POST" action="{{ route('registrations.store') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button class="btn" type="submit">Register for this course</button>
                </form>
            @endif
        </div>
    @endcan
</div>

@if ($canSeeStudents)
    <div class="card">
        <h3>Registered students ({{ $students->count() }})</h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Number</th><th>Name</th><th>Email</th><th>Registered</th></tr></thead>
                <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td><span class="tag">{{ $student->student_number }}</span></td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($student->pivot->registered_at)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">No students registered yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
