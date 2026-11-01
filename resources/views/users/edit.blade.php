@extends('layouts.app')
@section('title', 'Change role')

@section('content')
<div class="page-head"><div><h1>Change role</h1><p>{{ $user->name }} · {{ $user->email }}</p></div></div>

<div class="card" style="max-width:520px">
    <form method="POST" action="{{ route('users.update', $user) }}" novalidate>
        @csrf @method('PUT')
        <label for="role">Role</label>
        <select id="role" name="role" required class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role', $user->roleName()) === $role->name)>{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>
        @error('role') <div class="field-error">{{ $message }}</div> @enderror
        <div class="form-actions">
            <button class="btn" type="submit">Save role</button>
            <a class="btn btn-ghost" href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
