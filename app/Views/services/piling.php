<?php
declare(strict_types=1);
/** @var array<string, mixed> $service */
/** @var array<string, string|null> $content */
?>
<section class="inner-hero piling-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3"><?= e((string) ($service['title'] ?? 'Deep Piling Solutions')) ?></h1>
        <p class="lead max-width-600">The foundation of every great structure begins beneath the surface. Our piling techniques ensure maximum stability.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Rock-Solid Foundations for Complex Structures</h2>
                <p>At Wincon Pilling Construction Limited, we specialize in high-precision piling works that withstand the test of time and environmental factors. Our deep foundation services are tailored to the unique geological conditions of Nigeria.</p>
                <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1200&q=80" class="img-fluid rounded-4 my-5" alt="Piling work on site">
                <h4 class="fw-bold mb-3">1. Bored Piling</h4>
                <p>Ideal for urban areas where noise and vibration must be minimized. Bored piles are cast-in-place and can handle high vertical loads.</p>
                <h4 class="fw-bold mb-3">2. Driven Piling (Pre-cast)</h4>
                <p>A cost-effective solution for deep foundations in softer soils, using hydraulic hammers to drive pre-cast concrete piles to specific depths.</p>
                <h4 class="fw-bold mb-3">3. Micro Piling</h4>
                <p>Perfect for restricted access sites or for underpinning existing foundations that need reinforcement.</p>
                <div class="row mt-5 g-4">
                    <div class="col-md-6">
                        <div class="tech-spec-item">
                            <div class="tech-spec-icon"><i class="fas fa-tools"></i></div>
                            <h6 class="fw-bold">Modern Equipment</h6>
                            <p class="small text-muted mb-0">We use hydraulic rotary rigs and advanced testing equipment.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tech-spec-item">
                            <div class="tech-spec-icon"><i class="fas fa-check-double"></i></div>
                            <h6 class="fw-bold">Load Testing</h6>
                            <p class="small text-muted mb-0">Every pile is tested for integrity and load-bearing capacity.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <div class="sidebar-box">
                    <h4 class="fw-bold mb-4">Request a Technical Brief</h4>
                    <p class="small text-muted mb-4">Need specifications for your project? Contact our engineering team for a detailed consultation.</p>
                    <a href="<?= e(base_url('contact')) ?>" class="btn btn-dark w-100 rounded-pill py-2">Go to Contact</a>
                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">Quick Contact</h6>
                    <p class="small mb-1"><i class="fas fa-phone-alt me-2 text-accent"></i> <?= e($settings['company_phone'] ?? '') ?></p>
                    <p class="small"><i class="fas fa-envelope me-2 text-accent"></i> <?= e($settings['company_email'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
