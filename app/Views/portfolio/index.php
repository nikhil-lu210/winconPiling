<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $galleryItems */
/** @var array<int, string> $categories */
/** @var string $activeCategory */
$tabs = [
    'all' => 'All Projects',
    'piling' => 'Piling',
    'civil' => 'Civil',
    'real-estate' => 'Real Estate',
    'infrastructure' => 'Infrastructure',
];
?>
<section class="inner-hero portfolio-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-3 fw-bold mb-3">Our Engineering Portfolio</h1>
        <p class="lead opacity-75">Demonstrating excellence across Nigeria's landscape.</p>
    </div>
</section>

<section class="section-padding bg-soft">
    <div class="container">
        <div class="text-center mb-5 portfolio-filters" data-aos="fade-up" role="tablist" aria-label="Filter projects">
            <?php foreach ($tabs as $key => $label):
                $url = $key === 'all' ? base_url('portfolio') : base_url('portfolio?category=' . $key);
                $isActive = $activeCategory === $key;
                ?>
                <a href="<?= e($url) ?>" class="filter-btn<?= $isActive ? ' active' : '' ?>" role="tab"<?= $isActive ? ' aria-selected="true"' : '' ?>><?= e($label) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="row g-4 portfolio-grid">
            <?php if ($galleryItems === []): ?>
                <p class="text-muted text-center">No projects in this category yet.</p>
            <?php else: ?>
                <?php foreach ($galleryItems as $item):
                    $img = media_url((string) $item['image_path']);
                    $badge = wincon_category_label((string) $item['category']);
                    ?>
                    <div class="col-md-6 col-lg-4 io-reveal" data-aos="zoom-in" data-category="<?= e((string) $item['category']) ?>">
                        <div class="project-card portfolio-page">
                            <a href="<?= e($img) ?>" class="glightbox project-card-link" data-gallery="wincon-portfolio" data-glightbox="title: <?= e((string) $item['title']) ?>; description: <?= e((string) ($item['description'] ?? '')) ?>">
                                <img src="<?= e($img) ?>" class="project-img" alt="<?= e((string) ($item['alt_text'] ?? $item['title'])) ?>">
                                <div class="project-overlay">
                                    <span class="badge bg-accent mb-2"><?= e($badge) ?></span>
                                    <h5 class="text-white fw-bold mb-1"><?= e((string) $item['title']) ?></h5>
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
