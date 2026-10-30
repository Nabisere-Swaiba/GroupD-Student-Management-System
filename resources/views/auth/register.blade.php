<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="auth-head">
            <span class="eyebrow">Create account</span>
            <h1>Join <span class="accent">Student MS</span></h1>
            <p>Register as a student to view courses and register for them.</p>
        </div>

        @if ($errors->any())
            <div class="alert error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label class="f" for="name">Full name</label>
            <input class="f" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">

            <label class="f" for="email">Email</label>
            <input class="f" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">

            <label class="f" for="student_number">Student number</label>
            <input class="f" id="student_number" type="text" name="student_number" value="{{ old('student_number') }}" placeholder="e.g. STU/2026/006" required>

            <label class="f" for="programme">Programme</label>
            <input class="f" id="programme" type="text" name="programme" value="{{ old('programme') }}" placeholder="e.g. BBC" required>

            <label class="f" for="password">Password</label>
            <input class="f" id="password" type="password" name="password" required autocomplete="new-password">

            <label class="f" for="password_confirmation">Confirm password</label>
            <input class="f" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

            <div class="auth-row" style="justify-content:flex-end">
                <a href="{{ route('login') }}">Already registered? Log in</a>
            </div>

            <button type="submit" class="btn btn-block">Create account</button>
        </form>
    </x-authentication-card>
</x-guest-layout>
