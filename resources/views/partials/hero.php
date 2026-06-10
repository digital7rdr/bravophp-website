<?php
$media = media_src($page['hero_image'] ?? '', 'images/hero-home.jpg');
$mediaType = ($page['hero_media_type'] ?? 'image') === 'video' ? 'video' : 'image';
$body = nl2br(e($page['body']));
?>
<section class="hero hero-<?= e($page['slug']) ?> <?= $mediaType === 'video' ? 'has-video' : '' ?>" style="--hero-image: url('<?= e($mediaType === 'image' ? $media : media_src('hero-home.jpg')) ?>')">
    <?php if ($mediaType === 'video'): ?>
        <video class="hero-video" autoplay muted loop playsinline preload="metadata">
            <source src="<?= e($media) ?>">
        </video>
    <?php endif; ?>
    <div class="hero-content">
        <?php if (!empty($page['eyebrow'])): ?>
            <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
        <?php endif; ?>
        <h1><?= e($page['headline']) ?></h1>
        <p><?= $body ?></p>
        <div class="hero-actions">
            <?php if (!empty($page['primary_label'])): ?>
                <a class="button button-primary" href="<?= e($page['primary_url'] ?: '/contact') ?>">
                    <?= e($page['primary_label']) ?> <?= icon('arrow') ?>
                </a>
            <?php endif; ?>
            <?php if (!empty($page['secondary_label'])): ?>
                <a class="button button-ghost" href="<?= e($page['secondary_url'] ?: '#features') ?>">
                    <?= e($page['secondary_label']) ?> <?= icon('arrow') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
