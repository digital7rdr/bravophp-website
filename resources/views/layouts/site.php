<?php
use App\Support\SiteContent;
use App\Models\Setting;

$site = SiteContent::site();
$seo = $seo ?? [];

// Appearance (editable in admin → Settings)
$ap = [
    'accent' => Setting::get('color_accent', '#1E88FF'),
    'navy' => Setting::get('color_bg', '#0A1F3F'),
    'surface' => Setting::get('color_surface', '#1B3A66'),
    'heading' => Setting::get('color_heading', '#0A1F3F'),
    'body' => Setting::get('color_body', '#51617A'),
    'font' => Setting::get('font', 'Manrope'),
];
$fontMap = [
    'Manrope' => 'Manrope:wght@300;400;500;600;700',
    'Inter' => 'Inter:wght@300;400;500;600;700',
    'Poppins' => 'Poppins:wght@300;400;500;600;700',
    'Roboto' => 'Roboto:wght@300;400;500;700',
    'System' => '',
];
$fontFamily = $ap['font'] === 'System' ? 'ui-sans-serif, system-ui, sans-serif' : "'" . $ap['font'] . "'";
$fontQuery = $fontMap[$ap['font']] ?? $fontMap['Manrope'];
$title = $seo['title'] ?? ($site['brandName'] . ' — Controlled security support');
$description = $seo['description'] ?? 'A controlled operational platform for secure mobility, communication, risk awareness, and executive support.';
$menu = $site['menu'];
$ctas = $site['navCtas'];
$footer = $site['footer'];
$logoSizePx = ['Small' => 40, 'Medium' => 56, 'Large' => 72, 'Extra Large' => 88][$site['logoSize'] ?? 'Medium'] ?? 56;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php if ($fontQuery !== ''): ?>
  <link href="https://fonts.googleapis.com/css2?family=<?= e($fontQuery) ?>&display=swap" rel="stylesheet">
  <?php endif; ?>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          navy: '<?= e($ap['navy']) ?>', midnight: '#06142B',
          surface1: '<?= e($ap['surface']) ?>', surface2: '#162F54', surface3: '#122747',
          action: { DEFAULT: '<?= e($ap['accent']) ?>', hover: '#3BA6FF', pressed: '#166ED1' },
          't-primary': '#FFFFFF', 't-secondary': '#B8C7E0', 't-muted': '#7E8AA6',
          'border-subtle': '#1C3B66', 'border-default': '#244C82',
          page: '#F4F7FB', card: '#FFFFFF', line: '#E2E8F1',
          ink: '<?= e($ap['heading']) ?>', 'ink-soft': '<?= e($ap['body']) ?>', 'ink-muted': '#8794A9'
        },
        fontFamily: { sans: [<?= $fontFamily !== "'Manrope'" ? e($fontFamily) . ", 'Manrope'" : "'Manrope'" ?>, 'ui-sans-serif', 'system-ui', 'sans-serif'] },
        boxShadow: {
          panel: '0 24px 60px -20px rgba(3,10,24,0.65)',
          card: '0 1px 2px rgba(16,24,40,0.05), 0 10px 26px -12px rgba(16,24,40,0.18)',
          'card-hover': '0 4px 8px rgba(16,24,40,0.06), 0 20px 44px -14px rgba(16,24,40,0.30)',
          'card-sm': '0 1px 2px rgba(16,24,40,0.04), 0 4px 12px -6px rgba(16,24,40,0.10)'
        }
      } }
    };
  </script>
  <style>
    body { font-family: <?= $fontFamily ?>, ui-sans-serif, system-ui, sans-serif; background:#FFFFFF; }
    .container-bravo { width:100%; max-width:1200px; margin-inline:auto; padding-inline:24px; }
    @media (min-width:768px){ .container-bravo { padding-inline:32px; } }
    .icon { width:1.5rem; height:1.5rem; }
    html { scroll-behavior:smooth; }
    #sidebar { width:280px; }
    #shell { padding-left:0; }
    @media (min-width:1024px){ #shell { padding-left:280px; } body.nav-collapsed #sidebar { width:72px; } body.nav-collapsed #shell { padding-left:72px; } }
    body.nav-collapsed .nav-label, body.nav-collapsed .logo-full { display:none; }
    .logo-icon { display:none; }
    body.nav-collapsed .logo-icon { display:flex; }
    body.nav-collapsed .nav-link { justify-content:center; }
    @media (max-width:1023px){
      #sidebar { transform:translateX(-100%); transition:transform .2s ease; }
      body.nav-open #sidebar { transform:translateX(0); }
      #nav-overlay { display:none; }
      body.nav-open #nav-overlay { display:block; }
    }
  </style>
</head>
<body class="font-sans text-ink">

  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full flex-col border-r border-border-subtle bg-navy transition-[width] duration-200">
    <div class="flex h-24 shrink-0 items-center justify-center px-5">
      <a href="/" class="flex items-center gap-2.5" aria-label="<?= e($site['brandName']) ?>">
        <!-- Expanded -->
        <span class="logo-full flex items-center gap-2.5">
          <?php if (!empty($site['logo'])): ?>
            <img class="w-auto object-contain" style="height: <?= (int) $logoSizePx ?>px;" src="<?= e(media_src($site['logo'])) ?>" alt="<?= e($site['brandName']) ?>">
          <?php else: ?>
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-action text-white"><?= icon('shield') ?></span>
            <span class="leading-none">
              <span class="block text-[16px] font-bold tracking-[0.18em] text-white"><?= e($site['brandMark']) ?></span>
              <span class="mt-0.5 block text-[10px] font-semibold tracking-[0.34em] text-t-secondary">SECURE</span>
            </span>
          <?php endif; ?>
        </span>
        <!-- Collapsed -->
        <span class="logo-icon h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-md <?= !empty($site['icon']) ? '' : 'bg-action text-white' ?>">
          <?php if (!empty($site['icon'])): ?>
            <img class="h-11 w-11 object-contain" src="<?= e(media_src($site['icon'])) ?>" alt="<?= e($site['brandName']) ?>">
          <?php else: ?>
            <?= icon('shield') ?>
          <?php endif; ?>
        </span>
      </a>
    </div>
    <div class="flex items-center gap-3 px-5 py-4">
      <span class="nav-label h-px flex-1 bg-border-subtle"></span>
      <button type="button" id="nav-toggle" aria-label="Collapse menu" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-border-subtle bg-surface2 text-white hover:bg-surface1">
        <svg id="nav-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
      </button>
    </div>
    <nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 pb-6">
      <ul>
        <?php foreach ($menu as $item): $active = is_active($item['href']); ?>
          <li>
            <a href="<?= e($item['href']) ?>" title="<?= e($item['label']) ?>" class="nav-link group mb-0.5 flex items-center gap-4 rounded-lg px-4 py-3 transition-colors <?= $active ? 'bg-surface2' : 'hover:bg-surface3' ?>">
              <span class="shrink-0 <?= $active ? 'text-action' : 'text-t-secondary group-hover:text-white' ?>"><?= str_replace('class="icon"', 'class="h-[21px] w-[21px]"', icon($item['icon'])) ?></span>
              <span class="nav-label whitespace-nowrap text-[14px] <?= $active ? 'font-semibold text-white' : 'font-medium text-white' ?>"><?= e($item['label']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </aside>
  <div id="nav-overlay" class="fixed inset-0 z-40 bg-midnight/80 lg:hidden"></div>

  <div id="shell" class="min-h-screen bg-card">
    <header class="sticky top-0 z-30 border-b border-border-subtle bg-navy/95 backdrop-blur">
      <div class="flex h-16 items-center justify-between gap-2 px-5 md:px-8">
        <button type="button" id="nav-open" aria-label="Open menu" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-white lg:hidden"><?= icon('list') ?></button>
        <div class="ml-auto flex items-center gap-2">
          <?php foreach ($ctas as $cta): ?>
            <?php if (($cta['style'] ?? '') === 'primary'): ?>
              <a href="<?= e($cta['href']) ?>" class="<?= bs_btn_primary() ?> px-4 py-2 text-[13px]"><?= e($cta['label']) ?></a>
            <?php else: ?>
              <a href="<?= e($cta['href']) ?>" class="hidden rounded-md px-3 py-2 text-[13px] font-medium text-t-secondary transition-colors hover:text-white sm:inline-flex"><?= e($cta['label']) ?></a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </header>

    <main><?= $content ?></main>

    <footer class="border-t border-border-subtle bg-midnight">
      <div class="container-bravo py-14">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">
          <div class="lg:col-span-2">
            <div class="flex items-center gap-2">
              <span class="flex h-8 w-8 items-center justify-center rounded-md bg-action text-white"><?= icon('shield') ?></span>
              <span class="text-[15px] font-bold tracking-[0.16em] text-white"><?= e($site['brandMark']) ?><span class="text-action"> SECURE</span></span>
            </div>
            <p class="mt-4 max-w-sm text-[13px] leading-relaxed text-t-secondary"><?= e($footer['blurb']) ?></p>
            <div class="mt-5 space-y-1 text-[13px] text-t-muted">
              <p><?= e($site['contact']['email']) ?></p>
              <p><?= e($site['contact']['phone']) ?></p>
              <p><?= e($site['contact']['hours']) ?></p>
            </div>
          </div>
          <?php foreach ($footer['columns'] as $col): ?>
            <div>
              <h3 class="text-[12px] font-semibold uppercase tracking-[0.12em] text-t-muted"><?= e($col['title']) ?></h3>
              <ul class="mt-4 space-y-2">
                <?php foreach ($col['links'] as $link): ?>
                  <li><a href="<?= e($link['href']) ?>" class="text-[13px] text-t-secondary transition-colors hover:text-white"><?= e($link['label']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="mt-12 flex flex-col gap-3 border-t border-border-subtle pt-6 text-[12px] text-t-muted sm:flex-row sm:items-center sm:justify-between">
          <p>© <?= date('Y') ?> <?= e($site['brandName']) ?>. All rights reserved.</p>
          <p class="max-w-xl sm:text-right"><?= e($footer['legal']) ?></p>
        </div>
      </div>
    </footer>
  </div>

  <script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
