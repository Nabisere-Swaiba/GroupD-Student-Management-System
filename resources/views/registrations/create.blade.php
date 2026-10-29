@extends('layouts.main')
@section('title', 'New Registration')

@section('content')
    <div class="card">
        <h2>Register for a course</h2>
        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf

            @can('manage registrations')
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">-- Select student --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->student_number }} - {{ $student->user->name }}
                        </option>
                    @endforeach
                </select>
            @endcan

            <label for="course_id">Course</label>
            <select id="course_id" name="course_id" required>
                <option value="">-- Select course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id', request('course_id')) == $course->id)>
                        {{ $course->code }} - {{ $course->title }}
                    </option>
                @endforeach
            </select>

            <p style="margin-top:16px">
                <button class="btn" type="submit">Register</button>
                <a class="btn btn-secondary" href="{{ route('registrations.index') }}">Cancel</a>
            </p>
        </form>
    </div>
@endsection
