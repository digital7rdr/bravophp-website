<section class="wp-page-head">
    <div>
        <h1>Messages</h1>
        <p>Review contact form submissions and update their workflow status.</p>
    </div>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice success"><?= e($message) ?></div>
<?php endif; ?>

<section class="wp-panel">
    <?php if (empty($messages)): ?>
        <p class="wp-muted">No messages yet.</p>
    <?php else: ?>
        <table class="wp-table messages-table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td>
                            <strong><?= e($message['name']) ?></strong>
                            <a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>
                            <span><?= e($message['created_at']) ?></span>
                        </td>
                        <td><?= e($message['subject']) ?></td>
                        <td><?= e($message['message']) ?></td>
                        <td>
                            <form method="post" action="<?= url('/admin/messages/' . $message['id'] . '/status') ?>" class="inline-form">
                                <?= csrf_field() ?>
                                <select name="status">
                                    <?php foreach (['new', 'reviewing', 'closed'] as $status): ?>
                                        <option value="<?= e($status) ?>" <?= $message['status'] === $status ? 'selected' : '' ?>><?= e(ucfirst($status)) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="wp-button small" type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
