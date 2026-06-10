<?php foreach ($groups as $index => $group): ?>
    <?php
    $layout = $group['layout'] ?? 'cards';
    $items = $group['items'] ?? [];
    ?>
    <section class="section section-<?= e($layout) ?>" <?= $index === 0 ? 'id="features"' : '' ?>>
    <?php if (!empty($group['title']) && !in_array($layout, ['split-list', 'checklist'], true)): ?>
            <div class="section-heading">
                <p class="eyebrow"><?= e($group['title']) ?></p>
                <?php if (!empty($group['intro'])): ?>
                    <p><?= e($group['intro']) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($layout === 'steps'): ?>
            <div class="steps">
                <?php foreach ($items as $item): ?>
                    <article>
                        <span><?= e(preg_replace('/\D+/', '', $item['title']) ?: '') ?></span>
                        <h3><?= e($item['title']) ?></h3>
                        <p><?= e($item['body']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'inline'): ?>
            <div class="inline-features">
                <?php foreach ($items as $item): ?>
                    <article>
                        <?= icon($item['icon'] ?? 'shield') ?>
                        <div>
                            <h3><?= e($item['title']) ?></h3>
                            <p><?= e($item['body']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'icon-grid'): ?>
            <div class="icon-grid">
                <?php foreach ($items as $item): ?>
                    <article>
                        <?= icon($item['icon'] ?? 'shield') ?>
                        <h3><?= e($item['title']) ?></h3>
                        <p><?= e($item['body']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php elseif ($layout === 'split-list'): ?>
            <div class="split-list">
                <div>
                    <h2><?= e($group['title']) ?></h2>
                    <p><?= e($group['intro'] ?? '') ?></p>
                </div>
                <div class="support-list">
                    <?php foreach ($items as $item): ?>
                        <article>
                            <?= icon($item['icon'] ?? 'shield') ?>
                            <div>
                                <h3><?= e($item['title']) ?></h3>
                                <p><?= e($item['body']) ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif ($layout === 'checklist'): ?>
            <div class="check-panel">
                <img src="<?= asset('images/shield-emblem.jpg') ?>" alt="" loading="lazy">
                <div>
                    <h2><?= e($group['title']) ?></h2>
                    <p><?= e($group['intro'] ?? '') ?></p>
                    <div class="check-grid">
                        <?php foreach ($items as $item): ?>
                            <span><?= icon('check') ?> <?= e($item['title']) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p>This helps us assess the request and respond accurately.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="<?= $layout === 'wide-cards' ? 'wide-card-grid' : 'card-grid' ?>">
                <?php foreach ($items as $item): ?>
                    <article class="feature-card">
                        <?= icon($item['icon'] ?? 'shield') ?>
                        <h3><?= e($item['title']) ?></h3>
                        <p><?= e($item['body']) ?></p>
                        <?php if (!empty($item['note'])): ?>
                            <strong><?= e($item['note']) ?></strong>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endforeach; ?>
