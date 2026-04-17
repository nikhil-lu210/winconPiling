<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $messages */
/** @var string $filter */
/** @var int $unreadCount */
/** @var int $starredCount */
$base = base_url('admin/messages');
?>
<div class="admin-page-head admin-page-head--row">
    <div>
        <h2 class="admin-page-head__title">Messages</h2>
        <p class="admin-muted">Contact form submissions from the website.</p>
    </div>
</div>

<div class="admin-filter-tabs">
    <a class="admin-filter-tab <?= $filter === 'all' ? 'is-active' : '' ?>" href="<?= e($base) ?>">All</a>
    <a class="admin-filter-tab <?= $filter === 'unread' ? 'is-active' : '' ?>" href="<?= e($base . '?filter=unread') ?>">Unread <?php if ($unreadCount > 0): ?><span class="admin-badge-count"><?= (int) $unreadCount ?></span><?php endif; ?></a>
    <a class="admin-filter-tab <?= $filter === 'starred' ? 'is-active' : '' ?>" href="<?= e($base . '?filter=starred') ?>">Starred <?php if ($starredCount > 0): ?><span class="admin-badge-count"><?= (int) $starredCount ?></span><?php endif; ?></a>
</div>

<div class="admin-bulk-bar">
    <button type="button" class="admin-btn admin-btn--ghost" id="btnMarkRead">Mark selected as read</button>
    <button type="button" class="admin-btn admin-btn--danger" id="btnDeleteSel">Delete selected</button>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:36px;"><input type="checkbox" id="chkAll" title="Select all"></th>
                <th style="width:40px;"></th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Read</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $m): ?>
                <?php
                $id = (int) ($m['id'] ?? 0);
                $unread = ((int) ($m['is_read'] ?? 0)) === 0;
                $subj = (string) ($m['subject'] ?? '');
                $subjShort = mb_strlen($subj) > 50 ? mb_substr($subj, 0, 50) . '…' : $subj;
                $viewUrl = base_url('admin/messages/view/' . $id);
                ?>
                <tr class="<?= $unread ? 'admin-msg--unread' : '' ?> admin-msg-tr" data-href="<?= e($viewUrl) ?>">
                    <td onclick="event.stopPropagation();">
                        <input type="checkbox" class="msg-chk" name="ids[]" value="<?= $id ?>">
                    </td>
                    <td onclick="event.stopPropagation();">
                        <form method="post" action="<?= e(base_url('admin/messages/star/' . $id)) ?>" class="admin-inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-star-btn" title="Star"><?= ((int) ($m['is_starred'] ?? 0)) === 1 ? '★' : '☆' ?></button>
                        </form>
                    </td>
                    <td><?= e((string) ($m['full_name'] ?? '')) ?></td>
                    <td><?= e((string) ($m['email'] ?? '')) ?></td>
                    <td><?= e($subjShort) ?></td>
                    <td><?= e((string) ($m['created_at'] ?? '')) ?></td>
                    <td><?= $unread ? '<span class="admin-badge admin-badge--unread">Unread</span>' : '<span class="admin-badge admin-badge--read">Read</span>' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
(function () {
    var rows = document.querySelectorAll('.admin-msg-tr[data-href]');
    rows.forEach(function (tr) {
        tr.style.cursor = 'pointer';
        tr.addEventListener('click', function (e) {
            if (e.target.closest('input, form, button, a')) return;
            window.location = tr.getAttribute('data-href');
        });
    });
    var chkAll = document.getElementById('chkAll');
    var chks = document.querySelectorAll('.msg-chk');
    chkAll && chkAll.addEventListener('change', function () {
        chks.forEach(function (c) { c.checked = chkAll.checked; });
    });
    var token = document.querySelector('meta[name="csrf-token"]');
    token = token ? token.getAttribute('content') : '';
    function selectedIds() {
        var ids = [];
        document.querySelectorAll('.msg-chk:checked').forEach(function (c) { ids.push(c.value); });
        return ids;
    }
    document.getElementById('btnMarkRead') && document.getElementById('btnMarkRead').addEventListener('click', function () {
        var ids = selectedIds();
        if (!ids.length) { alert('Select at least one message.'); return; }
        var fd = new FormData();
        fd.append('_csrf_token', token);
        ids.forEach(function (id) { fd.append('ids[]', id); });
        fetch('<?= e(base_url('admin/messages/mark-read')) ?>', { method: 'POST', body: fd, credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (j) {
                if (j.success) location.reload();
                else alert('Could not update messages.');
            })
            .catch(function () { alert('Could not update messages.'); });
    });
    document.getElementById('btnDeleteSel') && document.getElementById('btnDeleteSel').addEventListener('click', function () {
        var ids = selectedIds();
        if (!ids.length) { alert('Select at least one message.'); return; }
        if (!confirm('Delete selected messages permanently?')) return;
        var fd = new FormData();
        fd.append('_csrf_token', token);
        ids.forEach(function (id) { fd.append('ids[]', id); });
        fetch('<?= e(base_url('admin/messages/delete-bulk')) ?>', { method: 'POST', body: fd, credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (j) {
                if (j.success) location.reload();
                else alert('Could not delete messages.');
            })
            .catch(function () { alert('Could not delete messages.'); });
    });
})();
</script>
