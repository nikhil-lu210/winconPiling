<?php
declare(strict_types=1);
/** @var array<string, string|null> $content */
/** @var array<int, array<string, mixed>> $featuredGallery */
/** @var array<int, array<string, mixed>> $featuredVideos */
/** @var array<int, array<string, mixed>> $services */
/** @var array<int, array<string, mixed>> $landListings */
/** @var array<string, string|null> $settings */
$sm = new ServiceModel();
$previewServices = array_slice($services, 0, 3);
?>
<header class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 hero-content" data-aos="fade-right">
                <div class="section-tag"><?= e($content['hero_established'] ?? 'Established 2008') ?></div>
                <h1><?= e($content['hero_title'] ?? 'Building Solid Foundations Across Nigeria.') ?></h1>
                <p><?= e($content['hero_subtitle'] ?? '') ?></p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= e(base_url('services')) ?>" class="btn btn-premium btn-accent">Explore Services <i class="fas fa-arrow-right"></i></a>
                    <a href="<?= e(base_url('portfolio')) ?>" class="btn btn-premium btn-outline-dark">Our Portfolio</a>
                </div>
                <div class="mt-5 d-flex align-items-center gap-4">
                    <div class="d-flex -space-x-2">
                        <img src="https://i.pravatar.cc/100?u=1" class="rounded-circle border border-2 border-white" width="40" height="40" alt="">
                        <img src="https://i.pravatar.cc/100?u=2" class="rounded-circle border border-2 border-white ms-n2" width="40" height="40" alt="">
                        <img src="https://i.pravatar.cc/100?u=3" class="rounded-circle border border-2 border-white ms-n2" width="40" height="40" alt="">
                    </div>
                    <div class="small fw-bold">
                        <div class="text-warning">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <?= e($content['hero_stat_label'] ?? '500+ Foundations Laid') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=800&q=80" alt="" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</header>

