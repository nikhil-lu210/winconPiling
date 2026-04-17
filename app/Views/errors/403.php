<?php
declare(strict_types=1);
/** @var string $errorMessage */
$msg = ($errorMessage ?? '') !== '' ? $errorMessage : 'You do not have permission to access this resource.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forbidden — Wincon Pilling</title>
    <link rel="icon" href="<?= e(asset('images/favicon.ico')) ?>" sizes="any">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body class="bg-soft d-flex align-items-center min-vh-100">
<div class="container text-center py-5">
    <h1 class="display-4 fw-bold text-accent">403</h1>
    <p class="lead text-muted mb-4"><?= e($msg) ?></p>
    <a href="<?= e(base_url()) ?>" class="btn btn-premium btn-accent">Back to homepage</a>
</div>
</body>
</html>
