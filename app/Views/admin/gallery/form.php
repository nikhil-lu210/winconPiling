<?php
declare(strict_types=1);
/** @var array<string, mixed>|null $item */
/** @var bool $isEdit */
$isEdit = $isEdit ?? false;
$item = $item ?? null;
?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/gallery')) ?>" class="admin-link-back">← Back to gallery</a>
    <h2 class="admin-page-head__title"><?= $isEdit ? 'Edit gallery item' : 'Add gallery item' ?></h2>
</div>

<?php include APP_PATH . '/Views/admin/partials/form-errors.php'; ?>

<form method="post" action="<?= e($isEdit ? base_url('admin/gallery/update/' . (int) ($item['id'] ?? 0)) : base_url('admin/gallery/store')) ?>" enctype="multipart/form-data" class="admin-form-card">
    <?= csrf_field() ?>
    <div class="admin-form-group">
        <label class="admin-label" for="title">Title <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="title" name="title" required maxlength="255" value="<?= e((string) ($item['title'] ?? '')) ?>">
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="description">Description</label>
        <textarea class="admin-input admin-input--textarea" id="description" name="description" rows="4"><?= e((string) ($item['description'] ?? '')) ?></textarea>
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label" for="category">Category <span class="admin-req">*</span></label>
            <select class="admin-input" id="category" name="category" required>
                <?php
                $cat = (string) ($item['category'] ?? '');
                $opts = ['piling' => 'Piling', 'civil' => 'Civil', 'infrastructure' => 'Infrastructure', 'real_estate' => 'Real Estate'];
                foreach ($opts as $v => $lab): ?>
                    <option value="<?= e($v) ?>" <?= $cat === $v ? 'selected' : '' ?>><?= e($lab) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="admin-form-group">
            <label class="admin-label" for="sort_order">Sort order</label>
            <input class="admin-input" type="number" id="sort_order" name="sort_order" value="<?= e((string) ($item['sort_order'] ?? '0')) ?>">
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="alt_text">Alt text</label>
        <input class="admin-input" type="text" id="alt_text" name="alt_text" maxlength="255" value="<?= e((string) ($item['alt_text'] ?? '')) ?>">
    </div>
    <div class="admin-form-row">
        <label class="admin-check"><input type="checkbox" name="is_featured" value="1" <?= ((int) ($item['is_featured'] ?? 0)) === 1 ? 'checked' : '' ?>> Featured</label>
        <label class="admin-check"><input type="checkbox" name="is_active" value="1" <?= ((int) ($item['is_active'] ?? 1)) === 1 ? 'checked' : '' ?>> Active</label>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="image"><?= $isEdit ? 'Replace image' : 'Image' ?> <?= $isEdit ? '' : '<span class="admin-req">*</span>' ?></label>
        <?php if ($isEdit && !empty($item['image_path'])): ?>
            <div class="admin-current-img">
                <img src="<?= e(media_url((string) $item['image_path'])) ?>" alt="" id="imgPreview" width="160" height="160" style="object-fit:cover;border-radius:8px;">
            </div>
        <?php endif; ?>
        <input class="admin-input" type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" data-preview-target="imgPreview" <?= $isEdit ? '' : 'required' ?>>
        <p class="admin-hint">JPG, PNG, or WebP. Max 5MB.</p>
        <?php if (!$isEdit): ?>
            <div id="newPreviewWrap" class="admin-current-img" hidden><img src="" alt="" id="newPreview" width="160" height="160" style="object-fit:cover;border-radius:8px;"></div>
        <?php endif; ?>
    </div>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent"><?= $isEdit ? 'Update' : 'Create' ?></button>
        <a href="<?= e(base_url('admin/gallery')) ?>" class="admin-btn admin-btn--ghost">Cancel</a>
    </div>
</form>
<script>
(function () {
    var input = document.getElementById('image');
    var prev = document.getElementById('newPreview');
    var wrap = document.getElementById('newPreviewWrap');
    if (input && prev && wrap) {
        input.addEventListener('change', function () {
            var f = input.files && input.files[0];
            if (!f) { wrap.hidden = true; return; }
            prev.src = URL.createObjectURL(f);
            wrap.hidden = false;
        });
    }
})();
</script>
