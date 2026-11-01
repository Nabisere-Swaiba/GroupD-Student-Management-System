@extends('layouts.app')
@section('title', $heading)

@section('content')
<div class="page-head">
    <div><h1>{{ $heading }}</h1><p>{{ $registrations->total() }} registration(s).</p></div>
    @can('manage registrations')
        <a class="btn" href="{{ route('registrations.create') }}">+ New registration</a>
    @endcan
    @can('register courses')
        <a class="btn" href="{{ route('courses.index') }}">Browse courses</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    @can('view registrations') <th>Student</th> @endcan
                    <th>Course</th><th>Lecturer</th><th>Registered</th><th></th>
                </tr>
            </thead>
            <tbody>
            @forelse ($registrations as $r)
                <tr>
                    @can('view registrations')
                        <td>{{ $r->student->full_name }} <small>({{ $r->student->student_number }})</small></td>
                    @endcan
                    <td><span class="tag">{{ $r->course->code }}</span> {{ $r->course->title }}</td>
                    <td>{{ $r->course->lecturer?->name ?? '—' }}</td>
                    <td>{{ $r->registered_at?->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            @can('delete', $r)
                                <form method="POST" action="{{ route('registrations.destroy', $r) }}" class="inline"
                                      onsubmit="return confirm('Remove this registration?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Remove</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No registrations yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $registrations->links() }}
</div>
@endsection
