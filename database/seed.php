<?php

declare(strict_types=1);

/**
 * CLI seeder — run: php database/seed.php
 */
if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be run from the command line.\n");
    exit(1);
}

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/core/Database.php';

$pdo = Database::getInstance();

runSchema($pdo, ROOT_PATH . '/database/schema.sql');

clearTables($pdo);

$adminHash = password_hash('Admin@123456', PASSWORD_BCRYPT);
$stmt = $pdo->prepare(
    'INSERT INTO admin_users (username, email, password_hash, login_attempts, created_at) VALUES (?, ?, ?, 0, CURRENT_TIMESTAMP)'
);
$stmt->execute(['admin', 'admin@wincon.com', $adminHash]);

fwrite(STDOUT, "WARNING: Default admin credentials were seeded. Change the password immediately after first login.\n");
fwrite(STDOUT, "         username: admin | password: Admin@123456\n\n");

seedPageContents($pdo);
seedSiteSettings($pdo);
seedServices($pdo);
seedLandListings($pdo);
seedVideos($pdo);
seedGallery($pdo);

fwrite(STDOUT, "Seed completed successfully.\n");
exit(0);

function runSchema(\PDO $pdo, string $path): void
{
    if (!is_readable($path)) {
        throw new \RuntimeException('Schema file not found: ' . $path);
    }
    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new \RuntimeException('Cannot read schema file.');
    }
    $sql = preg_replace('/^\s*--.*$/m', '', $sql) ?? $sql;
    $parts = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($parts as $statement) {
        if ($statement !== '') {
            $pdo->exec($statement);
        }
    }
}

function clearTables(\PDO $pdo): void
{
    $tables = [
        'messages',
        'gallery_items',
        'videos',
        'land_listings',
        'services',
        'page_contents',
        'site_settings',
        'admin_users',
    ];
    foreach ($tables as $t) {
        $pdo->exec('DELETE FROM ' . $t);
    }
}

/**
 * @param array{page: string, section_key: string, label: string, value: string, content_type?: string} $row
 */
function insertPageContent(\PDO $pdo, array $row): void
{
    $type = $row['content_type'] ?? 'text';
    $stmt = $pdo->prepare(
        'INSERT INTO page_contents (page, section_key, label, content_type, value, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)'
    );
    $stmt->execute([$row['page'], $row['section_key'], $row['label'], $type, $row['value']]);
}

