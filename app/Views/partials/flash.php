<?php
declare(strict_types=1);
$success = flash('success');
$error = flash('error');
$contactErr = Session::getFlash('contact_error');
$errors = Session::getFlash('errors');
if (!is_array($errors)) {
    $errors = [];
}
?>
<div class="container py-2">
    <?php if (is_string($success) && $success !== ''): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert"><?= e($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (is_string($error) && $error !== ''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (is_string($contactErr) && $contactErr !== ''): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert"><?= e($contactErr) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($errors !== []): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $field => $msg): ?>
                    <li><?= e(is_string($msg) ? $msg : (string) $msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
