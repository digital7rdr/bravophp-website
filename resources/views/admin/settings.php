<?php
/** @var array $settings */
$g = fn(string $k, string $d = '') => $settings[$k] ?? $d;
$colors = [
  'color_accent' => ['Accent (buttons & links)', '#1E88FF'],
  'color_heading' => ['Heading text', '#0A1F3F'],
  'color_body' => ['Body text', '#51617A'],
  'color_bg' => ['Sidebar / footer', '#0A1F3F'],
  'color_surface' => ['Panels / dark cards', '#1B3A66'],
];
?>
<h1 class="mb-1 text-[24px] font-semibold text-white">Settings</h1>
<p class="mb-6 text-[13px] text-t-secondary">Logo, brand, colours and font. Changes apply across the public site.</p>

<form method="post" action="/admin/settings" enctype="multipart/form-data" class="max-w-2xl space-y-8">
  <?= csrf_field() ?>

  <section class="rounded-2xl border border-border-subtle bg-surface1 p-6">
    <h2 class="mb-4 text-[15px] font-semibold text-white">Brand & logo</h2>
    <div class="grid gap-4 sm:grid-cols-2">
      <div><label class="lbl" for="brand_mark">Wordmark (if no logo)</label><input class="ipt" id="brand_mark" name="brand_mark" value="<?= e($g('brand_mark', 'BRAVO')) ?>"></div>
      <div>
        <label class="lbl" for="logo_size">Logo size</label>
        <select class="ipt" id="logo_size" name="logo_size">
          <?php foreach (['Small', 'Medium', 'Large', 'Extra Large'] as $s): ?><option value="<?= e($s) ?>"<?= $g('logo_size', 'Medium') === $s ? ' selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="lbl" for="logo">Logo image (light, for dark sidebar)</label>
        <?php if ($g('logo')): ?><img src="<?= e($g('logo')) ?>" alt="" class="mb-2 h-10 w-auto rounded bg-surface3 object-contain p-1"><?php endif; ?>
        <input class="ipt" id="logo" name="logo" type="file" accept="image/*">
      </div>
      <div>
        <label class="lbl" for="icon">Icon mark (square, collapsed sidebar)</label>
        <?php if ($g('icon')): ?><img src="<?= e($g('icon')) ?>" alt="" class="mb-2 h-10 w-10 rounded bg-surface3 object-contain p-1"><?php endif; ?>
        <input class="ipt" id="icon" name="icon" type="file" accept="image/*">
      </div>
    </div>
  </section>

  <section class="rounded-2xl border border-border-subtle bg-surface1 p-6">
    <h2 class="mb-4 text-[15px] font-semibold text-white">Appearance</h2>
    <div class="grid gap-4 sm:grid-cols-2">
      <?php foreach ($colors as $key => [$label, $def]): $val = $g($key, $def); ?>
        <div>
          <label class="lbl" for="<?= e($key) ?>"><?= e($label) ?></label>
          <div class="flex items-center gap-3">
            <input type="color" value="<?= e(preg_match('/^#[0-9a-fA-F]{6}$/', $val) ? $val : $def) ?>" oninput="document.getElementById('<?= e($key) ?>').value=this.value" class="h-10 w-12 shrink-0 cursor-pointer rounded-md border border-border-subtle bg-surface3">
            <input class="ipt" id="<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($val) ?>">
          </div>
        </div>
      <?php endforeach; ?>
      <div>
        <label class="lbl" for="font">Font</label>
        <select class="ipt" id="font" name="font">
          <?php foreach (['Manrope', 'Inter', 'Poppins', 'Roboto', 'System'] as $f): ?><option value="<?= e($f) ?>"<?= $g('font', 'Manrope') === $f ? ' selected' : '' ?>><?= e($f) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
  </section>

  <button type="submit" class="btnp">Save settings</button>
</form>
