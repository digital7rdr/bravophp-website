<div class="w-full max-w-sm">
  <div class="mb-6 flex items-center gap-2.5">
    <span class="flex h-9 w-9 items-center justify-center rounded-md bg-action text-white"><?= icon('shield') ?></span>
    <span class="text-[15px] font-bold tracking-[0.16em] text-white">BRAVO <span class="text-action">OPS</span></span>
  </div>
  <div class="rounded-2xl border border-border-default bg-surface1 p-6">
    <h1 class="text-[20px] font-semibold text-white">Create admin account</h1>
    <p class="mb-6 mt-1 text-[13px] text-t-secondary">First-time setup. This is shown only until an admin exists.</p>
    <?php if ($err = flash('error')): ?><div class="mb-4 rounded-lg border border-border-default bg-surface3 px-4 py-3 text-[13px] text-t-secondary"><?= e($err) ?></div><?php endif; ?>
    <form method="post" action="/admin/setup">
      <?= csrf_field() ?>
      <label class="lbl" for="name">Full name</label>
      <input class="ipt mb-4" id="name" name="name" required>
      <label class="lbl" for="email">Email</label>
      <input class="ipt mb-4" id="email" name="email" type="email" required>
      <label class="lbl" for="password">Password (min 8 characters)</label>
      <input class="ipt" id="password" name="password" type="password" required>
      <button type="submit" class="btnp mt-6 w-full">Create account</button>
    </form>
  </div>
</div>
