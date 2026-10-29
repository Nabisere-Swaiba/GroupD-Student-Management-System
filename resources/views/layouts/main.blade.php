<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Student Management System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#fbf8f2; --surface:#ffffff; --ink:#111827; --muted:#6b7280; --line:#e8e3d8;
            --teal:#0f766e; --teal-soft:rgba(15,118,110,.09);
            --amber:#f0a62b; --amber-dark:#d9901a;
            --navy:#1b2433; --danger:#b42318; --ok:#17613a;
            --radius:14px;
            --mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
        }
        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            margin:0; min-height:100vh; display:flex; flex-direction:column;
            font-family:'Inter',system-ui,-apple-system,'Segoe UI',Arial,sans-serif;
            color:var(--ink); line-height:1.55;
            background:
                radial-gradient(900px 420px at 12% -8%, rgba(15,118,110,.10), transparent 60%),
                radial-gradient(800px 380px at 92% -4%, rgba(240,166,43,.14), transparent 60%),
                var(--bg);
            background-repeat:no-repeat;
        }
        a{color:var(--teal)}

        /* ---------- Top navigation ---------- */
        .nav{position:sticky;top:0;z-index:50;background:rgba(251,248,242,.82);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
        .nav-inner{max-width:1100px;margin:0 auto;padding:12px 20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap}
        .brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--ink);font-weight:700;font-size:16px}
        .logo{width:28px;height:28px;border-radius:8px;display:grid;place-items:center;color:#fff;font-weight:800;font-size:14px;background:linear-gradient(135deg,var(--teal),#14a398)}
        .tag{font-family:var(--mono);font-size:10px;letter-spacing:.08em;text-transform:uppercase;padding:2px 8px;border-radius:999px;background:var(--teal-soft);color:var(--teal);border:1px solid rgba(15,118,110,.25);font-weight:500}
        .links{display:flex;gap:6px;flex:1;justify-content:center;flex-wrap:wrap}
        .links a{color:#374151;text-decoration:none;font-size:14px;font-weight:500;padding:7px 12px;border-radius:999px;transition:.15s}
        .links a:hover{background:rgba(17,24,39,.06);color:var(--ink)}
        .nav-right{display:flex;align-items:center;gap:10px}
        .nav-right .who{font-size:13px;color:var(--muted)}
        .nav-right a.plain{font-size:13px;color:#374151;text-decoration:none;font-weight:500}
        .nav-right a.plain:hover{color:var(--teal)}

        /* ---------- Page container ---------- */
        .container{flex:1;width:100%;max-width:1100px;margin:32px auto 48px;padding:0 20px}
        h1,h2,h3{letter-spacing:-.02em;color:var(--ink)}
        h1{font-size:clamp(30px,5vw,48px);line-height:1.1;font-weight:800;margin:0 0 12px}
        h2{font-size:26px;font-weight:700;margin:0}
        h3{font-size:18px;font-weight:700;margin:28px 0 12px}
        .accent{color:var(--teal)}

        /* ---------- Cards, buttons ---------- */
        .card{background:var(--surface);padding:24px;border-radius:var(--radius);border:1px solid var(--line);box-shadow:0 1px 2px rgba(17,24,39,.04),0 8px 24px rgba(17,24,39,.04);margin-bottom:18px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 14px;border:1px solid transparent;border-radius:10px;background:var(--amber);color:#2b1c03;text-decoration:none;font:600 13px 'Inter',sans-serif;cursor:pointer;transition:.15s}
        .btn:hover{background:var(--amber-dark);transform:translateY(-1px)}
        .btn-secondary{background:#fff;color:var(--ink);border-color:var(--line)}
        .btn-secondary:hover{background:#f6f3ec}
        .btn-danger{background:#fff;color:var(--danger);border-color:#f0c4c0}
        .btn-danger:hover{background:#fdeceb}
        .btn-sm{padding:6px 12px}

        /* ---------- Tables ---------- */
        table{width:100%;border-collapse:separate;border-spacing:0;background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;box-shadow:0 8px 24px rgba(17,24,39,.04)}
        th,td{padding:13px 16px;text-align:left;font-size:14px;border-bottom:1px solid var(--line);vertical-align:middle}
        th{font-family:var(--mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);font-weight:500;background:#faf7f0}
        tbody tr:last-child td{border-bottom:0}
        tbody tr:hover td{background:#fdfbf6}
        td .btn{margin-right:4px}

        /* ---------- Alerts ---------- */
        .alert{padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:14px;border:1px solid}
        .success{background:#ecf8f0;color:var(--ok);border-color:#bfe3cc}
        .error{background:#fdf0ef;color:var(--danger);border-color:#f2c6c2}

        /* ---------- Forms ---------- */
        label{display:block;margin:16px 0 6px;font-weight:600;font-size:13px;color:#374151}
        input,select,textarea{width:100%;padding:10px 12px;border:1px solid #d9d3c6;border-radius:10px;background:#fff;font:400 14px 'Inter',sans-serif;color:var(--ink);transition:.15s}
        input:focus,select:focus,textarea:focus{outline:0;border-color:var(--teal);box-shadow:0 0 0 3px rgba(15,118,110,.15)}
        code{font-family:var(--mono);font-size:12px;background:var(--teal-soft);color:var(--teal);padding:2px 6px;border-radius:6px}

        /* ---------- Dashboard pieces ---------- */
        .eyebrow{display:inline-block;font-family:var(--mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;padding:5px 12px;border-radius:999px;background:var(--teal-soft);color:var(--teal);border:1px solid rgba(15,118,110,.25);margin-bottom:16px}
        .hero{text-align:center;padding:36px 0 28px}
        .hero p{color:var(--muted);max-width:560px;margin:0 auto}
        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-bottom:24px}
        .cards .card{margin:0;display:flex;flex-direction:column;gap:6px}
        .cards .card h3{margin:0;font-size:16px}
        .cards .card p{margin:0;font-size:13px;color:var(--muted);flex:1}
        .cards .card .more{font-family:var(--mono);font-size:12px;color:var(--teal);text-decoration:none;margin-top:6px}
        .cards .card:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(17,24,39,.08)}
        .cards .card{transition:.15s}
        .band{display:flex;flex-wrap:wrap;background:var(--navy);border-radius:18px;padding:12px 8px;margin-bottom:24px}
        .stat{flex:1;min-width:170px;text-align:center;padding:20px 12px;color:#fff}
        .stat strong{display:block;font-size:38px;font-weight:800;letter-spacing:-.02em;color:#fff}
        .stat span{font-family:var(--mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#9fb0c7}

        /* ---------- Footer ---------- */
        footer{background:var(--navy);color:#9fb0c7;text-align:center;padding:18px;font-family:var(--mono);font-size:12px;letter-spacing:.03em}

        .pagination{margin-top:16px}
        .pagination svg{width:16px;height:16px}

        @media (max-width:720px){
            .links{order:3;flex-basis:100%;justify-content:flex-start}
            .nav-right .who{display:none}
            th,td{padding:10px}
        }
    </style>
</head>
<body>
    <header class="nav">
        <div class="nav-inner">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="logo">S</span> Student MS
                @auth
                    <span class="tag">{{ auth()->user()->getRoleNames()->first() }}</span>
                @endauth
            </a>

            @auth
                <nav class="links">
                    <a href="{{ route('dashboard') }}">Dashboard</a>

                    @can('manage students')
                        <a href="{{ route('students.index') }}">Students</a>
                    @endcan

                    @canany(['manage courses', 'view assigned courses', 'view available courses'])
                        <a href="{{ route('courses.index') }}">Courses</a>
                    @endcanany

                    @canany(['manage registrations', 'view own registrations'])
                        <a href="{{ route('registrations.index') }}">Registrations</a>
                    @endcanany
                </nav>

                <div class="nav-right">
                    <span class="who">{{ auth()->user()->name }}</span>
                    <a class="plain" href="{{ route('profile.show') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
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

        @yield('content')
    </main>

    <footer>&copy; {{ date('Y') }} Makerere University Business School</footer>
</body>
</html>
