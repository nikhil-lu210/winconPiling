<?php
declare(strict_types=1);
/** @var array<string, array<int, array<string, mixed>>> $contentGroups */
?>
<div class="admin-page-head">
    <h2 class="admin-page-head__title">Page contents</h2>
    <p class="admin-muted">Edit text blocks used on the public website, grouped by page.</p>
</div>

<?php foreach ($contentGroups as $page => $items): ?>
<details class="admin-accordion" open>
    <summary class="admin-accordion__summary"><?= e(admin_page_label($page)) ?> <span class="admin-badge admin-badge--muted"><?= count($items) ?></span></summary>
    <div class="admin-table-wrap admin-table-wrap--flush">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Preview</th>
                    <th style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $row): ?>
                    <?php
                    $val = (string) ($row['value'] ?? '');
                    $preview = mb_strlen($val) > 80 ? mb_substr($val, 0, 80) . '…' : $val;
                    ?>
                    <tr>
                        <td><?= e((string) ($row['label'] ?? '')) ?></td>
                        <td class="admin-muted" style="max-width:420px;"><?= e($preview) ?></td>
                        <td>
                            <a class="admin-btn admin-btn--sm admin-btn--accent" href="<?= e(base_url('admin/content/edit/' . (int) ($row['id'] ?? 0))) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</details>
<?php endforeach; ?>
