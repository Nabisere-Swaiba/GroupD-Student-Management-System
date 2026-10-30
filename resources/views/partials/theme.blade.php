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
    .accent{color:var(--teal)}

    /* Top navigation */
    .nav{position:sticky;top:0;z-index:50;background:rgba(251,248,242,.82);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)}
    .nav-inner{max-width:1100px;margin:0 auto;padding:12px 20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap}
    .brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--ink);font-weight:700;font-size:16px}
    .logo{width:28px;height:28px;border-radius:8px;display:grid;place-items:center;color:#fff;font-weight:800;font-size:14px;background:linear-gradient(135deg,var(--teal),#14a398)}
    .tag{font-family:var(--mono);font-size:10px;letter-spacing:.08em;text-transform:uppercase;padding:2px 8px;border-radius:999px;background:var(--teal-soft);color:var(--teal);border:1px solid rgba(15,118,110,.25);font-weight:500}
    .links{display:flex;gap:6px;flex:1;justify-content:center;flex-wrap:wrap}
    .links a{color:#374151;text-decoration:none;font-size:14px;font-weight:500;padding:7px 12px;border-radius:999px;transition:.15s}
    .links a:hover{background:rgba(17,24,39,.06);color:var(--ink)}
    .links a.active{background:var(--teal-soft);color:var(--teal)}
    .nav-right{display:flex;align-items:center;gap:10px}
    .nav-right .who{font-size:13px;color:var(--muted)}
    .nav-right a.plain{font-size:13px;color:#374151;text-decoration:none;font-weight:500}
    .nav-right a.plain:hover{color:var(--teal)}

    /* Buttons, labels, alerts */
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 14px;border:1px solid transparent;border-radius:10px;background:var(--amber);color:#2b1c03;text-decoration:none;font:600 13px 'Inter',sans-serif;cursor:pointer;transition:.15s}
    .btn:hover{background:var(--amber-dark);transform:translateY(-1px)}
    .btn-secondary{background:#fff;color:var(--ink);border-color:var(--line)}
    .btn-secondary:hover{background:#f6f3ec}
    .btn-danger{background:#fff;color:var(--danger);border-color:#f0c4c0}
    .btn-danger:hover{background:#fdeceb}
    .btn-sm{padding:6px 12px}
    .btn-block{width:100%;padding:11px 14px;font-size:14px}
    .eyebrow{display:inline-block;font-family:var(--mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;padding:5px 12px;border-radius:999px;background:var(--teal-soft);color:var(--teal);border:1px solid rgba(15,118,110,.25);margin-bottom:16px}
    .alert{padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:14px;border:1px solid}
    .success{background:#ecf8f0;color:var(--ok);border-color:#bfe3cc}
    .error{background:#fdf0ef;color:var(--danger);border-color:#f2c6c2}

    footer.site-footer{background:var(--navy);color:#9fb0c7;text-align:center;padding:18px;font-family:var(--mono);font-size:12px;letter-spacing:.03em}

    @media (max-width:720px){
        .links{order:3;flex-basis:100%;justify-content:flex-start}
        .nav-right .who{display:none}
    }
</style>
