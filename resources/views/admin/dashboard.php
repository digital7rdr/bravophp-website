<section class="wp-page-head">
    <div>
        <h1>Dashboard</h1>
        <p>Manage the Bravo Secure website content, messages, and media from one place.</p>
    </div>
    <a class="wp-button primary" href="<?= url('/') ?>" target="_blank" rel="noopener">Visit Site</a>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice success"><?= e($message) ?></div>
<?php endif; ?>

<section class="wp-stat-grid">
    <article>
        <span><?= (int) $stats['pages'] ?></span>
        <p>Pages</p>
    </article>
    <article>
        <span><?= (int) $stats['published_pages'] ?></span>
        <p>Published</p>
    </article>
    <article>
        <span><?= (int) $stats['sections'] ?></span>
        <p>Content Sections</p>
    </article>
    <article>
        <span><?= (int) $stats['new_messages'] ?></span>
        <p>New Messages</p>
    </article>
</section>

<div class="wp-dashboard-grid">
    <section class="wp-panel">
        <header>
            <h2>At a Glance</h2>
                    <a href="<?= url('/admin/pages/new') ?>">Add New</a>
        </header>
        <div class="wp-page-list">
            <?php foreach ($pages as $page): ?>
                <article>
                    <div>
                        <strong><?= e($page['menu_label']) ?></strong>
                        <span><?= e($page['path'] ?? '/' . ($page['slug'] === 'home' ? '' : $page['slug'])) ?></span>
                    </div>
                    <a href="<?= url('/admin/pages/' . $page['id']) ?>">Edit</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="wp-panel">
        <header>
            <h2>Quick Actions</h2>
        </header>
        <div class="wp-quick-actions">
            <a href="<?= url('/admin/pages') ?>"><?= icon('layers') ?> Edit pages</a>
            <a href="<?= url('/admin/media') ?>"><?= icon('shield') ?> Manage media</a>
            <a href="<?= url('/admin/messages') ?>"><?= icon('message') ?> Review messages</a>
            <a href="<?= url('/admin/settings') ?>"><?= icon('list') ?> Site settings</a>
        </div>
    </section>

    <section class="wp-panel wide">
        <header>
            <h2>Recent Messages</h2>
            <a href="<?= url('/admin/messages') ?>">View All</a>
        </header>
        <?php if (empty($messages)): ?>
            <p class="wp-muted">No contact messages yet.</p>
        <?php else: ?>
            <table class="wp-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?= e($message['name']) ?></td>
                            <td><?= e($message['email']) ?></td>
                            <td><?= e($message['subject']) ?></td>
                            <td><span class="wp-status"><?= e($message['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>