<section id="about" class="section-padding bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up">
                <div class="p-4">
                    <h2 class="fw-bold text-accent mb-1"><?= e($content['stats_years'] ?? '15+ Years') ?></h2>
                    <p class="text-muted fw-semi-bold"><?= e($content['stats_years_label'] ?? 'Engineering Excellence') ?></p>
                </div>
            </div>
            <div class="col-md-4 border-start border-end" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4">
                    <h2 class="fw-bold text-accent mb-1"><?= e($content['stats_licensed'] ?? 'Fully Licensed') ?></h2>
                    <p class="text-muted fw-semi-bold"><?= e($content['stats_licensed_label'] ?? 'RC 766863 - Nigeria') ?></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4">
                    <h2 class="fw-bold text-accent mb-1"><?= e($content['stats_tier'] ?? 'Top Tier') ?></h2>
                    <p class="text-muted fw-semi-bold"><?= e($content['stats_tier_label'] ?? 'Piling & Civil Equipment') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="why-us" class="section-padding bg-soft">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="section-tag">Why choose us</div>
            <h2 class="section-title"><?= e($content['why_us_title'] ?? '') ?></h2>
            <p class="text-muted mt-3 mx-auto" style="max-width: 640px;"><?= e($content['why_us_subtitle'] ?? '') ?></p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="why-card">
                    <div class="why-icon"><i class="fas fa-hard-hat"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['why_safety_title'] ?? '') ?></h4>
                    <p class="text-muted small mb-0"><?= e($content['why_safety_text'] ?? '') ?></p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="80">
                <div class="why-card">
                    <div class="why-icon"><i class="fas fa-user-check"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['why_team_title'] ?? '') ?></h4>
                    <p class="text-muted small mb-0"><?= e($content['why_team_text'] ?? '') ?></p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="160">
                <div class="why-card">
                    <div class="why-icon"><i class="fas fa-comments"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['why_client_title'] ?? '') ?></h4>
                    <p class="text-muted small mb-0"><?= e($content['why_client_text'] ?? '') ?></p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="240">
                <div class="why-card">
                    <div class="why-icon"><i class="fas fa-balance-scale"></i></div>
                    <h4 class="fw-bold mb-3"><?= e($content['why_finance_title'] ?? '') ?></h4>
                    <p class="text-muted small mb-0"><?= e($content['why_finance_text'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="section-padding bg-soft">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="section-tag">Expertise</div>
            <h2 class="section-title">Comprehensive Engineering Solutions</h2>
            <p class="text-muted mt-3 mx-auto" style="max-width: 600px;">We combine advanced technology with deep soil expertise to provide rock-solid foundations.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($previewServices as $svc):
                $subs = $sm->decodeSubItems($svc);
                $detail = $svc['detail_page_slug'] ? base_url('services/' . $svc['detail_page_slug']) : base_url('services');
                ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card-premium">
                        <div class="card-icon"><i class="<?= e((string) ($svc['icon_class'] ?? 'fas fa-hammer')) ?>"></i></div>
                        <h4 class="fw-bold mb-3"><?= e((string) $svc['title']) ?></h4>
                        <p class="text-muted"><?= e((string) ($svc['short_description'] ?? '')) ?></p>
                        <ul class="list-unstyled mt-4 mb-4">
                            <?php foreach (array_slice($subs, 0, 2) as $bullet): ?>
                                <li class="feature-item"><div class="feature-check"><i class="fas fa-check"></i></div> <?= e((string) $bullet) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="<?= e($detail) ?>" class="text-accent fw-bold text-decoration-none">Learn More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="works" class="section-padding">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag">Portfolio</div>
            <h2 class="section-title">Engineering Masterpieces</h2>
        </div>
        <div class="row g-4">
            <?php if ($featuredGallery === []): ?>
                <p class="text-muted">Portfolio highlights will appear here once added in the admin panel.</p>
            <?php else: ?>
                <?php foreach ($featuredGallery as $item):
                    $img = media_url((string) $item['image_path']);
                    $badge = wincon_category_label((string) $item['category']);
                    ?>
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                        <div class="project-card">
                            <a href="<?= e($img) ?>" class="glightbox project-card-link" data-gallery="home-works" data-glightbox="title: <?= e((string) $item['title']) ?>; description: <?= e((string) ($item['description'] ?? '')) ?>">
                                <img src="<?= e($img) ?>" class="project-img" alt="<?= e((string) ($item['alt_text'] ?? $item['title'])) ?>">
                                <div class="project-overlay">
                                    <span class="badge bg-accent mb-2"><?= e($badge) ?></span>
                                    <h5 class="text-white fw-bold"><?= e((string) $item['title']) ?></h5>
                                    <p class="text-white-50 small mb-0"><?= e((string) ($item['description'] ?? '')) ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="videos" class="section-padding bg-soft" aria-labelledby="home-videos-heading">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="section-tag">On site</div>
            <h2 id="home-videos-heading" class="section-title">Project videos</h2>
            <p class="text-muted mt-3 mx-auto" style="max-width: 640px;">Short clips from our sites and projects. Nothing heavy loads until you press play—better speed and Core Web Vitals.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($featuredVideos as $vid): ?>
                <div class="col-md-6 col-lg-5" data-aos="fade-up">
                    <div class="video-gallery-item rounded-4 overflow-hidden shadow">
                        <lite-youtube videoid="<?= e((string) $vid['youtube_id']) ?>" title="<?= e((string) $vid['title']) ?>" params="rel=0&amp;modestbranding=1"></lite-youtube>
                    </div>
                    <p class="small text-muted text-center mt-2 mb-0"><?= e(wincon_video_category_label((string) $vid['category'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= e(base_url('videos')) ?>" class="btn btn-premium btn-accent">Full video gallery</a>
        </div>
    </div>
</section>

<section class="section-padding bg-primary text-white overflow-hidden">
    <div class="container position-relative">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="section-tag" style="background: rgba(255,255,255,0.1); color: white;">Workflow</div>
            <h2 class="section-title text-white"><?= e($content['workflow_title'] ?? '') ?></h2>
        </div>
        <div class="row g-4 text-center mt-5">
            <div class="col-md-4" data-aos="fade-up">
                <div class="mb-4 d-inline-flex bg-accent rounded-circle justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">1</div>
                <h4><?= e($content['workflow_step1_title'] ?? '') ?></h4>
                <p class="opacity-75"><?= e($content['workflow_step1_text'] ?? '') ?></p>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-4 d-inline-flex bg-accent rounded-circle justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">2</div>
                <h4><?= e($content['workflow_step2_title'] ?? '') ?></h4>
                <p class="opacity-75"><?= e($content['workflow_step2_text'] ?? '') ?></p>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="mb-4 d-inline-flex bg-accent rounded-circle justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">3</div>
                <h4><?= e($content['workflow_step3_title'] ?? '') ?></h4>
                <p class="opacity-75"><?= e($content['workflow_step3_text'] ?? '') ?></p>
            </div>
        </div>
    </div>
</section>

<section id="land" class="section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="section-tag">Real Estate</div>
            <h2 class="section-title">Prime Land Opportunities</h2>
            <p class="text-muted mt-3 mx-auto" style="max-width: 600px;">Secure your future with verified, ready-to-build plots in high-growth locations.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($landListings as $listing):
                $img = !empty($listing['image_path']) ? media_url((string) $listing['image_path']) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80';
                $catLabel = $listing['category'] === 'commercial' ? 'Commercial' : 'Residential';
                ?>
                <div class="col-md-6" data-aos="fade-up">
                    <div class="card-premium">
                        <div class="badge bg-accent-soft text-accent mb-3 p-2 px-3"><?= e($catLabel) ?></div>
                        <h4 class="fw-bold"><?= e((string) $listing['title']) ?></h4>
                        <p class="text-muted mb-4"><?= e((string) ($listing['description'] ?? '')) ?></p>
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top mt-4">
                            <span class="h5 fw-bold mb-0<?= str_contains((string) $listing['price'], '₦') ? ' text-accent' : '' ?>"><?= e((string) ($listing['price'] ?? '')) ?></span>
                            <a href="<?= e(base_url('contact')) ?>" class="btn btn-outline-dark rounded-pill px-4">Inquire Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="contact" class="section-padding bg-soft">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="section-tag">Contact Us</div>
                <h2 class="section-title mb-4"><?= e($content['contact_section_title'] ?? '') ?></h2>
                <p class="text-muted mb-5"><?= e($content['contact_section_subtitle'] ?? '') ?></p>
                <div class="d-flex gap-4 mb-4">
                    <div class="card-icon mb-0 shadow-sm" style="width: 50px; height: 50px;"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Call Us</h6>
                        <p class="text-muted mb-0"><?= e($settings['company_phone'] ?? '') ?></p>
                    </div>
                </div>
                <div class="d-flex gap-4 mb-4">
                    <div class="card-icon mb-0 shadow-sm" style="width: 50px; height: 50px;"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Us</h6>
                        <p class="text-muted mb-0"><?= e($settings['company_email'] ?? '') ?></p>
                    </div>
                </div>
                <div class="d-flex gap-4 mb-4">
                    <div class="card-icon mb-0 shadow-sm" style="width: 50px; height: 50px;"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">WhatsApp</h6>
                        <p class="text-muted mb-0"><?= e($settings['company_whatsapp'] ?? '') ?></p>
                        <a href="https://wa.me/2348037568817?text=Hello%20Wincon%20Pilling" class="text-accent fw-bold small text-decoration-none" target="_blank" rel="noopener noreferrer">Open chat <i class="fas fa-external-link-alt ms-1 small"></i></a>
                    </div>
                </div>
                <div class="d-flex gap-4 mb-4">
                    <div class="card-icon mb-0 shadow-sm" style="width: 50px; height: 50px;"><i class="fab fa-instagram"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Instagram</h6>
                        <a href="https://www.instagram.com/winconconstruction231/" class="text-muted small text-decoration-none" target="_blank" rel="noopener noreferrer"><?= e($settings['company_instagram'] ?? '') ?></a>
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <div class="card-icon mb-0 shadow-sm" style="width: 50px; height: 50px;"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Head Office</h6>
                        <p class="text-muted mb-0"><?= e($settings['company_address'] ?? '') ?>, <?= e($settings['company_city'] ?? '') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="card-premium p-5 shadow-lg border-0">
                    <form id="contactForm" method="post" action="<?= e(base_url('contact/send')) ?>">
                        <?= csrf_field() ?>
                        <input type="text" name="_hp" class="honeypot-field" tabindex="-1" autocomplete="new-password" autocorrect="off" aria-hidden="true">
                        <input type="text" name="_hp_extra" class="honeypot-field" tabindex="-1" autocomplete="new-password" autocorrect="off" aria-hidden="true">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Full Name</label>
                                <input type="text" name="full_name" class="form-control" placeholder="John Doe" value="<?= e((string) old('full_name')) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" value="<?= e((string) old('email')) ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Service Interest</label>
                                <select name="service_interest" class="form-control">
                                    <?php
                                    $opts = ['Piling Services', 'Soil Analysis', 'Civil Engineering', 'Land Investment'];
                                    $cur = (string) old('service_interest', 'Piling Services');
                                    foreach ($opts as $o): ?>
                                        <option value="<?= e($o) ?>"<?= $cur === $o ? ' selected' : '' ?>><?= e($o) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?= e((string) old('subject')) ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Message</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your project..." required><?= e((string) old('message')) ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-premium btn-accent w-100 mt-2">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
