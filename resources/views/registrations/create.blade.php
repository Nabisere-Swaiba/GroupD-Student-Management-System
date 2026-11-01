@extends('layouts.app')
@section('title', 'New registration')

@section('content')
<div class="page-head"><div><h1>New registration</h1><p>Register a student for a course.</p></div></div>

<div class="card">
    <form method="POST" action="{{ route('registrations.store') }}" novalidate>
        @csrf
        <div class="form-grid">
            <div>
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required class="{{ $errors->has('student_id') ? 'is-invalid' : '' }}">
                    <option value="">— Select student —</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->full_name }} ({{ $student->student_number }})
                        </option>
                    @endforeach
                </select>
                @error('student_id') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="course_id">Course</label>
                <select id="course_id" name="course_id" required class="{{ $errors->has('course_id') ? 'is-invalid' : '' }}">
                    <option value="">— Select course —</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                            {{ $course->code }} — {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Register student</button>
            <a class="btn btn-ghost" href="{{ route('registrations.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
