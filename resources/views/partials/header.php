<header class="site-header" data-header>
    <a class="brand" href="<?= url('/') ?>" aria-label="Bravo Secure home">
        <img src="<?= e(site_logo_src()) ?>" alt="" class="brand-mark">
        <span class="brand-text"><?= nl2br(e(str_replace(' ', "\n", site_setting('logo_text', 'Bravo Secure')))) ?></span>
    </a>

    <button class="menu-toggle" type="button" data-menu-toggle aria-label="Open navigation" aria-expanded="false">
        <span></span>
        <span></span>
    </button>

    <nav class="primary-nav" data-nav>
        <?php foreach ($navPages as $navPage): ?>
            <?php
            $href = url($navPage['path'] ?? ($navPage['slug'] === 'home' ? '/' : $navPage['slug']));
            $children = $navPage['children'] ?? [];
            ?>
            <div class="nav-item <?= $children ? 'has-children' : '' ?>">
                <a href="<?= e($href) ?>" class="<?= is_active($href) ? 'active' : '' ?>"><?= e($navPage['menu_label']) ?></a>
                <?php if ($children): ?>
                    <div class="sub-nav">
                        <?php foreach ($children as $child): ?>
                            <a href="<?= e(url($child['path'])) ?>"><?= e($child['menu_label']) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </nav>

    <a class="button button-ghost header-cta" href="<?= url('/contact') ?>">Request Support</a>
</header>
