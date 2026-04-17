<?php
declare(strict_types=1);
/** @var array<string, array<int, array<string, mixed>>> $videosByCategory */
$order = ['piling', 'civil', 'site', 'equipment'];
?>
<section class="inner-hero alt">
    <div class="container" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3">Project videos</h1>
        <p class="lead opacity-75 mb-0" style="max-width: 640px; margin-left: auto; margin-right: auto;">See our foundations, civil works, and equipment in action. Thumbnails load first; the full player loads only when you press play (fast pages, lower data use).</p>
    </div>
</section>

<section class="section-padding bg-soft" aria-labelledby="video-gallery-heading">
    <div class="container">
        <div class="mb-5" data-aos="fade-up">
            <div class="section-tag">YouTube</div>
            <h2 id="video-gallery-heading" class="fw-bold">Work in motion</h2>
            <p class="text-muted mb-0">Each block uses your public YouTube link (11-character video ID).</p>
        </div>

        <?php foreach ($order as $cat):
            if (!isset($videosByCategory[$cat]) || $videosByCategory[$cat] === []) {
                continue;
            }
            $label = wincon_video_category_label($cat);
            ?>
            <h3 class="h5 fw-bold mb-3 mt-5"><?= e($label) ?></h3>
            <div class="row g-4 mb-4">
                <?php foreach ($videosByCategory[$cat] as $vid):
                    $thumb = (string) ($vid['thumbnail_url'] ?? '');
                    if ($thumb === '') {
                        $thumb = 'https://img.youtube.com/vi/' . (string) $vid['youtube_id'] . '/hqdefault.jpg';
                    }
                    $embedUrl = 'https://www.youtube-nocookie.com/embed/' . rawurlencode((string) $vid['youtube_id']) . '?rel=0&modestbranding=1';
                    ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <article class="video-card h-100 wincon-video-card" data-embed-url="<?= e($embedUrl) ?>">
                            <div class="video-thumb-wrap ratio ratio-16x9">
                                <img src="<?= e($thumb) ?>" alt="<?= e((string) $vid['title']) ?>" loading="lazy">
                                <div class="video-play-overlay" role="button" tabindex="0" aria-label="Play video">
                                    <span class="video-play-btn"><i class="fas fa-play"></i></span>
                                </div>
                            </div>
                            <div class="video-caption">
                                <h3 class="h6 fw-bold mb-1"><?= e((string) $vid['title']) ?></h3>
                                <p class="small text-muted mb-0"><?= e((string) ($vid['description'] ?? '')) ?></p>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
