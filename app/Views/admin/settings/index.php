<?php
declare(strict_types=1);
/** @var array<int, array<string, mixed>> $settingRows */
$byKey = [];
foreach ($settingRows as $r) {
    $k = (string) ($r['setting_key'] ?? '');
    if ($k !== '') {
        $byKey[$k] = $r;
    }
}
$groups = [
    'Company' => ['company_name', 'company_tagline', 'company_rc', 'company_founded', 'footer_copyright'],
    'Contact' => ['company_phone', 'company_email', 'company_whatsapp', 'company_instagram', 'company_address', 'company_city'],
    'SEO' => ['meta_description', 'og_image'],
    'Other' => ['google_maps_api_key'],
];
$labels = [
    'company_name' => 'Company name',
    'company_tagline' => 'Tagline',
    'company_rc' => 'RC number',
    'company_founded' => 'Incorporation / founded',
    'footer_copyright' => 'Footer copyright',
    'company_phone' => 'Phone',
    'company_email' => 'Email',
    'company_whatsapp' => 'WhatsApp',
    'company_instagram' => 'Instagram',
    'company_address' => 'Address',
    'company_city' => 'City / region',
    'meta_description' => 'Meta description',
    'og_image' => 'Open Graph image URL',
    'google_maps_api_key' => 'Google Maps API key',
];
?>
<div class="admin-page-head">
    <h2 class="admin-page-head__title">Site settings</h2>
    <p class="admin-muted">These values are used across the public site and footer.</p>
</div>

<form method="post" action="<?= e(base_url('admin/settings/update-all')) ?>" class="admin-form-card admin-settings-form">
    <?= csrf_field() ?>
    <?php foreach ($groups as $groupName => $keys): ?>
        <fieldset class="admin-fieldset">
            <legend><?= e($groupName) ?></legend>
            <?php foreach ($keys as $key): ?>
                <?php if (!isset($byKey[$key])) { continue; } ?>
                <?php $row = $byKey[$key]; ?>
                <div class="admin-form-group">
                    <label class="admin-label" for="set-<?= e($key) ?>"><?= e($labels[$key] ?? $key) ?></label>
                    <?php if ($key === 'meta_description'): ?>
                        <textarea class="admin-input admin-input--textarea" id="set-<?= e($key) ?>" name="settings[<?= e($key) ?>]" rows="3"><?= e((string) ($row['setting_value'] ?? '')) ?></textarea>
                    <?php else: ?>
                        <input class="admin-input" type="text" id="set-<?= e($key) ?>" name="settings[<?= e($key) ?>]" value="<?= e((string) ($row['setting_value'] ?? '')) ?>">
                    <?php endif; ?>
                    <?php if (!empty($row['description'])): ?>
                        <p class="admin-hint"><?= e((string) $row['description']) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </fieldset>
    <?php endforeach; ?>
    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--accent">Save all settings</button>
    </div>
</form>
