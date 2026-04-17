<?php
declare(strict_types=1);
/** @var string $content */
$pageTitle = $pageTitle ?? 'Admin';
$unreadMessages = $unreadMessages ?? 0;
$adminUser = $adminUser ?? [];
$settings = $settings ?? [];
$siteName = $settings['company_name'] ?? 'Wincon Pilling';
$uri = request_path();
$navActive = static function (string $prefix) use ($uri): bool {
    $prefix = '/' . trim($prefix, '/');
    return $uri === $prefix || str_starts_with($uri, $prefix . '/');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <title><?= e((string) $pageTitle) ?> — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body class="admin-body">
<div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" aria-hidden="true"></div>
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
        <div class="admin-sidebar__brand">
            <strong><?= e($siteName) ?></strong>
            <span>Administration</span>
        </div>
        <nav class="admin-nav" aria-label="Primary">
            <a href="<?= e(base_url('admin/dashboard')) ?>" class="<?= $navActive('/admin/dashboard') ? 'is-active' : '' ?>">
                <i class="fas fa-th-large" aria-hidden="true"></i> Dashboard
            </a>
            <div class="admin-nav__label">Content</div>
            <a href="<?= e(base_url('admin/content')) ?>" class="<?= $navActive('/admin/content') ? 'is-active' : '' ?> admin-nav__sub">
                <i class="fas fa-file-alt" aria-hidden="true"></i> Page Contents
            </a>
            <a href="<?= e(base_url('admin/settings')) ?>" class="admin-nav__sub <?= $navActive('/admin/settings') ? 'is-active' : '' ?>">
                <i class="fas fa-sliders-h" aria-hidden="true"></i> Site Settings
            </a>
            <a href="<?= e(base_url('admin/gallery')) ?>" class="<?= $navActive('/admin/gallery') ? 'is-active' : '' ?>">
                <i class="fas fa-images" aria-hidden="true"></i> Gallery
            </a>
            <a href="<?= e(base_url('admin/videos')) ?>" class="<?= $navActive('/admin/videos') ? 'is-active' : '' ?>">
                <i class="fas fa-play-circle" aria-hidden="true"></i> Videos
            </a>
            <a href="<?= e(base_url('admin/messages')) ?>" class="<?= $navActive('/admin/messages') ? 'is-active' : '' ?>">
                <i class="fas fa-envelope" aria-hidden="true"></i> Messages
                <?php if ((int) $unreadMessages > 0): ?>
                    <span class="badge-ms"><?= (int) $unreadMessages ?></span>
                <?php endif; ?>
            </a>
            <a href="<?= e(base_url('admin/services')) ?>" class="<?= $navActive('/admin/services') ? 'is-active' : '' ?>">
                <i class="fas fa-wrench" aria-hidden="true"></i> Services
            </a>
            <a href="<?= e(base_url('admin/land')) ?>" class="<?= $navActive('/admin/land') ? 'is-active' : '' ?>">
                <i class="fas fa-map-pin" aria-hidden="true"></i> Land Listings
            </a>
            <div class="admin-nav__sep" role="separator"></div>
            <a href="<?= e(base_url('')) ?>" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-external-link-alt" aria-hidden="true"></i> View Website
            </a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <button type="button" class="admin-mobile-toggle" id="adminNavToggle" aria-label="Open menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="admin-topbar__title"><?= e((string) $pageTitle) ?></h1>
            </div>
            <div class="admin-topbar__meta">
                <?php if ((int) $unreadMessages > 0): ?>
                    <a href="<?= e(base_url('admin/messages')) ?>" class="admin-btn admin-btn--accent" style="text-decoration:none;">
                        <i class="fas fa-envelope"></i> <?= (int) $unreadMessages ?> unread
                    </a>
                <?php endif; ?>
                <span class="admin-topbar__user">
                    <i class="fas fa-user-shield" aria-hidden="true"></i>
                    <?= e((string) ($adminUser['username'] ?? 'Admin')) ?>
                </span>
                <form method="post" action="<?= e(base_url('admin/logout')) ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="admin-btn admin-btn--danger">Logout</button>
                </form>
            </div>
        </header>
        <div class="admin-content">
            <?php
            $flashErr = flash('error');
            $flashOk = flash('success');
            $flashInfo = flash('info');
            ?>
            <?php if (is_string($flashErr) && $flashErr !== ''): ?>
                <div class="admin-flash admin-flash--error" role="alert"><?= e($flashErr) ?></div>
            <?php endif; ?>
            <?php if (is_string($flashOk) && $flashOk !== ''): ?>
                <div class="admin-flash admin-flash--success" role="status"><?= e($flashOk) ?></div>
            <?php endif; ?>
            <?php if (is_string($flashInfo) && $flashInfo !== ''): ?>
                <div class="admin-flash admin-flash--info" role="status"><?= e($flashInfo) ?></div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="<?= e(asset('js/admin.js')) ?>"></script>
</body>
</html>
