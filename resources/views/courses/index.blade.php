@extends('layouts.app')
@section('title', $heading)

@section('content')
<div class="page-head">
    <div><h1>{{ $heading }}</h1><p>{{ $courses->total() }} course(s).</p></div>
    @can('create courses')
        <a class="btn" href="{{ route('courses.create') }}">+ Add course</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Code</th><th>Title</th><th>Lecturer</th><th>Credits</th><th>Seats</th><th></th></tr>
            </thead>
            <tbody>
            @forelse ($courses as $course)
                @php
                    $full = $course->students_count >= $course->capacity;
                    $registered = in_array($course->id, $registeredIds);
                @endphp
                <tr>
                    <td><span class="tag">{{ $course->code }}</span></td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->lecturer?->name ?? '—' }}</td>
                    <td>{{ $course->credit_units }}</td>
                    <td>
                        {{ $course->students_count }} / {{ $course->capacity }}
                        @if ($full) <span class="badge badge-full">Full</span> @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('courses.show', $course) }}">View</a>

                            {{-- Student actions --}}
                            @can('register courses')
                                @if ($registered)
                                    <span class="badge badge-student">Registered</span>
                                @elseif (! $full)
                                    <form method="POST" action="{{ route('registrations.store') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button class="btn btn-sm" type="submit">Register</button>
                                    </form>
                                @endif
                            @endcan

                            {{-- Admin actions --}}
                            @can('edit courses')
                                <a class="btn btn-ghost btn-sm" href="{{ route('courses.edit', $course) }}">Edit</a>
                            @endcan
                            @can('delete courses')
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" class="inline"
                                      onsubmit="return confirm('Delete {{ $course->code }}? All its registrations will be removed.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No courses to show.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $courses->links() }}
</div>
@endsection
