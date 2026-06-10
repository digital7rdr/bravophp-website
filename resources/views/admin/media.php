<section class="wp-page-head">
    <div>
        <h1>Media</h1>
        <p>Upload images, logos, and videos. Use the displayed path in page hero media or logo settings.</p>
    </div>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice success"><?= e($message) ?></div>
<?php endif; ?>
<?php if ($message = flash('error')): ?>
    <div class="notice error"><?= e($message) ?></div>
<?php endif; ?>

<form class="wp-panel wp-upload-panel" method="post" action="<?= url('/admin/media/upload') ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <header>
        <h2>Upload New Media</h2>
    </header>
    <div>
        <label>Image or video file
            <input type="file" name="media_file" accept="image/jpeg,image/png,image/webp,image/svg+xml,video/mp4,video/webm,video/ogg" required>
        </label>
        <button class="wp-button primary" type="submit">Upload</button>
    </div>
</form>

<section class="wp-panel">
    <div class="wp-media-grid">
        <?php foreach ($files as $file): ?>
            <?php
            $name = basename($file);
            $relative = str_contains($file, '/assets/uploads/') ? 'uploads/' . $name : 'images/' . $name;
            $assetPath = asset($relative);
            $isVideo = preg_match('/\.(mp4|webm|ogv)$/i', $name) === 1;
            ?>
            <article>
                <div class="wp-media-thumb">
                    <?php if ($isVideo): ?>
                        <video src="<?= e($assetPath) ?>" muted controls preload="metadata"></video>
                    <?php else: ?>
                        <img src="<?= e($assetPath) ?>" alt="<?= e($name) ?>">
                    <?php endif; ?>
                </div>
                <strong><?= e($name) ?></strong>
                <code><?= e($relative) ?></code>
            </article>
        <?php endforeach; ?>
    </div>
</section>