function seedPageContents(\PDO $pdo): void
{
    $rows = [
        // Home
        ['page' => 'home', 'section_key' => 'hero_title', 'label' => 'Home — Hero headline', 'value' => 'Building Solid Foundations Across Nigeria.'],
        ['page' => 'home', 'section_key' => 'hero_subtitle', 'label' => 'Home — Hero subtitle', 'value' => 'Wincon Pilling Construction Limited delivers premium engineering solutions and prime land opportunities for your next landmark project.'],
        ['page' => 'home', 'section_key' => 'hero_established', 'label' => 'Home — Hero tag', 'value' => 'Established 2008'],
        ['page' => 'home', 'section_key' => 'hero_stat_label', 'label' => 'Home — Hero social proof', 'value' => '500+ Foundations Laid'],
        ['page' => 'home', 'section_key' => 'stats_years', 'label' => 'Home — Stat 1 title', 'value' => '15+ Years'],
        ['page' => 'home', 'section_key' => 'stats_years_label', 'label' => 'Home — Stat 1 subtitle', 'value' => 'Engineering Excellence'],
        ['page' => 'home', 'section_key' => 'stats_licensed', 'label' => 'Home — Stat 2 title', 'value' => 'Fully Licensed'],
        ['page' => 'home', 'section_key' => 'stats_licensed_label', 'label' => 'Home — Stat 2 subtitle', 'value' => 'RC 766863 - Nigeria'],
        ['page' => 'home', 'section_key' => 'stats_tier', 'label' => 'Home — Stat 3 title', 'value' => 'Top Tier'],
        ['page' => 'home', 'section_key' => 'stats_tier_label', 'label' => 'Home — Stat 3 subtitle', 'value' => 'Piling & Civil Equipment'],
        ['page' => 'home', 'section_key' => 'why_us_title', 'label' => 'Home — Why us title', 'value' => 'Built on Trust, Safety, and Transparency'],
        ['page' => 'home', 'section_key' => 'why_us_subtitle', 'label' => 'Home — Why us subtitle', 'value' => 'We align every project with international and local standards so your investment is protected from the ground up.'],
        ['page' => 'home', 'section_key' => 'why_safety_title', 'label' => 'Home — Why card 1 title', 'value' => 'Safety record'],
        ['page' => 'home', 'section_key' => 'why_safety_text', 'label' => 'Home — Why card 1 text', 'value' => 'We maintain a strong safety record and ensure all projects meet international and local standards for occupational safety and health (including OSHA-aligned practices).'],
        ['page' => 'home', 'section_key' => 'why_team_title', 'label' => 'Home — Why card 2 title', 'value' => 'Experienced team'],
        ['page' => 'home', 'section_key' => 'why_team_text', 'label' => 'Home — Why card 2 text', 'value' => 'Our workforce consists of certified personnel with deep experience in foundation work, civil construction, and site delivery.'],
        ['page' => 'home', 'section_key' => 'why_client_title', 'label' => 'Home — Why card 3 title', 'value' => 'Client approach'],
        ['page' => 'home', 'section_key' => 'why_client_text', 'label' => 'Home — Why card 3 text', 'value' => 'We prioritize transparent communication at every stage so you always know how your project is progressing.'],
        ['page' => 'home', 'section_key' => 'why_finance_title', 'label' => 'Home — Why card 4 title', 'value' => 'Finance'],
        ['page' => 'home', 'section_key' => 'why_finance_text', 'label' => 'Home — Why card 4 text', 'value' => 'Dedicated finance personnel help ensure your funds are properly accounted for and aligned with project milestones.'],
        ['page' => 'home', 'section_key' => 'workflow_title', 'label' => 'Home — Workflow title', 'value' => 'How We Build Together'],
        ['page' => 'home', 'section_key' => 'workflow_step1_title', 'label' => 'Home — Workflow step 1 title', 'value' => 'Consultation'],
        ['page' => 'home', 'section_key' => 'workflow_step1_text', 'label' => 'Home — Workflow step 1 text', 'value' => 'We discuss your technical requirements and site conditions in detail.'],
        ['page' => 'home', 'section_key' => 'workflow_step2_title', 'label' => 'Home — Workflow step 2 title', 'value' => 'Site Analysis'],
        ['page' => 'home', 'section_key' => 'workflow_step2_text', 'label' => 'Home — Workflow step 2 text', 'value' => 'Our engineers conduct soil testing and geotechnical investigations.'],
        ['page' => 'home', 'section_key' => 'workflow_step3_title', 'label' => 'Home — Workflow step 3 title', 'value' => 'Execution'],
        ['page' => 'home', 'section_key' => 'workflow_step3_text', 'label' => 'Home — Workflow step 3 text', 'value' => 'Precision engineering and expert construction to the highest standards.'],
        ['page' => 'home', 'section_key' => 'contact_section_title', 'label' => 'Home — Contact section title', 'value' => "Let's Discuss Your Next Big Project"],
        ['page' => 'home', 'section_key' => 'contact_section_subtitle', 'label' => 'Home — Contact section subtitle', 'value' => 'Have questions about piling or land investment? Reach out to our specialist team for a free consultation.'],

        // About
        ['page' => 'about', 'section_key' => 'about_hero_title', 'label' => 'About — Hero title', 'value' => 'About Our Company'],
        ['page' => 'about', 'section_key' => 'about_hero_subtitle', 'label' => 'About — Hero breadcrumb', 'value' => 'About Us'],
        ['page' => 'about', 'section_key' => 'about_history_title', 'label' => 'About — History title', 'value' => 'Engineering Excellence in Every Foundation'],
        ['page' => 'about', 'section_key' => 'about_history_text', 'label' => 'About — History body', 'value' => "Wincon Pilling Construction Limited is a premier engineering firm specialized in deep foundation solutions and civil construction.\n\nIncorporated on August 20, 2008, we have spent over 15 years building a reputation for technical precision and unwavering reliability across Nigeria. From the challenging terrains of Lagos to the expanding infrastructure of Abuja, our foundations support the nation's landmarks.", 'content_type' => 'textarea'],
        ['page' => 'about', 'section_key' => 'mission_title', 'label' => 'About — Mission title', 'value' => 'Our Mission'],
        ['page' => 'about', 'section_key' => 'mission_text', 'label' => 'About — Mission text', 'value' => 'Excellence in engineering.'],
        ['page' => 'about', 'section_key' => 'vision_title', 'label' => 'About — Vision title', 'value' => 'Our Vision'],
        ['page' => 'about', 'section_key' => 'vision_text', 'label' => 'About — Vision text', 'value' => "Leading Africa's foundation work."],
        ['page' => 'about', 'section_key' => 'value1_title', 'label' => 'About — Value 1 title', 'value' => 'Integrity'],
        ['page' => 'about', 'section_key' => 'value1_text', 'label' => 'About — Value 1 text', 'value' => 'We build trust through transparent practices and uncompromising quality in every project.'],
        ['page' => 'about', 'section_key' => 'value2_title', 'label' => 'About — Value 2 title', 'value' => 'Innovation'],
        ['page' => 'about', 'section_key' => 'value2_text', 'label' => 'About — Value 2 text', 'value' => 'Utilizing the latest piling technology and geotechnical software to solve complex problems.'],
        ['page' => 'about', 'section_key' => 'value3_title', 'label' => 'About — Value 3 title', 'value' => 'Safety'],
        ['page' => 'about', 'section_key' => 'value3_text', 'label' => 'About — Value 3 text', 'value' => 'Prioritizing the well-being of our workers and the communities we serve with strict HSE standards.'],

        // Services
        ['page' => 'services', 'section_key' => 'services_hero_title', 'label' => 'Services — Hero title', 'value' => 'Our Core Expertise'],
        ['page' => 'services', 'section_key' => 'services_hero_subtitle', 'label' => 'Services — Hero subtitle', 'value' => 'Precision engineering for sustainable infrastructure.'],

        // Land
        ['page' => 'land', 'section_key' => 'land_hero_title', 'label' => 'Land — Hero title', 'value' => 'Prime Land Opportunities'],
        ['page' => 'land', 'section_key' => 'land_hero_subtitle', 'label' => 'Land — Hero subtitle', 'value' => "Verified land with clear titles in Nigeria's fastest-growing regions."],
        ['page' => 'land', 'section_key' => 'why_invest_point1', 'label' => 'Land — Why invest point 1', 'value' => 'Verified Titles: We only list properties with verified Certificates of Occupancy or valid government gazettes.'],
        ['page' => 'land', 'section_key' => 'why_invest_point2', 'label' => 'Land — Why invest point 2', 'value' => 'Ready for Foundation: As a piling company, we assess the soil quality of every land we sell to ensure it is build-ready.'],
        ['page' => 'land', 'section_key' => 'why_invest_point3', 'label' => 'Land — Why invest point 3', 'value' => 'Flexible Payments: Incremental payment plans available for selected estate plots.'],
    ];

    foreach ($rows as $r) {
        insertPageContent($pdo, $r);
    }
}

