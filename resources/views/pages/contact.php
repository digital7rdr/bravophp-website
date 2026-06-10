<?php
/** @var array $pg */
comp_hero($pg['hero'], 'compact');
$ok = flash('contact_ok');
comp_section_open(null, null, 'tint');
?>
<div class="grid gap-8 lg:grid-cols-2">
  <div id="contact-form" class="rounded-2xl border border-border-default bg-surface1 p-6 shadow-card md:p-8">
    <h2 class="text-[20px] font-semibold text-white">Send us a message</h2>
    <p class="mb-6 mt-1 text-[14px] text-t-secondary">Share what you need and Bravo Secure will respond. Every request is reviewed before confirmation.</p>
    <?php if ($ok): ?>
      <div class="rounded-xl border border-border-subtle bg-surface3 p-6 text-center">
        <span class="mx-auto mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-action/15 text-action"><?= icon('check') ?></span>
        <h3 class="text-[16px] font-semibold text-white">Message sent</h3>
        <p class="mx-auto mt-2 max-w-md text-[13px] leading-relaxed text-t-secondary">Thank you. Bravo Secure will review your message and respond using the details provided.</p>
      </div>
    <?php else: ?>
      <form method="post" action="/contact" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="form_type" value="contact">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div><label class="<?= bs_label() ?>" for="c_name">Full Name</label><input class="<?= bs_input() ?>" id="c_name" name="name"></div>
          <div><label class="<?= bs_label() ?>" for="c_email">Contact Email</label><input class="<?= bs_input() ?>" id="c_email" name="email" type="email"></div>
          <div><label class="<?= bs_label() ?>" for="c_loc">Location / Time Zone</label><input class="<?= bs_input() ?>" id="c_loc" name="location"></div>
          <div>
            <label class="<?= bs_label() ?>" for="c_type">Type of Support</label>
            <select class="<?= bs_input() ?> appearance-none" id="c_type" name="supportType">
              <option value="">Select…</option>
              <?php foreach (['Secure Services', 'Virtual Bodyguard', 'Bravo Comms', 'Long-Term Bookings', 'Agent Network', 'General Enquiry'] as $o): ?>
                <option value="<?= e($o) ?>"><?= e($o) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="sm:col-span-2"><label class="<?= bs_label() ?>" for="c_msg">Message</label><textarea class="<?= bs_input() ?> resize-y" id="c_msg" name="message" rows="5"></textarea></div>
        </div>
        <button type="submit" class="<?= bs_btn_primary() ?> mt-6 w-full sm:w-auto">Send Message</button>
      </form>
    <?php endif; ?>
  </div>

  <div>
    <h2 class="text-[20px] font-semibold text-ink"><?= e($pg['methods']['heading']) ?></h2>
    <div class="mt-5 grid gap-4 sm:grid-cols-2">
      <?php foreach ($pg['methods']['cards'] as $c) comp_feature_card($c); ?>
    </div>
    <div class="mt-8 rounded-2xl border border-line bg-card p-6 shadow-card-sm">
      <h3 class="text-[16px] font-semibold text-ink"><?= e($pg['checklist']['heading']) ?></h3>
      <?php if (!empty($pg['checklist']['intro'])): ?><p class="mt-1 text-[13px] text-ink-soft"><?= e($pg['checklist']['intro']) ?></p><?php endif; ?>
      <ul class="mt-4 space-y-3">
        <?php foreach ($pg['checklist']['items'] as $item): ?>
          <li class="flex items-start gap-3 text-[14px] text-ink-soft"><span class="mt-0.5 text-action"><?= str_replace('class="icon"', 'class="h-[18px] w-[18px]"', icon('check')) ?></span><?= e($item) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<?php
comp_section_close();
comp_cta($pg['cta']);
