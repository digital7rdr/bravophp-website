<form method="post" action="<?= url('/admin/pages/' . $page['id']) ?>" class="wp-editor">
    <?= csrf_field() ?>

    <section class="wp-page-head">
        <div>
            <h1>Edit Page</h1>
            <p><?= e($page['path'] ?? '/' . $page['slug']) ?> · <?= e($page['title']) ?></p>
        </div>
        <div class="wp-head-actions">
            <a class="wp-button" href="<?= url($page['path'] ?? ($page['slug'] === 'home' ? '/' : '/' . $page['slug'])) ?>" target="_blank" rel="noopener">Preview</a>
            <button class="wp-button primary" type="submit">Update</button>
        </div>
    </section>

    <?php if ($message = flash('success')): ?>
        <div class="notice success"><?= e($message) ?></div>
    <?php endif; ?>

    <div class="wp-editor-grid">
        <main class="wp-editor-main">
            <section class="wp-panel">
                <label class="wp-title-field">
                    Page title
                    <input name="headline" value="<?= e($page['headline']) ?>">
                </label>
                <label>
                    Main content
                    <textarea name="body" rows="8"><?= e($page['body']) ?></textarea>
                </label>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Hero Buttons</h2>
                </header>
                <div class="wp-two-col">
                    <label>Primary Label <input name="primary_label" value="<?= e($page['primary_label']) ?>"></label>
                    <label>Primary URL <input name="primary_url" value="<?= e($page['primary_url']) ?>"></label>
                    <label>Secondary Label <input name="secondary_label" value="<?= e($page['secondary_label']) ?>"></label>
                    <label>Secondary URL <input name="secondary_url" value="<?= e($page['secondary_url']) ?>"></label>
                </div>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Call To Action</h2>
                </header>
                <label>CTA Headline <input name="cta_headline" value="<?= e($page['cta_headline']) ?>"></label>
                <label>CTA Body <textarea name="cta_body" rows="3"><?= e($page['cta_body']) ?></textarea></label>
                <div class="wp-two-col">
                    <label>CTA Label <input name="cta_label" value="<?= e($page['cta_label']) ?>"></label>
                    <label>CTA URL <input name="cta_url" value="<?= e($page['cta_url']) ?>"></label>
                </div>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Sections & Cards</h2>
                    <span>Reusable content blocks for this page</span>
                </header>
                <div class="wp-accordion">
                    <?php foreach ($groups as $group): ?>
                        <details open>
                            <summary><?= e($group['title'] ?: 'Untitled Section') ?></summary>
                            <div class="wp-two-col">
                                <label>Section Title <input name="groups[<?= (int) $group['id'] ?>][title]" value="<?= e($group['title']) ?>"></label>
                                <label>Layout <input name="groups[<?= (int) $group['id'] ?>][layout]" value="<?= e($group['layout']) ?>"></label>
                                <label>Sort Order <input type="number" name="groups[<?= (int) $group['id'] ?>][sort_order]" value="<?= e($group['sort_order']) ?>"></label>
                            </div>
                            <label>Intro
                                <textarea name="groups[<?= (int) $group['id'] ?>][intro]" rows="2"><?= e($group['intro'] ?? '') ?></textarea>
                            </label>

                            <?php foreach ($group['items'] as $item): ?>
                                <article class="wp-repeater-item">
                                    <div class="wp-two-col">
                                        <label>Icon <input name="groups[<?= (int) $group['id'] ?>][items][<?= (int) $item['id'] ?>][icon]" value="<?= e($item['icon']) ?>"></label>
                                        <label>Title <input name="groups[<?= (int) $group['id'] ?>][items][<?= (int) $item['id'] ?>][title]" value="<?= e($item['title']) ?>"></label>
                                        <label>Sort <input type="number" name="groups[<?= (int) $group['id'] ?>][items][<?= (int) $item['id'] ?>][sort_order]" value="<?= e($item['sort_order']) ?>"></label>
                                    </div>
                                    <label>Body
                                        <textarea name="groups[<?= (int) $group['id'] ?>][items][<?= (int) $item['id'] ?>][body]" rows="3"><?= e($item['body']) ?></textarea>
                                    </label>
                                    <label>Note
                                        <input name="groups[<?= (int) $group['id'] ?>][items][<?= (int) $item['id'] ?>][note]" value="<?= e($item['note']) ?>">
                                    </label>
                                </article>
                            <?php endforeach; ?>
                        </details>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>

        <aside class="wp-editor-sidebar">
            <section class="wp-panel">
                <header>
                    <h2>Publish</h2>
                </header>
                <label class="check-row"><input type="checkbox" name="is_published" value="1" <?= (int) $page['is_published'] === 1 ? 'checked' : '' ?>> Published</label>
                <label>Sort Order <input type="number" name="sort_order" value="<?= e($page['sort_order']) ?>"></label>
                <button class="wp-button primary full" type="submit">Update Page</button>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Page Attributes</h2>
                </header>
                <label>Menu Label <input name="menu_label" value="<?= e($page['menu_label']) ?>"></label>
                <label>Browser Title <input name="title" value="<?= e($page['title']) ?>"></label>
                <label>Eyebrow <input name="eyebrow" value="<?= e($page['eyebrow']) ?>"></label>
                <?php if ($page['slug'] === 'home'): ?>
                    <input type="hidden" name="parent_id" value="0">
                <?php else: ?>
                    <label>Parent Page
                        <select name="parent_id">
                            <option value="0">No parent</option>
                            <?php foreach ($pages as $parent): ?>
                                <?php if ((int) $parent['id'] === (int) $page['id']) continue; ?>
                                <option value="<?= (int) $parent['id'] ?>" <?= (int) ($page['parent_id'] ?? 0) === (int) $parent['id'] ? 'selected' : '' ?>>
                                    <?= str_repeat('- ', (int) ($parent['depth'] ?? 0)) ?><?= e($parent['menu_label']) ?> (<?= e($parent['path'] ?? '') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php endif; ?>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>Hero Media</h2>
                </header>
                <?php if (!empty($page['hero_image']) && ($page['hero_media_type'] ?? 'image') === 'video'): ?>
                    <video class="wp-featured-image" controls muted>
                        <source src="<?= e(media_src($page['hero_image'])) ?>">
                    </video>
                <?php elseif (!empty($page['hero_image'])): ?>
                    <img class="wp-featured-image" src="<?= e(media_src($page['hero_image'])) ?>" alt="">
                <?php endif; ?>
                <label>Media Type
                    <select name="hero_media_type">
                        <option value="image" <?= ($page['hero_media_type'] ?? 'image') === 'image' ? 'selected' : '' ?>>Image</option>
                        <option value="video" <?= ($page['hero_media_type'] ?? 'image') === 'video' ? 'selected' : '' ?>>Video</option>
                    </select>
                </label>
                <label>Media File or URL
                    <input name="hero_image" value="<?= e($page['hero_image']) ?>" placeholder="hero-home.jpg or uploads/video.mp4 or https://...">
                </label>
                <p class="wp-field-help">Use image filenames from the media library, uploaded paths like <code>uploads/intro.mp4</code>, or a direct HTTPS video URL.</p>
                <a href="<?= url('/admin/media') ?>">Browse media library</a>
            </section>

            <section class="wp-panel">
                <header>
                    <h2>SEO</h2>
                </header>
                <label>Meta Description
                    <textarea name="meta_description" rows="5"><?= e($page['meta_description']) ?></textarea>
                </label>
            </section>
        </aside>
    </div>
</form>
