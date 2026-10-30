<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Student Management System</title>

    @include('partials.theme')

    <style>
        a{color:var(--teal)}
        .container{flex:1;width:100%;max-width:1100px;margin:32px auto 48px;padding:0 20px}
        h1,h2,h3{letter-spacing:-.02em;color:var(--ink)}
        h1{font-size:clamp(30px,5vw,48px);line-height:1.1;font-weight:800;margin:0 0 12px}
        h2{font-size:26px;font-weight:700;margin:0}
        h3{font-size:18px;font-weight:700;margin:28px 0 12px}

        .card{background:var(--surface);padding:24px;border-radius:var(--radius);border:1px solid var(--line);box-shadow:0 1px 2px rgba(17,24,39,.04),0 8px 24px rgba(17,24,39,.04);margin-bottom:18px}

        table{width:100%;border-collapse:separate;border-spacing:0;background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;box-shadow:0 8px 24px rgba(17,24,39,.04)}
        th,td{padding:13px 16px;text-align:left;font-size:14px;border-bottom:1px solid var(--line);vertical-align:middle}
        th{font-family:var(--mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);font-weight:500;background:#faf7f0}
        tbody tr:last-child td{border-bottom:0}
        tbody tr:hover td{background:#fdfbf6}
        td .btn{margin-right:4px}

        label{display:block;margin:16px 0 6px;font-weight:600;font-size:13px;color:#374151}
        input,select,textarea{width:100%;padding:10px 12px;border:1px solid #d9d3c6;border-radius:10px;background:#fff;font:400 14px 'Inter',sans-serif;color:var(--ink);transition:.15s}
        input:focus,select:focus,textarea:focus{outline:0;border-color:var(--teal);box-shadow:0 0 0 3px rgba(15,118,110,.15)}
        code{font-family:var(--mono);font-size:12px;background:var(--teal-soft);color:var(--teal);padding:2px 6px;border-radius:6px}

        .hero{text-align:center;padding:36px 0 28px}
        .hero p{color:var(--muted);max-width:560px;margin:0 auto}
        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-bottom:24px}
        .cards .card{margin:0;display:flex;flex-direction:column;gap:6px;transition:.15s}
        .cards .card h3{margin:0;font-size:16px}
        .cards .card p{margin:0;font-size:13px;color:var(--muted);flex:1}
        .cards .card .more{font-family:var(--mono);font-size:12px;color:var(--teal);margin-top:6px}
        .cards .card:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(17,24,39,.08)}
        .band{display:flex;flex-wrap:wrap;background:var(--navy);border-radius:18px;padding:12px 8px;margin-bottom:24px}
        .stat{flex:1;min-width:170px;text-align:center;padding:20px 12px;color:#fff}
        .stat strong{display:block;font-size:38px;font-weight:800;letter-spacing:-.02em;color:#fff}
        .stat span{font-family:var(--mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#9fb0c7}

        .pagination{margin-top:16px}
        .pagination svg{width:16px;height:16px}
        @media (max-width:720px){ th,td{padding:10px} }
    </style>
</head>
<body>
    @include('partials.nav')

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

    <footer class="site-footer">&copy; {{ date('Y') }} Makerere University Business School &middot; BUC3131 Coursework Two</footer>
</body>
</html>
