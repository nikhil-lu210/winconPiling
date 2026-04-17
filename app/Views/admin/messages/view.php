<?php
declare(strict_types=1);
/** @var array<string, mixed> $message */
$id = (int) ($message['id'] ?? 0);
$wasUnread = (bool) ($wasUnread ?? false);
$email = (string) ($message['email'] ?? '');
$subj = (string) ($message['subject'] ?? '');
$mailtoReply = 'mailto:' . rawurlencode($email) . '?subject=' . rawurlencode('Re: ' . $subj);
?>
<?php if ($wasUnread): ?>
<div id="adminMessageViewMark" class="visually-hidden" aria-hidden="true"
     data-message-id="<?= $id ?>"
     data-mark-read-url="<?= e(base_url('admin/messages/mark-read')) ?>"></div>
<?php endif; ?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/messages')) ?>" class="admin-link-back">← Back to messages</a>
    <h2 class="admin-page-head__title">Message</h2>
</div>

<div class="admin-msg-header">
    <div class="admin-msg-meta">
        <p><strong>From:</strong> <?= e((string) ($message['full_name'] ?? '')) ?></p>
        <p><strong>Email:</strong> <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
        <p><strong>Subject:</strong> <?= e($subj) ?></p>
        <?php if (($message['service_interest'] ?? '') !== ''): ?>
            <p><strong>Service interest:</strong> <?= e((string) $message['service_interest']) ?></p>
        <?php endif; ?>
        <p><strong>Date:</strong> <?= e((string) ($message['created_at'] ?? '')) ?></p>
        <p><strong>IP:</strong> <?= e((string) ($message['ip_address'] ?? '')) ?></p>
    </div>
    <div class="admin-msg-actions">
        <form method="post" action="<?= e(base_url('admin/messages/star/' . $id)) ?>" class="admin-inline-form">
            <?= csrf_field() ?>
            <button type="submit" class="admin-btn admin-btn--ghost"><?= ((int) ($message['is_starred'] ?? 0)) === 1 ? '★ Unstar' : '☆ Star' ?></button>
        </form>
        <a class="admin-btn admin-btn--accent" href="<?= e($mailtoReply) ?>">Reply via Email</a>
        <form method="post" action="<?= e(base_url('admin/messages/delete/' . $id)) ?>" class="admin-inline-form" onsubmit="return confirm('Delete this message?');">
            <?= csrf_field() ?>
            <button type="submit" class="admin-btn admin-btn--danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card admin-msg-body">
    <h3 class="admin-msg-body__title">Message</h3>
    <div class="admin-msg-text"><?= nl2br(e((string) ($message['message'] ?? ''))) ?></div>
</div>
