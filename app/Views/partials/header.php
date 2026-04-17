<?php
declare(strict_types=1);
/** @var array<string, string|null> $settings */
$rc = e($settings['company_rc'] ?? '766863');
?>
<div class="top-bar text-center">
    <div class="container">
        <i class="fas fa-certificate me-2 text-accent"></i> REGISTERED WITH CORPORATE AFFAIRS COMMISSION
        NIGERIA • <strong>RC: <?= $rc ?></strong>
    </div>
</div>
<?php include __DIR__ . '/nav.php'; ?>
