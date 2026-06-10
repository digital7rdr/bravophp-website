<?php /** @var array $docs */ ?>
<h1 class="mb-1 text-[24px] font-semibold text-white">Content</h1>
<p class="mb-6 text-[13px] text-t-secondary">Edit the text and cards on each page. Changes go live on save.</p>

<div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
  <?php foreach ($docs as $key => $label): ?>
    <a href="/admin/content/<?= e($key) ?>" class="flex items-center justify-between rounded-xl border border-border-subtle bg-surface1 px-5 py-4 transition-colors hover:border-border-default hover:bg-surface2">
      <span class="text-[15px] font-medium text-white"><?= e($label) ?></span>
      <span class="text-t-muted"><?= str_replace('class="icon"', 'class="h-[18px] w-[18px]"', icon('arrow')) ?></span>
    </a>
  <?php endforeach; ?>
</div>
