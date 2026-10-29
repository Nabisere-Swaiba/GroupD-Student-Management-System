@extends('layouts.main')
@section('title', 'Courses')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <h2>
            @can('manage courses')
                All courses
            @elsecan('view assigned courses')
                My assigned courses
            @else
                Available courses
            @endcan
        </h2>
        @can('manage courses')
            <a class="btn" href="{{ route('courses.create') }}">+ Add course</a>
        @endcan
    </div>

    <table>
        <thead><tr><th>Code</th><th>Title</th><th>Credits</th><th>Lecturer</th><th>Students</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse ($courses as $course)
            <tr>
                <td>{{ $course->code }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ optional($course->lecturer)->name ?? 'Unassigned' }}</td>
                <td>{{ $course->students_count }}</td>
                <td>
                    @canany(['manage courses', 'view assigned courses'])
                        <a class="btn btn-secondary" href="{{ route('courses.show', $course) }}">Students</a>
                    @endcanany

                    @can('manage courses')
                        <a class="btn" href="{{ route('courses.edit', $course) }}">Edit</a>
                        <form method="POST" action="{{ route('courses.destroy', $course) }}" style="display:inline"
                              onsubmit="return confirm('Delete this course?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    @endcan

                    @cannot('manage courses')
                        @can('register courses')
                            @if ($registeredIds->contains($course->id))
                                <em>Registered</em>
                            @else
                                <form method="POST" action="{{ route('registrations.store') }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button class="btn" type="submit">Register</button>
                                </form>
                            @endif
                        @endcan
                    @endcannot
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No courses found.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $courses->links() }}</div>
@endsection
