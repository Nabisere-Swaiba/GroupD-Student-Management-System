<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="auth-head">
            <span class="eyebrow">Sign in</span>
            <h1>Welcome <span class="accent">back</span></h1>
            <p>Log in to manage students, courses and registrations.</p>
        </div>

        @if (session('status'))
            <div class="alert success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label class="f" for="email">Email</label>
            <input class="f" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">

            <label class="f" for="password">Password</label>
            <input class="f" id="password" type="password" name="password" required autocomplete="current-password">

            <div class="auth-row">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember"> Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-block">Log in</button>

            @if (Route::has('register'))
                <p style="text-align:center;margin:18px 0 0;font-size:13px;color:var(--muted)">
                    New student? <a href="{{ route('register') }}" style="color:var(--teal);font-weight:600;text-decoration:none">Create an account</a>
                </p>
            @endif
        </form>
    </x-authentication-card>
</x-guest-layout>
