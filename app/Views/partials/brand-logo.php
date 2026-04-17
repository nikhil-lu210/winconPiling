<?php
declare(strict_types=1);
/** @var string $brandLogoClass */
$class = $brandLogoClass ?? 'brand-logo';
?>
<picture class="<?= e($class) ?>">
    <source srcset="<?= e(asset('images/logo.webp')) ?>" type="image/webp">
    <img src="<?= e(asset('images/logo.png')) ?>" alt="Wincon Pilling" decoding="async" loading="eager">
</picture>
