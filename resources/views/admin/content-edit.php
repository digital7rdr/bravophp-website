<?php /** @var string $key @var string $label @var array $doc */ ?>
<a href="/admin/content" class="mb-4 inline-flex items-center gap-1 text-[13px] text-action hover:text-action-hover">← Back to content</a>
<h1 class="mb-1 text-[24px] font-semibold text-white"><?= e($label) ?></h1>
<p class="mb-6 text-[13px] text-t-secondary">Edit the page content below. Image fields take a path like <code class="text-t-muted">/assets/uploads/photo.jpg</code>.</p>

<form method="post" action="/admin/content/<?= e($key) ?>" class="max-w-2xl">
  <?= csrf_field() ?>
  <?php admin_content_node($doc, 'c', ''); ?>
  <div class="sticky bottom-0 -mx-1 mt-4 flex items-center gap-4 border-t border-border-subtle bg-midnight/95 py-4">
    <button type="submit" class="btnp">Save changes</button>
    <a href="/<?= e(in_array($key, ['home', 'site'], true) ? '' : $key) ?>" target="_blank" class="text-[13px] text-action hover:text-action-hover">View page ↗</a>
  </div>
</form>

<script>
(function () {
  var tokenEl = document.querySelector('input[name="_csrf"]');
  var token = tokenEl ? tokenEl.value : '';
  document.querySelectorAll('[data-image-field]').forEach(function (field) {
    var file = field.querySelector('.img-file');
    var input = field.querySelector('.img-input');
    var preview = field.querySelector('.img-preview');
    if (!file) return;
    file.addEventListener('change', function () {
      var f = file.files && file.files[0];
      if (!f) return;
      var fd = new FormData();
      fd.append('file', f);
      fd.append('_csrf', token);
      file.disabled = true;
      fetch('/admin/upload', { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (j) {
          file.disabled = false;
          if (j && j.url) {
            input.value = j.url;
            preview.innerHTML = '<img src="' + j.url + '" alt="" class="h-full w-full object-cover">';
          } else {
            alert((j && j.error) || 'Upload failed');
          }
        })
        .catch(function () { file.disabled = false; alert('Upload failed'); });
    });
  });
})();
</script>