function seedSiteSettings(\PDO $pdo): void
{
    $settings = [
        ['company_name', 'Wincon Pilling Construction Limited', 'Legal name'],
        ['company_tagline', 'Building Solid Foundations Across Nigeria', 'Tagline'],
        ['company_rc', '766863', 'Corporate Affairs Commission RC'],
        ['company_founded', 'August 20, 2008', 'Incorporation date'],
        ['company_phone', '+234 803 756 8817', 'Phone'],
        ['company_email', 'winconpillingconstruction@gmail.com', 'Email'],
        ['company_whatsapp', '+234 803 756 8817', 'WhatsApp'],
        ['company_instagram', '@winconconstruction231', 'Instagram handle'],
        ['company_address', 'Abuja', 'Address line'],
        ['company_city', 'Nigeria', 'Country / region'],
        ['footer_copyright', '© 2024 Wincon Pilling Construction Limited. All Rights Reserved.', 'Footer copyright'],
        ['google_maps_api_key', '', 'Google Maps API key'],
        ['meta_description', 'Wincon Pilling Construction Limited — premium engineering and deep foundations across Nigeria.', 'Default meta description'],
        ['og_image', '', 'Open Graph image URL'],
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO site_settings (setting_key, setting_value, description, updated_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)'
    );
    foreach ($settings as $s) {
        $stmt->execute([$s[0], $s[1], $s[2]]);
    }
}

