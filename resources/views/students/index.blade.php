@extends('layouts.main')
@section('title', 'Students')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <h2>Students</h2>
        @can('manage students')
            <a class="btn" href="{{ route('students.create') }}">+ Add student</a>
        @endcan
    </div>

    <table>
        <thead><tr><th>Number</th><th>Name</th><th>Email</th><th>Programme</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->student_number }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->programme }}</td>
                <td>
                    @can('manage students')
                        <a class="btn" href="{{ route('students.edit', $student) }}">Edit</a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" style="display:inline"
                              onsubmit="return confirm('Delete this student?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No students found.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $students->links() }}</div>
@endsection
