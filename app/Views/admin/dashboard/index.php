<?php
declare(strict_types=1);
/** @var int $galleryCount */
/** @var int $videoCount */
/** @var int $messageCount */
/** @var int $unreadMessages */
/** @var int $landCount */
/** @var array<int, array<string, mixed>> $recentMessages */
?>
<div class="admin-cards">
    <div class="admin-card">
        <p class="admin-card__label">Gallery items</p>
        <p class="admin-card__value"><?= (int) $galleryCount ?></p>
    </div>
    <div class="admin-card">
        <p class="admin-card__label">Videos</p>
        <p class="admin-card__value"><?= (int) $videoCount ?></p>
    </div>
    <div class="admin-card">
        <p class="admin-card__label">Messages</p>
        <p class="admin-card__value"><?= (int) $messageCount ?></p>
        <?php if ((int) $unreadMessages > 0): ?>
            <p class="admin-card__hint"><span class="admin-badge admin-badge--unread"><?= (int) $unreadMessages ?> unread</span></p>
        <?php endif; ?>
    </div>
    <div class="admin-card">
        <p class="admin-card__label">Land listings</p>
        <p class="admin-card__value"><?= (int) $landCount ?></p>
    </div>
</div>

<div class="admin-actions">
    <a class="admin-action-link" href="<?= e(base_url('admin/gallery/create')) ?>">
        <i class="fas fa-cloud-upload-alt" style="color:var(--admin-accent);"></i> Upload Gallery Image
    </a>
    <a class="admin-action-link" href="<?= e(base_url('admin/videos/create')) ?>">
        <i class="fas fa-video" style="color:var(--admin-accent);"></i> Add Video
    </a>
    <a class="admin-action-link" href="<?= e(base_url('admin/messages')) ?>">
        <i class="fas fa-inbox" style="color:var(--admin-accent);"></i> View Messages
    </a>
    <a class="admin-action-link" href="<?= e(base_url('admin/land/create')) ?>">
        <i class="fas fa-map-marked-alt" style="color:var(--admin-accent);"></i> Add Land Listing
    </a>
</div>

<h2 style="font-size:1rem;margin:0 0 0.75rem;font-weight:700;">Recent messages</h2>
<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentMessages === []): ?>
                <tr><td colspan="5" style="color:var(--admin-muted);">No messages yet.</td></tr>
            <?php else: ?>
                <?php foreach ($recentMessages as $m): ?>
                    <tr>
                        <td><?= e((string) ($m['full_name'] ?? '')) ?></td>
                        <td><?= e((string) ($m['email'] ?? '')) ?></td>
                        <td><?= e((string) ($m['subject'] ?? '')) ?></td>
                        <td><?= e((string) ($m['created_at'] ?? '')) ?></td>
                        <td>
                            <?php if ((int) ($m['is_read'] ?? 0) === 1): ?>
                                <span class="admin-badge admin-badge--read">Read</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge--unread">Unread</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<p style="margin-top:1.5rem;font-size:0.9rem;color:var(--admin-muted);">
    Quick links:
    <a href="<?= e(base_url('admin/content')) ?>">Page contents</a> ·
    <a href="<?= e(base_url('admin/gallery')) ?>">Gallery</a> ·
    <a href="<?= e(base_url('admin/videos')) ?>">Videos</a> ·
    <a href="<?= e(base_url('admin/services')) ?>">Services</a> ·
    <a href="<?= e(base_url('admin/land')) ?>">Land</a>
</p>
