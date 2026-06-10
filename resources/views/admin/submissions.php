<?php
/** @var array $rows @var int $total @var int $newCount @var string $q @var string $status @var string $type */
$labels = \App\Controllers\AdminController::TYPE_LABELS;
$statuses = \App\Controllers\AdminController::STATUSES;
$tone = ['new' => 'bg-action/15 text-action', 'reviewing' => 'bg-[#FFC107]/15 text-[#FFC107]', 'confirmed' => 'bg-[#00C853]/15 text-[#00C853]', 'closed' => 'bg-border-default/40 text-t-muted'];
?>
<div class="mb-6">
  <h1 class="text-[24px] font-semibold text-white">Requests</h1>
  <p class="mt-1 text-[13px] text-t-secondary"><?= (int) $total ?> total · <span class="text-action"><?= (int) $newCount ?> new</span></p>
</div>

<?php if (!empty($dbError)): ?>
  <div class="mb-5 rounded-lg border border-border-default bg-surface3 px-4 py-3 text-[13px] text-t-secondary">
    Database issue: <?= e($dbError) ?>. Make sure the <code class="text-white">submissions</code> table is imported.
  </div>
<?php endif; ?>

<form method="get" class="mb-5 flex flex-wrap items-end gap-3">
  <div class="grow"><label class="lbl" for="q">Search</label><input class="ipt" id="q" name="q" value="<?= e($q) ?>" placeholder="Reference, name, or email"></div>
  <div>
    <label class="lbl" for="status">Status</label>
    <select class="ipt capitalize" id="status" name="status">
      <option value="all"<?= $status === 'all' ? ' selected' : '' ?>>All</option>
      <?php foreach ($statuses as $s): ?><option value="<?= e($s) ?>"<?= $status === $s ? ' selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="lbl" for="type">Type</label>
    <select class="ipt" id="type" name="type">
      <option value="all"<?= $type === 'all' ? ' selected' : '' ?>>All</option>
      <?php foreach ($labels as $k => $v): ?><option value="<?= e($k) ?>"<?= $type === $k ? ' selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
    </select>
  </div>
  <button class="btnp">Apply</button>
</form>

<div class="overflow-hidden rounded-2xl border border-border-subtle">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[720px] text-left text-[13px]">
      <thead class="bg-surface2 text-t-muted">
        <tr><th class="px-4 py-3 font-medium">Reference</th><th class="px-4 py-3 font-medium">Type</th><th class="px-4 py-3 font-medium">Contact</th><th class="px-4 py-3 font-medium">Received</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3"></th></tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="6" class="px-4 py-10 text-center text-t-muted">No requests found.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr class="border-t border-border-subtle bg-navy hover:bg-surface3/40">
            <td class="px-4 py-3 font-semibold text-white"><?= e($r['reference']) ?></td>
            <td class="px-4 py-3 text-t-secondary"><?= e($labels[$r['type']] ?? $r['type']) ?></td>
            <td class="px-4 py-3 text-t-secondary"><div><?= e($r['name'] ?: '—') ?></div><div class="text-t-muted"><?= e($r['email'] ?? '') ?></div></td>
            <td class="px-4 py-3 text-t-muted"><?= e(substr((string) $r['created_at'], 0, 16)) ?></td>
            <td class="px-4 py-3"><span class="inline-block rounded-full px-2.5 py-1 text-[11px] font-semibold capitalize <?= $tone[$r['status']] ?? '' ?>"><?= e($r['status']) ?></span></td>
            <td class="px-4 py-3 text-right"><a href="/admin/submissions/<?= (int) $r['id'] ?>" class="text-action hover:text-action-hover">Open</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
