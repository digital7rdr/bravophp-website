<div class="w-full max-w-sm">
  <div class="mb-6 flex items-center gap-2.5">
    <span class="flex h-9 w-9 items-center justify-center rounded-md bg-action text-white"><?= icon('shield') ?></span>
    <span class="text-[15px] font-bold tracking-[0.16em] text-white">BRAVO <span class="text-action">OPS</span></span>
  </div>
  <div class="rounded-2xl border border-border-default bg-surface1 p-6">
    <h1 class="text-[20px] font-semibold text-white">Sign in</h1>
    <p class="mb-6 mt-1 text-[13px] text-t-secondary">Operations dashboard access.</p>
    <?php if ($s = flash('success')): ?><div class="mb-4 rounded-lg border border-action/40 bg-surface2 px-4 py-3 text-[13px] text-white"><?= e($s) ?></div><?php endif; ?>
    <?php if ($err = flash('error')): ?><div class="mb-4 rounded-lg border border-border-default bg-surface3 px-4 py-3 text-[13px] text-t-secondary"><?= e($err) ?></div><?php endif; ?>
    <form method="post" action="/admin/login">
      <?= csrf_field() ?>
      <label class="lbl" for="email">Email</label>
      <input class="ipt mb-4" id="email" name="email" type="email" autocomplete="email" required>
      <label class="lbl" for="password">Password</label>
      <input class="ipt" id="password" name="password" type="password" autocomplete="current-password" required>
      <button type="submit" class="btnp mt-6 w-full">Sign in</button>
    </form>
  </div>
</div>
