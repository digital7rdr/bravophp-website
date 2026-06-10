<?php use App\Core\Auth; $authed = Auth::check(); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Operations | Bravo Secure</title>
  <meta name="robots" content="noindex,nofollow">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: {
      colors: {
        navy: '#0A1F3F', midnight: '#06142B', surface1: '#1B3A66', surface2: '#162F54', surface3: '#122747',
        action: { DEFAULT: '#1E88FF', hover: '#3BA6FF', pressed: '#166ED1' },
        't-secondary': '#B8C7E0', 't-muted': '#7E8AA6',
        'border-subtle': '#1C3B66', 'border-default': '#244C82'
      },
      fontFamily: { sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'] }
    } } };
  </script>
  <style>
    body { font-family:'Manrope',ui-sans-serif,system-ui,sans-serif; }
    .wrap { max-width:1100px; margin-inline:auto; padding-inline:20px; }
    .ipt { width:100%; border-radius:.5rem; border:1px solid #1C3B66; background:#122747; padding:.7rem 1rem; color:#fff; font-size:14px; }
    .ipt:focus { outline:none; border-color:#1E88FF; }
    .lbl { display:block; margin-bottom:.4rem; font-size:13px; color:#B8C7E0; }
    .btnp { display:inline-flex; align-items:center; justify-content:center; border-radius:.7rem; background:#1E88FF; padding:.7rem 1.4rem; font-size:14px; font-weight:600; color:#fff; }
    .btnp:hover { background:#3BA6FF; }
  </style>
</head>
<body class="min-h-screen bg-midnight text-white">
  <?php if ($authed): ?>
    <?php $flashS = flash('success'); $flashE = flash('error'); ?>
    <header class="border-b border-border-subtle bg-navy">
      <div class="wrap flex h-16 items-center justify-between">
        <a href="/admin" class="flex items-center gap-2.5">
          <span class="flex h-8 w-8 items-center justify-center rounded-md bg-action text-white"><?= icon('shield') ?></span>
          <span class="text-[14px] font-bold tracking-[0.16em]">BRAVO <span class="text-action">OPS</span></span>
        </a>
        <nav class="flex items-center gap-5 text-[13px]">
          <a href="/admin" class="text-t-secondary hover:text-white">Requests</a>
          <a href="/admin/content" class="text-t-secondary hover:text-white">Content</a>
          <a href="/admin/settings" class="text-t-secondary hover:text-white">Settings</a>
          <a href="/" class="hidden text-t-secondary hover:text-white sm:inline">View site</a>
          <form method="post" action="/admin/logout" class="inline"><?= csrf_field() ?><button class="rounded-md border border-border-subtle px-3 py-1.5 font-medium text-t-secondary hover:text-white">Sign out</button></form>
        </nav>
      </div>
    </header>
    <main class="wrap py-8">
      <?php if ($flashS): ?><div class="mb-5 rounded-lg border border-action/40 bg-surface2 px-4 py-3 text-[13px] text-white"><?= e($flashS) ?></div><?php endif; ?>
      <?php if ($flashE): ?><div class="mb-5 rounded-lg border border-border-default bg-surface3 px-4 py-3 text-[13px] text-t-secondary"><?= e($flashE) ?></div><?php endif; ?>
      <?= $content ?>
    </main>
  <?php else: ?>
    <main class="flex min-h-screen items-center justify-center px-5"><?= $content ?></main>
  <?php endif; ?>
</body>
</html>
