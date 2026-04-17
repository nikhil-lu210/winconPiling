<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $items */
?>
<div class="admin-page-head admin-page-head--row">
    <div>
        <h2 class="admin-page-head__title">Videos</h2>
        <p class="admin-muted">Drag rows to reorder.</p>
    </div>
    <a class="admin-btn admin-btn--accent" href="<?= e(base_url('admin/videos/create')) ?>"><i class="fas fa-plus"></i> Add video</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table" id="videoTable">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th style="width:90px;">Thumb</th>
                <th>Title</th>
                <th>YouTube</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th style="width:200px;">Actions</th>
            </tr>
        </thead>
        <tbody id="videoSortBody" data-reorder-url="<?= e(base_url('admin/videos/reorder')) ?>">
            <?php foreach ($items as $row): ?>
                <?php
                $id = (int) ($row['id'] ?? 0);
                $yid = (string) ($row['youtube_id'] ?? '');
                $thumb = $yid !== '' ? 'https://img.youtube.com/vi/' . rawurlencode($yid) . '/hqdefault.jpg' : '';
                $watch = 'https://www.youtube.com/watch?v=' . rawurlencode($yid);
                ?>
                <tr data-id="<?= $id ?>">
                    <td class="admin-drag-handle"><i class="fas fa-grip-vertical"></i></td>
                    <td>
                        <?php if ($thumb !== ''): ?>
                            <img src="<?= e($thumb) ?>" alt="" class="admin-thumb" width="80" height="45" loading="lazy" style="object-fit:cover;">
                        <?php endif; ?>
                    </td>
                    <td><?= e((string) ($row['title'] ?? '')) ?></td>
                    <td>
                        <code><?= e($yid) ?></code>
                        <a href="<?= e($watch) ?>" target="_blank" rel="noopener noreferrer" class="admin-icon-link" title="Open on YouTube"><i class="fas fa-external-link-alt"></i></a>
                    </td>
                    <td><span class="admin-pill"><?= e(wincon_video_category_label((string) ($row['category'] ?? ''))) ?></span></td>
                    <td>
                        <form method="post" action="<?= e(base_url('admin/videos/toggle-featured/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-toggle <?= ((int) ($row['is_featured'] ?? 0)) === 1 ? 'is-on' : '' ?>"><?= ((int) ($row['is_featured'] ?? 0)) === 1 ? '★' : '☆' ?></button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= e(base_url('admin/videos/toggle-active/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-toggle <?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'is-on' : '' ?>"><?= ((int) ($row['is_active'] ?? 0)) === 1 ? 'On' : 'Off' ?></button>
                        </form>
                    </td>
                    <td class="admin-actions-cell">
                        <a class="admin-btn admin-btn--sm admin-btn--ghost" href="<?= e(base_url('admin/videos/edit/' . $id)) ?>">Edit</a>
                        <form method="post" action="<?= e(base_url('admin/videos/delete/' . $id)) ?>" class="admin-inline-form" onsubmit="return confirm('Delete this video?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
