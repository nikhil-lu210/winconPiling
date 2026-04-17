<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $items */
?>
<div class="admin-page-head admin-page-head--row">
    <div>
        <h2 class="admin-page-head__title">Land listings</h2>
        <p class="admin-muted">Drag rows to reorder.</p>
    </div>
    <a class="admin-btn admin-btn--accent" href="<?= e(base_url('admin/land/create')) ?>"><i class="fas fa-plus"></i> Add listing</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th style="width:64px;">Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Active</th>
                <th style="width:200px;">Actions</th>
            </tr>
        </thead>
        <tbody id="landSortBody" data-reorder-url="<?= e(base_url('admin/land/reorder')) ?>">
            <?php foreach ($items as $row): ?>
                <?php
                $id = (int) ($row['id'] ?? 0);
                $img = media_url((string) ($row['image_path'] ?? ''));
                ?>
                <tr data-id="<?= $id ?>">
                    <td class="admin-drag-handle"><i class="fas fa-grip-vertical"></i></td>
                    <td>
                        <?php if ($img !== ''): ?>
                            <img src="<?= e($img) ?>" alt="" class="admin-thumb" width="50" height="50" loading="lazy">
                        <?php endif; ?>
                    </td>
                    <td><?= e((string) ($row['title'] ?? '')) ?></td>
                    <td><span class="admin-pill"><?= e(ucfirst((string) ($row['category'] ?? ''))) ?></span></td>
                    <td><?= e((string) ($row['price'] ?? '')) ?></td>
                    <td><?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'Yes' : 'No' ?></td>
                    <td class="admin-actions-cell">
                        <a class="admin-btn admin-btn--sm admin-btn--ghost" href="<?= e(base_url('admin/land/edit/' . $id)) ?>">Edit</a>
                        <form method="post" action="<?= e(base_url('admin/land/delete/' . $id)) ?>" class="admin-inline-form" onsubmit="return confirm('Delete this listing?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
