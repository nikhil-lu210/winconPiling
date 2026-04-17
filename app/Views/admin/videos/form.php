<?php
declare(strict_types=1);
/** @var array<string, mixed>|null $item */
/** @var bool $isEdit */
$isEdit = $isEdit ?? false;
$item = $item ?? null;
$yid = (string) ($item['youtube_id'] ?? '');
$thumb = $yid !== '' ? 'https://img.youtube.com/vi/' . rawurlencode($yid) . '/hqdefault.jpg' : '';
?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/videos')) ?>" class="admin-link-back">← Back to videos</a>
    <h2 class="admin-page-head__title"><?= $isEdit ? 'Edit video' : 'Add video' ?></h2>
</div>

<?php include APP_PATH . '/Views/admin/partials/form-errors.php'; ?>

<form method="post" action="<?= e($isEdit ? base_url('admin/videos/update/' . (int) ($item['id'] ?? 0)) : base_url('admin/videos/store')) ?>" class="admin-form-card">
    <?= csrf_field() ?>
    <div class="admin-form-group">
        <label class="admin-label" for="title">Title <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="title" name="title" required maxlength="255" value="<?= e((string) ($item['title'] ?? '')) ?>">
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="description">Description</label>
        <textarea class="admin-input admin-input--textarea" id="description" name="description" rows="4"><?= e((string) ($item['description'] ?? '')) ?></textarea>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="youtube_id">YouTube video ID <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="youtube_id" name="youtube_id" required maxlength="11" pattern="[a-zA-Z0-9_-]{11}" value="<?= e($yid) ?>">
        <p class="admin-hint">From <code>youtube.com/watch?v=XXXXXXXXXXX</code> — copy the 11-character ID.</p>
    </div>
    <div class="admin-form-group">
        <label class="admin-label">Preview</label>
        <div class="admin-yt-preview">
            <img src="<?= $thumb !== '' ? e($thumb) : '' ?>" alt="" id="ytPreview" width="320" height="180" style="object-fit:cover;border-radius:8px;<?= $thumb === '' ? 'display:none;' : '' ?>">
        </div>
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label" for="category">Category <span class="admin-req">*</span></label>
            <select class="admin-input" id="category" name="category" required>
                <?php $cat = (string) ($item['category'] ?? ''); ?>
                <?php foreach (['piling' => 'Piling', 'civil' => 'Civil', 'site' => 'Site', 'equipment' => 'Equipment'] as $v => $lab): ?>
                    <option value="<?= e($v) ?>" <?= $cat === $v ? 'selected' : '' ?>><?= e($lab) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="admin-form-group">
            <label class="admin-label" for="sort_order">Sort order</label>
            <input class="admin-input" type="number" id="sort_order" name="sort_order" value="<?= e((string) ($item['sort_order'] ?? '0')) ?>">
        </div>
    </div>
    <div class="admin-form-row">
        <label class="admin-check"><input type="checkbox" name="is_featured" value="1" <?= ((int) ($item['is_featured'] ?? 0)) === 1 ? 'checked' : '' ?>> Featured</label>
        <label class="admin-check"><input type="checkbox" name="is_active" value="1" <?= ((int) ($item['is_active'] ?? 1)) === 1 ? 'checked' : '' ?>> Active</label>
    </div>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent"><?= $isEdit ? 'Update' : 'Create' ?></button>
        <a href="<?= e(base_url('admin/videos')) ?>" class="admin-btn admin-btn--ghost">Cancel</a>
    </div>
</form>
