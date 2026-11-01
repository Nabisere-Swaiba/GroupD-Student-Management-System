<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('permission:manage users')];
    }

    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own administrator access.');
        }

        $user->syncRoles([$data['role']]);

        return redirect()->route('users.index')
            ->with('success', "{$user->name} is now a {$data['role']}.");
    }
}
