<?php
declare(strict_types=1);
/** @var array<string, string|null> $settings */
$path = request_path();
?>
<nav class="navbar navbar-expand-lg sticky-top" aria-label="Primary">
    <div class="container">
        <a class="navbar-brand" href="<?= e(base_url()) ?>">
            <?php $brandLogoClass = 'navbar-brand-logo'; include APP_PATH . '/Views/partials/brand-logo.php'; ?>
            <span class="navbar-brand__text">WINCON <span style="color: var(--accent)">PILLING</span></span>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link<?= $path === '/about' ? ' active' : '' ?>" href="<?= e(base_url('about')) ?>"<?= $path === '/about' ? ' aria-current="page"' : '' ?>>About</a></li>
                <li class="nav-item"><a class="nav-link<?= str_starts_with($path, '/services') ? ' active' : '' ?>" href="<?= e(base_url('services')) ?>"<?= str_starts_with($path, '/services') ? ' aria-current="page"' : '' ?>>Services</a></li>
                <li class="nav-item"><a class="nav-link<?= $path === '/portfolio' ? ' active' : '' ?>" href="<?= e(base_url('portfolio')) ?>"<?= $path === '/portfolio' ? ' aria-current="page"' : '' ?>>Portfolio</a></li>
                <li class="nav-item"><a class="nav-link<?= $path === '/videos' ? ' active' : '' ?>" href="<?= e(base_url('videos')) ?>"<?= $path === '/videos' ? ' aria-current="page"' : '' ?>>Videos</a></li>
                <li class="nav-item"><a class="nav-link<?= $path === '/contact' ? ' active' : '' ?>" href="<?= e(base_url('contact')) ?>"<?= $path === '/contact' ? ' aria-current="page"' : '' ?>>Contact</a></li>
                <li class="nav-item ms-lg-4">
                    <a href="<?= e(base_url('contact')) ?>" class="btn btn-premium btn-accent py-2 px-4 shadow-sm">Get a Quote</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
