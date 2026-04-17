<?php
declare(strict_types=1);
/** @var string $content */
$pageTitle = $pageTitle ?? 'Wincon Pilling Construction Limited';
$metaDescription = $metaDescription ?? 'Wincon Pilling Construction Limited — premium engineering, deep foundations, and civil construction across Nigeria.';
$settings = $settings ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="description" content="<?= e($metaDescription) ?>">
    <title><?= e($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lite-youtube-embed@0.3.4/src/lite-yt-embed.css">
    <?= $extraHead ?? '' ?>
</head>
<body>
<?php include APP_PATH . '/Views/partials/header.php'; ?>
<main id="main-content">
<?php include APP_PATH . '/Views/partials/flash.php'; ?>
<?= $content ?>
</main>
<?php include APP_PATH . '/Views/partials/footer.php'; ?>
<a href="https://wa.me/2348037568817?text=<?= rawurlencode('Hello Wincon Pilling, I would like to discuss a project.') ?>" class="whatsapp-float shadow-lg" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp" aria-label="Open WhatsApp chat with Wincon Pilling Construction">
    <i class="fab fa-whatsapp"></i>
</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lite-youtube-embed@0.3.4/src/lite-yt-embed.js"></script>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
