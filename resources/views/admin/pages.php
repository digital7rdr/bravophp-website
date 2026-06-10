<section class="wp-page-head">
    <div>
        <h1>Pages</h1>
        <p>Edit the public website pages, navigation labels, SEO text, and publish status.</p>
    </div>
    <div class="wp-head-actions">
        <a class="wp-button primary" href="<?= url('/admin/pages/new') ?>">Add New Page</a>
        <a class="wp-button" href="<?= url('/') ?>" target="_blank" rel="noopener">View Site</a>
    </div>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice success"><?= e($message) ?></div>
<?php endif; ?>

<section class="wp-panel">
    <table class="wp-table page-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>URL</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td>
                        <strong><?= str_repeat('&mdash; ', (int) ($page['depth'] ?? 0)) ?><?= e($page['menu_label']) ?></strong>
                        <span><?= e($page['headline']) ?></span>
                    </td>
                    <td><code><?= e($page['path'] ?? '/' . $page['slug']) ?></code></td>
                    <td><?= e($page['parent_label'] ?: 'None') ?></td>
                    <td><span class="wp-status <?= (int) $page['is_published'] === 1 ? 'published' : 'draft' ?>"><?= (int) $page['is_published'] === 1 ? 'Published' : 'Draft' ?></span></td>
                    <td><?= (int) $page['sort_order'] ?></td>
                    <td>
                        <a href="<?= url('/admin/pages/' . $page['id']) ?>">Edit</a>
                        <a href="<?= url($page['path'] ?? ($page['slug'] === 'home' ? '/' : '/' . $page['slug'])) ?>" target="_blank" rel="noopener">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
