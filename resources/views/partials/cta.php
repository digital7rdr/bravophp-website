<?php if (!empty($page['cta_headline'])): ?>
    <section class="cta-band">
        <div>
            <h2><?= e($page['cta_headline']) ?></h2>
            <?php if (!empty($page['cta_body'])): ?>
                <p><?= e($page['cta_body']) ?></p>
            <?php endif; ?>
        </div>
        <?php if (!empty($page['cta_label'])): ?>
            <a class="button button-ghost" href="<?= e($page['cta_url'] ?: '/contact') ?>">
                <?= e($page['cta_label']) ?> <?= icon('arrow') ?>
            </a>
        <?php endif; ?>
    </section>
<?php endif; ?>
