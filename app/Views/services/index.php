<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $services */
/** @var array<string, string|null> $content */
$sm = new ServiceModel();
?>
<section class="inner-hero services-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-3 fw-bold mb-3"><?= e($content['services_hero_title'] ?? 'Our Core Expertise') ?></h1>
        <p class="lead opacity-75"><?= e($content['services_hero_subtitle'] ?? '') ?></p>
    </div>
</section>

<section class="section-padding bg-soft">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($services as $svc):
                $subs = $sm->decodeSubItems($svc);
                $slug = (string) ($svc['detail_page_slug'] ?? '');
                $href = $slug !== '' ? base_url('services/' . $slug) : base_url('contact');
                ?>
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="card-premium">
                        <div class="card-icon"><i class="<?= e((string) ($svc['icon_class'] ?? 'fas fa-hammer')) ?>"></i></div>
                        <h4 class="fw-bold mb-3"><?= e((string) $svc['title']) ?></h4>
                        <p class="text-muted mb-4"><?= e((string) ($svc['short_description'] ?? '')) ?></p>
                        <a href="<?= e($href) ?>" class="text-accent fw-bold text-decoration-none">Learn More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
