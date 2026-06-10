<footer class="site-footer">
    <div class="footer-grid">
        <div>
            <a class="brand footer-brand" href="<?= url('/') ?>">
                <img src="<?= e(site_logo_src()) ?>" alt="" class="brand-mark">
                <span class="brand-text"><?= nl2br(e(str_replace(' ', "\n", site_setting('logo_text', 'Bravo Secure')))) ?></span>
            </a>
            <p>Controlled operations.<br>Protected people.</p>
        </div>

        <div>
            <h2>Services</h2>
            <a href="<?= url('/services') ?>">Secure Services</a>
            <a href="<?= url('/bravo-comms') ?>">Bravo Comms</a>
            <a href="<?= url('/virtual-bodyguard') ?>">Virtual Bodyguard</a>
            <a href="<?= url('/agent-network') ?>">Agent Network</a>
        </div>

        <div>
            <h2>Company</h2>
            <a href="<?= url('/about') ?>">About</a>
            <a href="<?= url('/contact') ?>">Contact</a>
        </div>

        <div>
            <h2>Contact</h2>
            <a href="mailto:<?= e(site_setting('contact_email', config('app.mail_to'))) ?>"><?= icon('mail') ?> <?= e(site_setting('contact_email', config('app.mail_to'))) ?></a>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Bravo Secure. All rights reserved.</p>
        <div>
            <a href="#">Privacy Policy</a>
            <span>|</span>
            <a href="#">Terms of Service</a>
        </div>
    </div>
</footer>
