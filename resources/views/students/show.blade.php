@extends('layouts.app')
@section('title', $student->full_name)

@section('content')
<div class="page-head">
    <div><h1>{{ $student->full_name }}</h1><p>{{ $student->student_number }} · {{ $student->programme }}</p></div>
    <a class="btn btn-ghost" href="{{ route('students.index') }}">&larr; Back</a>
</div>

<div class="grid grid-2">
    <div class="card">
        <h3>Profile</h3>
        <dl class="kv">
            <dt>Email</dt><dd>{{ $student->email }}</dd>
            <dt>Phone</dt><dd>{{ $student->phone ?? '—' }}</dd>
            <dt>Date of birth</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }}</dd>
            <dt>Programme</dt><dd>{{ $student->programme ?? '—' }}</dd>
        </dl>
    </div>

    <div class="card">
        <h3>Registered courses ({{ $student->courses->count() }})</h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Code</th><th>Title</th><th>Lecturer</th></tr></thead>
                <tbody>
                @forelse ($student->courses as $course)
                    <tr>
                        <td><span class="tag">{{ $course->code }}</span></td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->lecturer?->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty">Not registered for any course.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
