<?php
declare(strict_types=1);
/** @var string $errorMessage */
$msg = ($errorMessage ?? '') !== '' ? $errorMessage : 'The page you are looking for could not be found.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page not found — Wincon Pilling</title>
    <link rel="icon" href="<?= e(asset('images/favicon.ico')) ?>" sizes="any">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body class="bg-soft d-flex align-items-center min-vh-100">
<div class="container text-center py-5">
    <div class="error-page-brand">
        <?php $brandLogoClass = 'error-page-logo'; include APP_PATH . '/Views/partials/brand-logo.php'; ?>
    </div>
    <h1 class="display-4 fw-bold text-accent">404</h1>
    <p class="lead text-muted mb-4"><?= e($msg) ?></p>
    <a href="<?= e(base_url()) ?>" class="btn btn-premium btn-accent">Back to homepage</a>
</div>
</body>
</html>
