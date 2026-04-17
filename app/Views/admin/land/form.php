<?php
declare(strict_types=1);
/** @var array<string, mixed>|null $item */
/** @var bool $isEdit */
/** @var array<int, mixed> $features */
$isEdit = $isEdit ?? false;
$item = $item ?? null;
$features = $features ?? [];
?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/land')) ?>" class="admin-link-back">← Back to land listings</a>
    <h2 class="admin-page-head__title"><?= $isEdit ? 'Edit land listing' : 'Add land listing' ?></h2>
</div>

<?php include APP_PATH . '/Views/admin/partials/form-errors.php'; ?>

<form method="post" action="<?= e($isEdit ? base_url('admin/land/update/' . (int) ($item['id'] ?? 0)) : base_url('admin/land/store')) ?>" enctype="multipart/form-data" class="admin-form-card" data-admin-land-form>
    <?= csrf_field() ?>
    <div class="admin-form-group">
        <label class="admin-label" for="title">Title <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="title" name="title" required maxlength="255" value="<?= e((string) ($item['title'] ?? '')) ?>">
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label" for="category">Category <span class="admin-req">*</span></label>
            <select class="admin-input" id="category" name="category" required>
                <?php $cat = (string) ($item['category'] ?? ''); ?>
                <option value="commercial" <?= $cat === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                <option value="residential" <?= $cat === 'residential' ? 'selected' : '' ?>>Residential</option>
            </select>
        </div>
        <div class="admin-form-group">
            <label class="admin-label" for="sort_order">Sort order</label>
            <input class="admin-input" type="number" id="sort_order" name="sort_order" value="<?= e((string) ($item['sort_order'] ?? '0')) ?>">
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="location">Location</label>
        <input class="admin-input" type="text" id="location" name="location" value="<?= e((string) ($item['location'] ?? '')) ?>">
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label" for="size_sqm">Size (m²)</label>
            <input class="admin-input" type="number" id="size_sqm" name="size_sqm" min="0" step="1" value="<?= e((string) ($item['size_sqm'] ?? '')) ?>">
        </div>
        <div class="admin-form-group">
            <label class="admin-label" for="price">Price</label>
            <input class="admin-input" type="text" id="price" name="price" value="<?= e((string) ($item['price'] ?? '')) ?>">
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="description">Description</label>
        <textarea class="admin-input admin-input--textarea" id="description" name="description" rows="6"><?= e((string) ($item['description'] ?? '')) ?></textarea>
    </div>
    <div class="admin-form-group">
        <label class="admin-label">Features</label>
        <div id="featuresList" class="admin-dynamic-list">
            <?php foreach ($features as $line): ?>
                <div class="admin-dynamic-row">
                    <input class="admin-input" type="text" name="features[]" value="<?= e((string) $line) ?>">
                    <button type="button" class="admin-btn admin-btn--ghost admin-remove-row" aria-label="Remove">×</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="admin-btn admin-btn--ghost" id="addFeature">+ Add feature</button>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="image"><?= $isEdit ? 'Replace image' : 'Image' ?> <?= $isEdit ? '' : '<span class="admin-req">*</span>' ?></label>
        <?php if ($isEdit && !empty($item['image_path'])): ?>
            <div class="admin-current-img">
                <img src="<?= e(media_url((string) $item['image_path'])) ?>" alt="" width="160" height="160" style="object-fit:cover;border-radius:8px;">
            </div>
        <?php endif; ?>
        <img src="" alt="" id="landImgPreview" width="160" height="160" style="display:none;object-fit:cover;border-radius:8px;margin-bottom:0.5rem;">
        <input class="admin-input" type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" data-preview-target="landImgPreview" <?= $isEdit ? '' : 'required' ?>>
        <p class="admin-hint">JPG, PNG, or WebP. Max 5MB.</p>
    </div>
    <label class="admin-check"><input type="checkbox" name="is_active" value="1" <?= ((int) ($item['is_active'] ?? 1)) === 1 ? 'checked' : '' ?>> Active</label>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent"><?= $isEdit ? 'Update' : 'Create' ?></button>
        <a href="<?= e(base_url('admin/land')) ?>" class="admin-btn admin-btn--ghost">Cancel</a>
    </div>
</form>