function seedServices(\PDO $pdo): void
{
    $services = [
        [
            'title' => 'Deep Piling Solutions',
            'slug' => 'piling',
            'short_description' => 'Specialized foundation work including Bored Piling, Driven Piling, and Micro Piling for stability in diverse soil profiles.',
            'full_description' => 'Specialized bored and driven piling for high-rise structures and bridges in challenging soil conditions.',
            'icon_class' => 'fas fa-hammer',
            'sub_items' => json_encode(['Bored Piling', 'Driven Piling', 'Micro Piling'], JSON_UNESCAPED_UNICODE),
            'detail_page_slug' => 'piling',
            'sort_order' => 1,
        ],
        [
            'title' => 'Geotechnical Engineering',
            'slug' => 'geotechnical',
            'short_description' => 'Comprehensive soil analysis, site investigation, and lab testing to ensure foundation safety and longevity.',
            'full_description' => 'In-depth geotechnical investigations to determine the perfect foundation type for your specific site.',
            'icon_class' => 'fas fa-microscope',
            'sub_items' => json_encode(['Site Surveys', 'Lab Testing'], JSON_UNESCAPED_UNICODE),
            'detail_page_slug' => null,
            'sort_order' => 2,
        ],
        [
            'title' => 'Civil Construction',
            'slug' => 'civil-construction',
            'short_description' => 'From structural design to massive earthworks, we handle large-scale infrastructure projects across Nigeria.',
            'full_description' => 'From structural design to massive earthworks and infrastructure development across Nigeria.',
            'icon_class' => 'fas fa-city',
            'sub_items' => json_encode(['Road Construction', 'Drainage Systems'], JSON_UNESCAPED_UNICODE),
            'detail_page_slug' => null,
            'sort_order' => 3,
        ],
        [
            'title' => 'Land Acquisition & Sales',
            'slug' => 'land-acquisition',
            'short_description' => 'We provide verified land opportunities with clear titles (C of O) in prime locations like Abuja and Port Harcourt.',
            'full_description' => 'We provide verified land opportunities with clear titles (C of O) in prime locations like Abuja and Port Harcourt.',
            'icon_class' => 'fas fa-map-marked-alt',
            'sub_items' => json_encode(['Verified titles', 'Prime locations'], JSON_UNESCAPED_UNICODE),
            'detail_page_slug' => null,
            'sort_order' => 4,
        ],
        [
            'title' => 'Structural Surveys',
            'slug' => 'structural-surveys',
            'short_description' => 'Safety audits and structural health monitoring for existing buildings and infrastructure.',
            'full_description' => 'Safety audits and structural health monitoring for existing buildings and infrastructure.',
            'icon_class' => 'fas fa-drafting-compass',
            'sub_items' => json_encode(['Safety audits', 'Health monitoring'], JSON_UNESCAPED_UNICODE),
            'detail_page_slug' => null,
            'sort_order' => 5,
        ],
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO services (title, slug, short_description, full_description, icon_class, sub_items, detail_page_slug, sort_order, is_active, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)'
    );
    foreach ($services as $s) {
        $stmt->execute([
            $s['title'],
            $s['slug'],
            $s['short_description'],
            $s['full_description'],
            $s['icon_class'],
            $s['sub_items'],
            $s['detail_page_slug'],
            $s['sort_order'],
        ]);
    }
}

function seedLandListings(\PDO $pdo): void
{
    $listings = [
        [
            'title' => 'Abuja Central Business District Plot',
            'category' => 'commercial',
            'description' => '1,500 SQM of prime commercial land. Perfect for high-rise office developments or retail shopping complexes. Verified C of O.',
            'location' => 'Abuja',
            'size_sqm' => 1500,
            'price' => 'Contact for Quote',
            'features' => json_encode(['C of O', 'Tarred Road'], JSON_UNESCAPED_UNICODE),
            'image_path' => '',
            'sort_order' => 1,
        ],
        [
            'title' => 'Riverside Estate Phase 2',
            'category' => 'residential',
            'description' => 'Secure gated community with 24/7 security, drainage systems, and green areas. Ready to build immediately.',
            'location' => 'Nigeria',
            'size_sqm' => 600,
            'price' => '₦5.5M / Plot',
            'features' => json_encode(['Gated', 'Electricity'], JSON_UNESCAPED_UNICODE),
            'image_path' => '',
            'sort_order' => 2,
        ],
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO land_listings (title, category, description, location, size_sqm, price, features, image_path, is_active, sort_order, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)'
    );
    foreach ($listings as $l) {
        $stmt->execute([
            $l['title'],
            $l['category'],
            $l['description'],
            $l['location'],
            $l['size_sqm'],
            $l['price'],
            $l['features'],
            $l['image_path'],
            $l['sort_order'],
        ]);
    }
}

