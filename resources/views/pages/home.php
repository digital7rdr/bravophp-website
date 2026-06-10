<?php
/** @var array $pg @var array $request */
ob_start();
comp_request_panel($request);
$panel = ob_get_clean();
comp_hero($pg['hero'], 'full', $panel);

comp_section_open($pg['exploreServices']['heading'], $pg['exploreServices']['intro'] ?? null);
echo '<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">';
foreach ($pg['exploreServices']['cards'] as $c) comp_service_card($c);
echo '</div>';
comp_section_close();

comp_section_open($pg['why']['heading'] ?? null, null, 'tint');
echo '<div class="grid gap-5 sm:grid-cols-3">';
foreach ($pg['why']['cards'] as $c) comp_feature_card($c);
echo '</div>';
comp_section_close();

comp_section_open();
?>
<div class="grid items-center gap-10 lg:grid-cols-2">
  <div>
    <h2 class="text-[24px] font-semibold leading-tight text-ink md:text-[28px]"><?= e($pg['platform']['heading']) ?></h2>
    <p class="mt-4 text-[15px] leading-relaxed text-ink-soft"><?= e($pg['platform']['body']) ?></p>
    <ul class="mt-6 space-y-3">
      <?php foreach (($pg['platform']['points'] ?? []) as $p): ?>
        <li class="flex items-start gap-3 text-[14px] text-ink-soft"><span class="mt-0.5 text-action"><?= str_replace('class="icon"', 'class="h-[18px] w-[18px]"', icon('check')) ?></span><?= e($p) ?></li>
      <?php endforeach; ?>
    </ul>
    <div class="mt-7 flex flex-wrap gap-3">
      <span class="inline-flex items-center gap-2 rounded-xl border border-line bg-card px-4 py-2.5 text-[13px] font-semibold text-ink"><?= str_replace('class="icon"', 'class="h-[18px] w-[18px]"', icon('phone')) ?> App Store</span>
      <span class="inline-flex items-center gap-2 rounded-xl border border-line bg-card px-4 py-2.5 text-[13px] font-semibold text-ink"><?= str_replace('class="icon"', 'class="h-[18px] w-[18px]"', icon('phone')) ?> Google Play</span>
    </div>
    <?php if (!empty($pg['platform']['note'])): ?><p class="mt-3 text-[12px] text-ink-muted"><?= e($pg['platform']['note']) ?></p><?php endif; ?>
  </div>
  <div class="relative overflow-hidden rounded-2xl border border-border-default bg-gradient-to-br from-surface1 to-surface3 p-8">
    <div class="absolute inset-0 opacity-[0.15]" style="background-image:linear-gradient(#4CC2FF 1px,transparent 1px),linear-gradient(90deg,#4CC2FF 1px,transparent 1px);background-size:32px 32px;"></div>
    <div class="relative flex items-center justify-between">
      <div class="flex items-center gap-2 text-white"><span class="flex h-9 w-9 items-center justify-center rounded-md bg-action"><?= icon('shield') ?></span><span class="text-[13px] font-bold tracking-[0.16em]">BRAVO <span class="text-action">SECURE</span></span></div>
      <span class="rounded-full bg-[#FF3B3B] px-3 py-1 text-[12px] font-bold text-white">SOS</span>
    </div>
    <div class="relative mt-6 space-y-3">
      <?php foreach (['Live journey active', 'Risk level: Standard', 'Operator connected'] as $row): ?>
        <div class="flex items-center justify-between rounded-lg border border-border-subtle bg-midnight/60 px-4 py-3 text-[13px] text-t-secondary"><span><?= e($row) ?></span><?= str_replace('class="icon"', 'class="h-4 w-4"', icon('check')) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php
comp_section_close();

comp_cta($pg['cta']);
