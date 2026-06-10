<?php $currentUser = \App\Core\Auth::user(); ?>
<header class="wp-adminbar">
    <div>
        <strong><?= e(config('app.name')) ?></strong>
        <span>Content Management System</span>
    </div>
    <nav>
        <a href="<?= url('/') ?>" target="_blank" rel="noopener">View Site</a>
        <span><?= e($currentUser['name'] ?? 'Admin') ?></span>
        <form method="post" action="<?= url('/admin/logout') ?>">
            <?= csrf_field() ?>
            <button type="submit">Log Out</button>
        </form>
    </nav>
</header>
