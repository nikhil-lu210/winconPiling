<?php
declare(strict_types=1);
/** @var array<string, mixed> $item */
$type = (string) ($item['content_type'] ?? 'text');
?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/content')) ?>" class="admin-link-back">← Back to page contents</a>
    <h2 class="admin-page-head__title">Edit content</h2>
</div>

<form method="post" action="<?= e(base_url('admin/content/update/' . (int) ($item['id'] ?? 0))) ?>" class="admin-form-card">
    <?= csrf_field() ?>
    <div class="admin-form-group">
        <label class="admin-label">Label</label>
        <div class="admin-readonly"><?= e((string) ($item['label'] ?? '')) ?></div>
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label">Page</label>
            <div class="admin-readonly"><?= e((string) ($item['page'] ?? '')) ?></div>
        </div>
        <div class="admin-form-group">
            <label class="admin-label">Section key</label>
            <div class="admin-readonly"><?= e((string) ($item['section_key'] ?? '')) ?></div>
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="value">Value</label>
        <?php if ($type === 'textarea' || $type === 'html'): ?>
            <?php if ($type === 'html'): ?>
                <p class="admin-hint">HTML is allowed. Ensure markup is valid and safe for public display.</p>
            <?php endif; ?>
            <textarea class="admin-input admin-input--textarea" id="value" name="value" rows="12"><?= e((string) ($item['value'] ?? '')) ?></textarea>
        <?php else: ?>
            <input class="admin-input" type="text" id="value" name="value" value="<?= e((string) ($item['value'] ?? '')) ?>">
        <?php endif; ?>
    </div>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent">Save</button>
        <a href="<?= e(base_url('admin/content')) ?>" class="admin-btn admin-btn--ghost">Cancel</a>
    </div>
</form>
