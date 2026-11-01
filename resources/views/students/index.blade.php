@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="page-head">
    <div>
        <h1>Students</h1>
        <p>{{ $students->total() }} student(s) on record.</p>
    </div>
    <div style="display:flex;gap:.6rem;flex-wrap:wrap">
        <form method="GET" action="{{ route('students.index') }}" class="search">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search name, number, email">
            <button class="btn btn-ghost" type="submit">Search</button>
        </form>
        @can('create students')
            <a class="btn" href="{{ route('students.create') }}">+ Add student</a>
        @endcan
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Number</th><th>Name</th><th>Email</th><th>Courses</th><th></th></tr>
            </thead>
            <tbody>
            @forelse ($students as $student)
                <tr>
                    <td><span class="tag">{{ $student->student_number }}</span></td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->courses_count }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-ghost btn-sm" href="{{ route('students.show', $student) }}">View</a>
                            @can('edit students')
                                <a class="btn btn-ghost btn-sm" href="{{ route('students.edit', $student) }}">Edit</a>
                            @endcan
                            @can('delete students')
                                <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline"
                                      onsubmit="return confirm('Delete {{ addslashes($student->full_name) }}? Their registrations will also be removed.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No students found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $students->links() }}
</div>
@endsection
