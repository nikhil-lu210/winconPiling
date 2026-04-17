<?php
declare(strict_types=1);
/** @var array<string, mixed>|null $item */
/** @var bool $isEdit */
/** @var array<int, mixed> $subItems */
$isEdit = $isEdit ?? false;
$item = $item ?? null;
$subItems = $subItems ?? [];
?>
<div class="admin-page-head">
    <a href="<?= e(base_url('admin/services')) ?>" class="admin-link-back">← Back to services</a>
    <h2 class="admin-page-head__title"><?= $isEdit ? 'Edit service' : 'Add service' ?></h2>
</div>

<?php include APP_PATH . '/Views/admin/partials/form-errors.php'; ?>

<form method="post" action="<?= e($isEdit ? base_url('admin/services/update/' . (int) ($item['id'] ?? 0)) : base_url('admin/services/store')) ?>" class="admin-form-card" data-admin-service-form data-is-edit="<?= $isEdit ? '1' : '0' ?>">
    <?= csrf_field() ?>
    <div class="admin-form-group">
        <label class="admin-label" for="title">Title <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="title" name="title" required maxlength="255" value="<?= e((string) ($item['title'] ?? '')) ?>">
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="slug">Slug <span class="admin-req">*</span></label>
        <input class="admin-input" type="text" id="slug" name="slug" required maxlength="255" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="<?= e((string) ($item['slug'] ?? '')) ?>">
        <p class="admin-hint">Lowercase letters, numbers, and hyphens only. Auto-filled from title.</p>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="short_description">Short description</label>
        <textarea class="admin-input admin-input--textarea" id="short_description" name="short_description" rows="3"><?= e((string) ($item['short_description'] ?? '')) ?></textarea>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="full_description">Full description</label>
        <textarea class="admin-input admin-input--textarea" id="full_description" name="full_description" rows="8"><?= e((string) ($item['full_description'] ?? '')) ?></textarea>
    </div>
    <div class="admin-form-group">
        <label class="admin-label" for="icon_class">Icon class</label>
        <input class="admin-input" type="text" id="icon_class" name="icon_class" placeholder="fas fa-hard-hat" value="<?= e((string) ($item['icon_class'] ?? '')) ?>">
        <p class="admin-hint">Font Awesome class, e.g. <code>fas fa-hard-hat</code></p>
    </div>
    <div class="admin-form-group">
        <label class="admin-label">Sub items</label>
        <div id="subItemsList" class="admin-dynamic-list">
            <?php foreach ($subItems as $i => $line): ?>
                <div class="admin-dynamic-row">
                    <input class="admin-input" type="text" name="sub_items[]" value="<?= e((string) $line) ?>">
                    <button type="button" class="admin-btn admin-btn--ghost admin-remove-row" aria-label="Remove">×</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="admin-btn admin-btn--ghost" id="addSubItem">+ Add bullet</button>
    </div>
    <div class="admin-form-row">
        <div class="admin-form-group">
            <label class="admin-label" for="detail_page_slug">Detail page slug</label>
            <input class="admin-input" type="text" id="detail_page_slug" name="detail_page_slug" value="<?= e((string) ($item['detail_page_slug'] ?? '')) ?>">
        </div>
        <div class="admin-form-group">
            <label class="admin-label" for="sort_order">Sort order</label>
            <input class="admin-input" type="number" id="sort_order" name="sort_order" value="<?= e((string) ($item['sort_order'] ?? '0')) ?>">
        </div>
    </div>
    <label class="admin-check"><input type="checkbox" name="is_active" value="1" <?= ((int) ($item['is_active'] ?? 1)) === 1 ? 'checked' : '' ?>> Active</label>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent"><?= $isEdit ? 'Update' : 'Create' ?></button>
        <a href="<?= e(base_url('admin/services')) ?>" class="admin-btn admin-btn--ghost">Cancel</a>
    </div>
</form>
