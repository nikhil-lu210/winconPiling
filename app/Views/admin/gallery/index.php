<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $items */
?>
<div class="admin-page-head admin-page-head--row">
    <div>
        <h2 class="admin-page-head__title">Gallery</h2>
        <p class="admin-muted">Drag rows to reorder. Changes save automatically.</p>
    </div>
    <a class="admin-btn admin-btn--accent" href="<?= e(base_url('admin/gallery/create')) ?>"><i class="fas fa-plus"></i> Add New</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table" id="galleryTable">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th style="width:56px;">Thumb</th>
                <th>Title</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th style="width:200px;">Actions</th>
            </tr>
        </thead>
        <tbody id="gallerySortBody" data-reorder-url="<?= e(base_url('admin/gallery/reorder')) ?>">
            <?php foreach ($items as $row): ?>
                <?php
                $id = (int) ($row['id'] ?? 0);
                $img = media_url((string) ($row['image_path'] ?? ''));
                ?>
                <tr data-id="<?= $id ?>">
                    <td class="admin-drag-handle" title="Drag"><i class="fas fa-grip-vertical"></i></td>
                    <td>
                        <?php if ($img !== ''): ?>
                            <img src="<?= e($img) ?>" alt="" class="admin-thumb" width="50" height="50" loading="lazy">
                        <?php endif; ?>
                    </td>
                    <td><?= e((string) ($row['title'] ?? '')) ?></td>
                    <td><span class="admin-pill"><?= e(admin_gallery_category_label((string) ($row['category'] ?? ''))) ?></span></td>
                    <td>
                        <form method="post" action="<?= e(base_url('admin/gallery/toggle-featured/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-toggle <?= ((int) ($row['is_featured'] ?? 0)) === 1 ? 'is-on' : '' ?>" title="Toggle featured">
                                <?= ((int) ($row['is_featured'] ?? 0)) === 1 ? '★' : '☆' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= e(base_url('admin/gallery/toggle-active/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-toggle <?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'is-on' : '' ?>" title="Toggle active">
                                <?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'On' : 'Off' ?>
                            </button>
                        </form>
                    </td>
                    <td class="admin-actions-cell">
                        <a class="admin-btn admin-btn--sm admin-btn--ghost" href="<?= e(base_url('admin/gallery/edit/' . $id)) ?>">Edit</a>
                        <form method="post" action="<?= e(base_url('admin/gallery/delete/' . $id)) ?>" class="admin-inline-form" onsubmit="return confirm('Delete this gallery item?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
