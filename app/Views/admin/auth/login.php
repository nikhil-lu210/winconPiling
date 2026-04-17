<?php
declare(strict_types=1);
$err = flash('error');
$info = flash('info');
?>
<div class="admin-auth-card">
    <div class="admin-auth-logo">
        <strong>WINCON PILLING</strong>
        <span>Construction Limited</span>
    </div>
    <p class="admin-auth-sub">Admin Panel</p>

    <?php if (is_string($err) && $err !== ''): ?>
        <div class="admin-auth-alert admin-auth-alert--error" role="alert"><?= e($err) ?></div>
    <?php endif; ?>
    <?php if (is_string($info) && $info !== ''): ?>
        <div class="admin-auth-alert admin-auth-alert--info" role="status"><?= e($info) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(base_url('admin/login')) ?>" autocomplete="on" novalidate>
        <?= csrf_field() ?>
        <div class="admin-auth-field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="username" required maxlength="100" value="">
        </div>
        <div class="admin-auth-field">
            <label for="password">Password</label>
            <div class="admin-auth-input-wrap">
                <input type="password" id="password" name="password" autocomplete="current-password" required>
                <button type="button" class="admin-auth-toggle-pw" id="togglePw" aria-label="Show password">Show</button>
            </div>
        </div>
        <button type="submit" class="admin-auth-submit">Sign In</button>
    </form>
    <p class="admin-auth-foot">Authorized access only</p>
</div>
<script>
(function () {
    var pw = document.getElementById('password');
    var btn = document.getElementById('togglePw');
    if (!pw || !btn) return;
    btn.addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        btn.textContent = show ? 'Hide' : 'Show';
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
})();
</script>
