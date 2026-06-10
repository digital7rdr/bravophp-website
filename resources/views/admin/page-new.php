<form method="post" action="<?= url('/admin/pages/new') ?>" class="wp-editor">
    <?= csrf_field() ?>

    <section class="wp-page-head">
        <div>
            <h1>Add New Page</h1>
            <p>Create a top-level page or place it under an existing page as a subpage.</p>
        </div>
        <div class="wp-head-actions">
            <a class="wp-button" href="<?= url('/admin/pages') ?>">Cancel</a>
            <button class="wp-button primary" type="submit">Create Page</button>
        </div>
    </section>

    <?php if ($message = flash('error')): ?>
        <div class="notice error"><?= e($message) ?></div>
    <?php endif; ?>

    <div class="wp-editor-grid">
        <main class="wp-editor-main">
            <section class="wp-panel">
                <label class="wp-title-field">Page title
                    <input name="title" placeholder="New service page" required>
                </label>
                <label>Headline
                    <input name="headline" placeholder="New service page.">
                </label>
                <label>Main content
                    <textarea name="body" rows="8" placeholder="Write the page introduction..."></textarea>
                </label>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Hero Media</h2>
                </header>
                <div class="wp-two-col">
                    <label>Media Type
                        <select name="hero_media_type">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </label>
                    <label>Media File or URL
                        <input name="hero_image" value="hero-home.jpg">
                    </label>
                </div>
            </section>
        </main>

        <aside class="wp-editor-sidebar">
            <section class="wp-panel">
                <header>
                    <h2>Publish</h2>
                </header>
                <label class="check-row"><input type="checkbox" name="is_published" value="1" checked> Published</label>
                <label>Sort Order <input type="number" name="sort_order" value="100"></label>
                <button class="wp-button primary full" type="submit">Create Page</button>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Page Attributes</h2>
                </header>
                <label>Slug
                    <input name="slug" placeholder="new-service-page">
                </label>
                <label>Menu Label
                    <input name="menu_label" placeholder="New Service">
                </label>
                <label>Parent Page
                    <select name="parent_id">
                        <option value="0">No parent</option>
                        <?php foreach ($pages as $parent): ?>
                            <option value="<?= (int) $parent['id'] ?>">
                                <?= str_repeat('- ', (int) ($parent['depth'] ?? 0)) ?><?= e($parent['menu_label']) ?> (<?= e($parent['path'] ?? '') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </section>
        </aside>
    </div>
</form>