function seedVideos(\PDO $pdo): void
{
    $thumb = static function (string $id): string {
        return 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
    };
    $videos = [
        [
            'title' => 'Foundation & piling',
            'description' => 'Sample reel — replace videoid with your clip.',
            'youtube_id' => 'aqz-KE-bpKQ',
            'category' => 'piling',
            'thumbnail_url' => $thumb('aqz-KE-bpKQ'),
            'sort_order' => 1,
            'is_featured' => 1,
        ],
        [
            'title' => 'Civil & structural',
            'description' => 'Sample reel — replace with your project.',
            'youtube_id' => 'M7FIvfx5J10',
            'category' => 'civil',
            'thumbnail_url' => $thumb('M7FIvfx5J10'),
            'sort_order' => 2,
            'is_featured' => 1,
        ],
        [
            'title' => 'Site operations',
            'description' => 'Sample reel — replace with your footage.',
            'youtube_id' => 'jNQXAC9IVRw',
            'category' => 'site',
            'thumbnail_url' => $thumb('jNQXAC9IVRw'),
            'sort_order' => 3,
            'is_featured' => 0,
        ],
        [
            'title' => 'Equipment & logistics',
            'description' => 'Placeholder — replace videoid with your upload.',
            'youtube_id' => 'dQw4w9WgXcQ',
            'category' => 'equipment',
            'thumbnail_url' => $thumb('dQw4w9WgXcQ'),
            'sort_order' => 4,
            'is_featured' => 0,
        ],
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO videos (title, description, youtube_id, category, thumbnail_url, sort_order, is_featured, is_active, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)'
    );
    foreach ($videos as $v) {
        $stmt->execute([
            $v['title'],
            $v['description'],
            $v['youtube_id'],
            $v['category'],
            $v['thumbnail_url'],
            $v['sort_order'],
            $v['is_featured'],
        ]);
    }
}

function seedGallery(\PDO $pdo): void
{
    $items = [
        ['title' => 'Guest house development', 'description' => 'Proposed build — elevation study (client sample)', 'category' => 'civil', 'image_path' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80', 'alt_text' => 'Project sample', 'sort_order' => 1, 'is_featured' => 1],
        ['title' => 'Commercial Complex', 'description' => 'Abuja Central Business District', 'category' => 'civil', 'image_path' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80', 'alt_text' => 'Structural', 'sort_order' => 2, 'is_featured' => 1],
        ['title' => 'Bridge Maintenance', 'description' => 'Infrastructure Development', 'category' => 'infrastructure', 'image_path' => 'https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=1200&q=80', 'alt_text' => 'Civil engineering', 'sort_order' => 3, 'is_featured' => 1],
        ['title' => 'Victoria Island High-Rise', 'description' => 'Deep bored piling for 25-floor foundation.', 'category' => 'piling', 'image_path' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=1200&q=80', 'alt_text' => 'Piling', 'sort_order' => 4, 'is_featured' => 0],
        ['title' => 'Lekki Drainage Network', 'description' => 'Large scale civil earthworks.', 'category' => 'infrastructure', 'image_path' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=1200&q=80', 'alt_text' => 'Infrastructure', 'sort_order' => 5, 'is_featured' => 0],
        ['title' => 'Prime land listing', 'description' => 'Verified plot with C of O', 'category' => 'real_estate', 'image_path' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200&q=80', 'alt_text' => 'Real estate', 'sort_order' => 6, 'is_featured' => 0],
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO gallery_items (title, description, category, image_path, alt_text, sort_order, is_featured, is_active, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)'
    );
    foreach ($items as $it) {
        $stmt->execute([
            $it['title'],
            $it['description'],
            $it['category'],
            $it['image_path'],
            $it['alt_text'],
            $it['sort_order'],
            $it['is_featured'],
        ]);
    }
}
