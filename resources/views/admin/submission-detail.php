<?php
/** @var array $row */
$labels = \App\Controllers\AdminController::TYPE_LABELS;
$statuses = \App\Controllers\AdminController::STATUSES;
$payload = json_decode((string) ($row['payload'] ?? '{}'), true) ?: [];
?>
<a href="/admin" class="mb-5 inline-flex items-center gap-1 text-[13px] text-action hover:text-action-hover">← Back to requests</a>

<div class="max-w-3xl rounded-2xl border border-border-default bg-surface1 p-6 md:p-8">
  <div class="flex flex-wrap items-start justify-between gap-4">
    <div>
      <p class="text-[12px] uppercase tracking-[0.12em] text-action"><?= e($labels[$row['type']] ?? $row['type']) ?></p>
      <h1 class="mt-1 text-[24px] font-semibold text-white"><?= e($row['reference']) ?></h1>
      <p class="mt-1 text-[13px] text-t-muted">Received <?= e(substr((string) $row['created_at'], 0, 16)) ?></p>
    </div>
    <form method="post" action="/admin/submissions/<?= (int) $row['id'] ?>/status" class="text-right">
      <?= csrf_field() ?>
      <label class="lbl">Status</label>
      <select name="status" class="ipt capitalize" onchange="this.form.submit()">
        <?php foreach ($statuses as $s): ?><option value="<?= e($s) ?>"<?= $row['status'] === $s ? ' selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
      </select>
      <noscript><button class="btnp mt-2">Update</button></noscript>
    </form>
  </div>

  <dl class="mt-8 divide-y divide-border-subtle border-t border-border-subtle">
    <?php if (!$payload): ?><p class="py-4 text-[13px] text-t-muted">No fields submitted.</p><?php endif; ?>
    <?php foreach ($payload as $k => $v): ?>
      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3">
        <dt class="text-[13px] capitalize text-t-muted"><?= e(preg_replace('/([A-Z])/', ' $1', (string) $k)) ?></dt>
        <dd class="text-[14px] text-white sm:col-span-2"><?= e(is_array($v) ? implode(', ', $v) : (string) $v) ?: '—' ?></dd>
      </div>
    <?php endforeach; ?>
  </dl>

  <div class="mt-8 flex flex-wrap gap-x-8 gap-y-2 border-t border-border-subtle pt-5 text-[12px] text-t-muted">
    <span>Secure code: <span class="font-semibold text-t-secondary"><?= e($row['secure_code']) ?></span></span>
    <?php if (!empty($row['email'])): ?><span>Email: <a href="mailto:<?= e($row['email']) ?>" class="font-semibold text-action hover:text-action-hover"><?= e($row['email']) ?></a></span><?php endif; ?>
  </div>
</div>
