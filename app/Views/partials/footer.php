<?php
declare(strict_types=1);
/** @var array<string, string|null> $settings */
$rc = e($settings['company_rc'] ?? '766863');
$founded = e($settings['company_founded'] ?? 'August 20, 2008');
$copy = e($settings['footer_copyright'] ?? '© 2024 Wincon Pilling Construction Limited. All Rights Reserved.');
?>
<footer class="section-padding bg-primary text-white footer">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                    <h4 class="fw-bold mb-4">WINCON <span class="text-accent">PILLING</span></h4>
                    <p class="opacity-75" style="max-width: 300px;"><?= e($settings['company_tagline'] ?? 'Providing world-class engineering and real estate solutions across Nigeria since 2008.') ?></p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white opacity-50 hover-opacity-100" aria-label="LinkedIn"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="#" class="text-white opacity-50 hover-opacity-100" aria-label="Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://www.instagram.com/winconconstruction231/" class="text-white opacity-50 hover-opacity-100" target="_blank" rel="noopener noreferrer" title="Instagram — Wincon Pilling Construction"><i class="fab fa-instagram fa-lg"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-4">Services</h6>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2"><a href="<?= e(base_url('services/piling')) ?>" class="text-white text-decoration-none small">Deep Piling</a></li>
                    <li class="mb-2"><a href="<?= e(base_url('services')) ?>" class="text-white text-decoration-none small">Soil Analysis</a></li>
                    <li class="mb-2"><a href="<?= e(base_url('services')) ?>" class="text-white text-decoration-none small">Civil Engineering</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-4">Company</h6>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2"><a href="<?= e(base_url('about')) ?>" class="text-white text-decoration-none small">About Us</a></li>
                    <li class="mb-2"><a href="<?= e(base_url('portfolio')) ?>" class="text-white text-decoration-none small">Our Portfolio</a></li>
                    <li class="mb-2"><a href="<?= e(base_url('videos')) ?>" class="text-white text-decoration-none small">Videos</a></li>
                    <li class="mb-2"><a href="<?= e(base_url('contact')) ?>" class="text-white text-decoration-none small">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-bold mb-4">Accreditation</h6>
                <p class="small opacity-75">RC No: <?= $rc ?></p>
                <p class="small opacity-75 mb-0">Incorporated on <?= $founded ?> with the Corporate Affairs Commission Nigeria.</p>
            </div>
        </div>
        <hr class="opacity-25">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-4">
            <p class="small opacity-50 mb-0"><?= $copy ?></p>
            <p class="small opacity-50 mb-0">Designed for Excellence.</p>
        </div>
    </div>
</footer>
