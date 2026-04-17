<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $items */
?>
<div class="admin-page-head admin-page-head--row">
    <div>
        <h2 class="admin-page-head__title">Services</h2>
        <p class="admin-muted">Drag rows to reorder.</p>
    </div>
    <a class="admin-btn admin-btn--accent" href="<?= e(base_url('admin/services/create')) ?>"><i class="fas fa-plus"></i> Add service</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th>Title</th>
                <th>Slug</th>
                <th>Active</th>
                <th>Sort</th>
                <th style="width:200px;">Actions</th>
            </tr>
        </thead>
        <tbody id="serviceSortBody" data-reorder-url="<?= e(base_url('admin/services/reorder')) ?>">
            <?php foreach ($items as $row): ?>
                <?php $id = (int) ($row['id'] ?? 0); ?>
                <tr data-id="<?= $id ?>">
                    <td class="admin-drag-handle"><i class="fas fa-grip-vertical"></i></td>
                    <td><?= e((string) ($row['title'] ?? '')) ?></td>
                    <td><code><?= e((string) ($row['slug'] ?? '')) ?></code></td>
                    <td>
                        <form method="post" action="<?= e(base_url('admin/services/toggle-active/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-toggle <?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'is-on' : '' ?>"><?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'On' : 'Off' ?></button>
                        </form>
                    </td>
                    <td><?= (int) ($row['sort_order'] ?? 0) ?></td>
                    <td class="admin-actions-cell">
                        <a class="admin-btn admin-btn--sm admin-btn--ghost" href="<?= e(base_url('admin/services/edit/' . $id)) ?>">Edit</a>
                        <form method="post" action="<?= e(base_url('admin/services/delete/' . $id)) ?>" class="admin-inline-form" onsubmit="return confirm('Delete this service?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
