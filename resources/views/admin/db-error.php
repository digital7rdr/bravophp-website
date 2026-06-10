<section class="admin-card auth-card">
    <img src="<?= asset('images/logo.svg') ?>" alt="Bravo Secure" class="auth-logo">
    <h1>Database connection needed.</h1>
    <p>The CMS requires MySQL. Create a database, import <code>database/schema.sql</code> and <code>database/seed.sql</code>, then copy <code>.env.example</code> to <code>.env</code> and add your credentials.</p>
    <?php if (!empty($error)): ?>
        <pre><?= e($error) ?></pre>
    <?php endif; ?>
</section>
