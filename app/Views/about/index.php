<?php
declare(strict_types=1);
/** @var array<string, string|null> $content */
/** @var array<string, string|null> $settings */
?>
<section class="inner-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-3 fw-bold mb-3"><?= e($content['about_hero_title'] ?? 'About Our Company') ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= e(base_url()) ?>" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-accent" aria-current="page"><?= e($content['about_hero_subtitle'] ?? 'About Us') ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-img-frame position-relative p-3">
                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=800&q=80" alt="About Wincon" class="rounded-4 w-100">
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="section-tag">Since 2008</div>
                <h2 class="fw-bold mb-4"><?= e($content['about_history_title'] ?? '') ?></h2>
                <?php $hist = $content['about_history_text'] ?? ''; ?>
                <div class="lead text-muted mb-4"><?= nl2br(e($hist)) ?></div>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="card-icon bg-accent-soft p-3 rounded-circle" style="color: var(--accent);"><i class="fas fa-bullseye"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0"><?= e($content['mission_title'] ?? '') ?></h6>
                                <p class="small mb-0 text-muted"><?= e($content['mission_text'] ?? '') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="card-icon bg-accent-soft p-3 rounded-circle" style="color: var(--accent);"><i class="fas fa-eye"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0"><?= e($content['vision_title'] ?? '') ?></h6>
                                <p class="small mb-0 text-muted"><?= e($content['vision_text'] ?? '') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-soft">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag">Values</div>
            <h2 class="fw-bold">What Drives Us</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="card-premium text-center">
                    <div class="fs-1 text-accent mb-4"><i class="fas fa-shield-alt"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['value1_title'] ?? '') ?></h4>
                    <p class="text-muted"><?= e($content['value1_text'] ?? '') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-premium text-center">
                    <div class="fs-1 text-accent mb-4"><i class="fas fa-microchip"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['value2_title'] ?? '') ?></h4>
                    <p class="text-muted"><?= e($content['value2_text'] ?? '') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-premium text-center">
                    <div class="fs-1 text-accent mb-4"><i class="fas fa-hard-hat"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['value3_title'] ?? '') ?></h4>
                    <p class="text-muted"><?= e($content['value3_text'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
