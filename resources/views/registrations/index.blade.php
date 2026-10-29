@extends('layouts.main')
@section('title', 'Registrations')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <h2>
            @can('manage registrations')
                All registrations
            @else
                My registrations
            @endcan
        </h2>
        @canany(['manage registrations', 'register courses'])
            <a class="btn" href="{{ route('registrations.create') }}">+ New registration</a>
        @endcanany
    </div>

    <table>
        <thead>
        <tr>
            @can('manage registrations')<th>Student</th>@endcan
            <th>Course</th><th>Registered on</th><th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($registrations as $registration)
            <tr>
                @can('manage registrations')
                    <td>{{ $registration->student->student_number }} - {{ $registration->student->user->name }}</td>
                @endcan
                <td>{{ $registration->course->code }} - {{ $registration->course->title }}</td>
                <td>{{ optional($registration->registered_at)->format('d M Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('registrations.destroy', $registration) }}" style="display:inline"
                          onsubmit="return confirm('Remove this registration?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No registrations found.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $registrations->links() }}</div>
@endsection
