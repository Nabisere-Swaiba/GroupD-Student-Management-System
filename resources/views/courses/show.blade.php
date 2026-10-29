@extends('layouts.main')
@section('title', $course->code)

@section('content')
    <div class="card">
        <h2>{{ $course->code }} &mdash; {{ $course->title }}</h2>
        <p>Lecturer: {{ optional($course->lecturer)->name ?? 'Unassigned' }} | Credits: {{ $course->credits }}</p>
        <p>{{ $course->description }}</p>
    </div>

    <h3>Registered students ({{ $course->students->count() }})</h3>
    <table>
        <thead><tr><th>Number</th><th>Name</th><th>Email</th><th>Programme</th><th>Registered on</th></tr></thead>
        <tbody>
        @forelse ($course->students as $student)
            <tr>
                <td>{{ $student->student_number }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->programme }}</td>
                <td>{{ optional($student->pivot->registered_at ? \Illuminate\Support\Carbon::parse($student->pivot->registered_at) : null)->format('d M Y') }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No students registered yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <p><a class="btn btn-secondary" href="{{ route('courses.index') }}">&larr; Back</a></p>
@endsection
