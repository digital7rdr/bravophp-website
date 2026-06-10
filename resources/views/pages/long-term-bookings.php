<?php
/** @var array $pg */
comp_hero($pg['hero'], 'compact');

comp_section_open(null, null, 'tint');
?>
<div class="rounded-2xl border border-line bg-card p-6 shadow-card-sm md:p-8">
  <p class="text-[15px] leading-relaxed text-ink-soft"><?= e($pg['intro']['body']) ?></p>
</div>
<div class="mt-8 grid gap-5 md:grid-cols-3">
  <?php foreach ($pg['columns'] as $col): ?>
    <div class="rounded-2xl border border-line bg-card p-6 shadow-card-sm">
      <h3 class="text-[16px] font-semibold text-ink"><?= e($col['title']) ?></h3>
      <ul class="mt-4 space-y-3">
        <?php foreach ($col['items'] as $item): ?>
          <li class="flex items-start gap-3 text-[14px] text-ink-soft"><span class="mt-0.5 text-action"><?= str_replace('class="icon"', 'class="h-4 w-4"', icon('check')) ?></span><?= e($item) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</div>
<?php
comp_section_close();

comp_section_open($pg['process']['heading']);
comp_steps($pg['process']['steps']);
comp_section_close();

comp_section_open($pg['benefits']['heading'], null, 'tint');
echo '<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">';
foreach ($pg['benefits']['cards'] as $c) comp_feature_card($c);
echo '</div>';
comp_section_close();

comp_cta($pg['cta']);
