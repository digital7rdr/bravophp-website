<?php
/** @var array $pg */
comp_hero($pg['hero'], 'compact');
$msg = flash('lookup_msg');
$msgOk = flash('lookup_ok');
comp_section_open(null, null, 'tint');
?>
<?php if ($msg): ?>
  <div class="mb-6 rounded-xl border <?= $msgOk ? 'border-action/40' : 'border-border-default' ?> bg-card p-5 shadow-card-sm">
    <p class="text-[14px] text-ink"><?= e($msg) ?></p>
  </div>
<?php endif; ?>
<div class="grid gap-8 lg:grid-cols-2">
  <div class="rounded-2xl border border-border-default bg-surface1 p-6 shadow-card md:p-8">
    <h2 class="text-[18px] font-semibold text-white">Manage Request</h2>
    <p class="mb-5 mt-1 text-[13px] text-t-secondary">Find a request with your reference and email.</p>
    <form method="post" action="/manage" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="mode" value="manage">
      <div class="space-y-4">
        <div><label class="<?= bs_label() ?>" for="m_ref">Request Reference Number</label><input class="<?= bs_input() ?>" id="m_ref" name="reference" placeholder="BS-XXXXXX"></div>
        <div><label class="<?= bs_label() ?>" for="m_email">Email Address</label><input class="<?= bs_input() ?>" id="m_email" name="email" type="email"></div>
      </div>
      <button type="submit" class="<?= bs_btn_primary() ?> mt-6 w-full sm:w-auto">Find My Request</button>
    </form>
  </div>
  <div class="rounded-2xl border border-border-default bg-surface1 p-6 shadow-card md:p-8">
    <h2 class="text-[18px] font-semibold text-white">Service Status</h2>
    <p class="mb-5 mt-1 text-[13px] text-t-secondary">Check status with your reference and secure code.</p>
    <form method="post" action="/manage" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="mode" value="status">
      <div class="space-y-4">
        <div><label class="<?= bs_label() ?>" for="s_ref">Request Reference Number</label><input class="<?= bs_input() ?>" id="s_ref" name="reference" placeholder="BS-XXXXXX"></div>
        <div><label class="<?= bs_label() ?>" for="s_code">Secure Code</label><input class="<?= bs_input() ?>" id="s_code" name="secure_code"></div>
      </div>
      <button type="submit" class="<?= bs_btn_primary() ?> mt-6 w-full sm:w-auto">Check Status</button>
    </form>
  </div>
</div>
<?php
comp_section_close();
