@extends('layouts.app')
@section('title', 'User access')

@section('content')
<div class="page-head"><div><h1>User access</h1><p>Control who can do what in the system.</p></div></div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th></th></tr></thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @forelse ($user->roles as $role)
                            <span class="badge badge-{{ $role->name }}">{{ $role->name }}</span>
                        @empty
                            <span class="badge">none</span>
                        @endforelse
                    </td>
                    <td class="actions"><a class="btn btn-ghost btn-sm" href="{{ route('users.edit', $user) }}">Change role</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection
