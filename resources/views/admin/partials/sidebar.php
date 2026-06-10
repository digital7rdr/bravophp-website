<?php
$adminPath = parse_url($_SERVER['REQUEST_URI'] ?? '/admin', PHP_URL_PATH) ?: '/admin';
$items = [
    ['href' => '/admin', 'label' => 'Dashboard', 'icon' => 'chart'],
    ['href' => '/admin/pages', 'label' => 'Pages', 'icon' => 'layers'],
    ['href' => '/admin/media', 'label' => 'Media', 'icon' => 'shield'],
    ['href' => '/admin/messages', 'label' => 'Messages', 'icon' => 'message'],
    ['href' => '/admin/settings', 'label' => 'Settings', 'icon' => 'list'],
];
?>
<aside class="wp-sidebar">
    <a class="wp-sidebar-brand" href="<?= url('/admin') ?>">
        <img src="<?= e(site_logo_src()) ?>" alt="" class="brand-mark">
        <span>Bravo CMS</span>
    </a>
    <nav class="wp-sidebar-nav">
        <?php foreach ($items as $item): ?>
            <?php
            $active = $item['href'] === '/admin'
                ? $adminPath === '/admin'
                : str_starts_with($adminPath, $item['href']);
            ?>
            <a href="<?= url($item['href']) ?>" class="<?= $active ? 'active' : '' ?>">
                <?= icon($item['icon']) ?>
                <span><?= e($item['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="wp-sidebar-footer">
        <a href="<?= url('/') ?>" target="_blank" rel="noopener">View Website</a>
    </div>
</aside>
