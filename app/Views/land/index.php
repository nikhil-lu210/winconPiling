<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $landListings */
/** @var array<string, string|null> $content */
$lm = new LandListingModel();
?>
<section class="inner-hero land-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3"><?= e($content['land_hero_title'] ?? '') ?></h1>
        <p class="lead"><?= e($content['land_hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($landListings as $listing):
                $feats = $lm->decodeFeatures($listing);
                $img = !empty($listing['image_path']) ? media_url((string) $listing['image_path']) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80';
                $isComm = ($listing['category'] ?? '') === 'commercial';
                ?>
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="listing-card">
                        <div class="listing-img"><img src="<?= e($img) ?>" alt="<?= e((string) $listing['title']) ?>"></div>
                        <div class="listing-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary"><?= e($isComm ? 'Commercial' : 'Residential') ?></span>
                                <span class="price-badge"><?= e((string) ($listing['price'] ?? '')) ?></span>
                            </div>
                            <h4 class="fw-bold mb-3"><?= e((string) $listing['title']) ?></h4>
                            <p class="text-muted mb-4"><?= e((string) ($listing['description'] ?? '')) ?></p>
                            <div class="d-flex gap-3 mb-4 flex-wrap">
                                <?php if (!empty($listing['size_sqm'])): ?>
                                    <span class="small"><i class="fas fa-expand me-1"></i> <?= (int) $listing['size_sqm'] ?> SQM</span>
                                <?php endif; ?>
                                <?php foreach ($feats as $f): ?>
                                    <span class="small"><i class="fas fa-check me-1 text-accent"></i> <?= e((string) $f) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="<?= e(base_url('contact')) ?>" class="btn btn-dark w-100 rounded-pill"><?= e($isComm ? 'Inquire Now' : 'Book a Site Visit') ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-soft">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Why Invest with Wincon?</h2>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex gap-3"><i class="fas fa-check-circle text-accent mt-1"></i> <span><?= e($content['why_invest_point1'] ?? '') ?></span></li>
                    <li class="mb-3 d-flex gap-3"><i class="fas fa-check-circle text-accent mt-1"></i> <span><?= e($content['why_invest_point2'] ?? '') ?></span></li>
                    <li class="mb-3 d-flex gap-3"><i class="fas fa-check-circle text-accent mt-1"></i> <span><?= e($content['why_invest_point3'] ?? '') ?></span></li>
                </ul>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80" class="img-fluid rounded-4 shadow" alt="Secure property investment">
            </div>
        </div>
    </div>
</section>
