<?php
declare(strict_types=1);
/** @var array<string, string|null> $settings */
?>
<section class="inner-hero contact-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3">Get in Touch</h1>
        <p class="lead opacity-75">We're ready to discuss your next landmark project.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <h6 class="fw-bold">Call Us Direct</h6>
                            <p class="text-muted mb-0 small"><?= e($settings['company_phone'] ?? '') ?></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <h6 class="fw-bold">Email Inquiries</h6>
                            <p class="text-muted mb-0 small"><?= e($settings['company_email'] ?? '') ?></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                            <h6 class="fw-bold">WhatsApp</h6>
                            <p class="text-muted mb-0 small"><?= e($settings['company_whatsapp'] ?? '') ?></p>
                            <a href="https://wa.me/2348037568817?text=Hello%20Wincon%20Pilling" class="small fw-bold text-success text-decoration-none" target="_blank" rel="noopener noreferrer">Start a chat <i class="fas fa-external-link-alt ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fab fa-instagram"></i></div>
                            <h6 class="fw-bold">Instagram</h6>
                            <a href="https://www.instagram.com/winconconstruction231/" class="text-muted small text-decoration-none" target="_blank" rel="noopener noreferrer"><?= e($settings['company_instagram'] ?? '') ?></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <h6 class="fw-bold">Head Office</h6>
                            <p class="text-muted mb-0 small"><?= e($settings['company_address'] ?? '') ?>, <?= e($settings['company_city'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left">
                <div class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                    <h3 class="fw-bold mb-4">Send us a Message</h3>
                    <form id="contactForm" method="post" action="<?= e(base_url('contact/send')) ?>">
                        <?= csrf_field() ?>
                        <input type="text" name="_hp" class="honeypot-field" tabindex="-1" autocomplete="new-password" autocorrect="off" aria-hidden="true">
                        <input type="text" name="_hp_extra" class="honeypot-field" tabindex="-1" autocomplete="new-password" autocorrect="off" aria-hidden="true">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="full_name" class="form-control" required value="<?= e((string) old('full_name')) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" required value="<?= e((string) old('email')) ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Subject</label>
                                <select name="subject" class="form-select" required>
                                    <?php
                                    $subjects = ['General Inquiry', 'Quote Request', 'Project Consultation', 'Employment'];
                                    $curSub = (string) old('subject', 'General Inquiry');
                                    foreach ($subjects as $s): ?>
                                        <option value="<?= e($s) ?>"<?= $curSub === $s ? ' selected' : '' ?>><?= e($s) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Service interest (optional)</label>
                                <input type="text" name="service_interest" class="form-control" value="<?= e((string) old('service_interest')) ?>" placeholder="e.g. Piling">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Message</label>
                                <textarea name="message" class="form-control" rows="5" required><?= e((string) old('message')) ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill mt-3">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-soft">
    <div class="container">
        <div class="map-container" data-aos="zoom-in">
            <div class="map-placeholder">
                <div>
                    <i class="fas fa-map-marked-alt fa-3x mb-3 text-muted d-block"></i>
                    Interactive Map Embed Placeholder<br>
                    (Google Maps API Key required for live map)
                </div>
            </div>
        </div>
    </div>
</section>
