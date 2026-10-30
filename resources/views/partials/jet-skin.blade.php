<style>
    /* Re-colours Jetstream's built-in forms (profile, password, 2FA...) to match the theme */
    body, .font-sans{font-family:'Inter',system-ui,-apple-system,'Segoe UI',Arial,sans-serif !important}
    .bg-gray-100{background:transparent !important}
    .bg-gray-50{background:#faf7f0 !important}

    /* primary buttons (x-button) */
    .bg-gray-800{background:var(--amber) !important;color:#2b1c03 !important;border-radius:10px !important;text-transform:none !important;letter-spacing:0 !important;font-size:13px !important;font-weight:600 !important}
    .bg-gray-800:hover,.hover\:bg-gray-700:hover{background:var(--amber-dark) !important}
    /* secondary buttons */
    button.bg-white.border-gray-300{border-radius:10px !important;text-transform:none !important;letter-spacing:0 !important;font-size:13px !important;font-weight:600 !important;color:var(--ink) !important}

    /* inputs */
    input.border-gray-300,select.border-gray-300,textarea.border-gray-300{border-color:#d9d3c6 !important;border-radius:10px !important;box-shadow:none !important}
    input.border-gray-300:focus,select.border-gray-300:focus,textarea.border-gray-300:focus{border-color:var(--teal) !important;box-shadow:0 0 0 3px rgba(15,118,110,.15) !important}
    input[type=checkbox]{accent-color:var(--teal);color:var(--teal) !important}
    .text-indigo-600,.text-indigo-500{color:var(--teal) !important}
    label.block.font-medium,.font-medium.text-sm{color:#374151}

    /* cards */
    .shadow,.shadow-md{box-shadow:0 1px 2px rgba(17,24,39,.04),0 8px 24px rgba(17,24,39,.05) !important}
    .bg-white.shadow{border:1px solid var(--line)}
    [class*="sm:rounded-tl-md"]{border-top-left-radius:16px !important;border-top-right-radius:16px !important}
    [class*="sm:rounded-bl-md"]{border-bottom-left-radius:16px !important;border-bottom-right-radius:16px !important}
    [class*="sm:rounded-md"]{border-radius:16px !important}
    .border-gray-200{border-color:var(--line) !important}
    .text-lg.font-medium.text-gray-900{font-weight:700 !important;letter-spacing:-.01em}

    /* page header slot */
    .page-header{border-bottom:1px solid var(--line);background:rgba(255,255,255,.55)}
    .page-header-inner{max-width:1100px;margin:0 auto;padding:24px 20px}
    .page-header h2{margin:0;font-size:28px !important;font-weight:700 !important;letter-spacing:-.02em;color:var(--ink) !important}
</style>
