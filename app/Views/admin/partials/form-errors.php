<?php
declare(strict_types=1);
$errors = \Session::getFlash('errors');
if (!\is_array($errors)) {
    $errors = [];
}
?>
<?php if ($errors !== []): ?>
<div class="admin-card admin-card--error" role="alert">
    <strong>Please fix the following:</strong>
    <ul class="admin-error-list">
        <?php foreach (array_values($errors) as $msg): ?>
            <li><?= e(\is_string($msg) ? $msg : '') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
