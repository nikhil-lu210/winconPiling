# CURSOR AI — MASTER PROMPT
## Project: Wincon Pilling Construction Ltd — Static HTML → PHP MVC Web Application
---

> **How to use this prompt in Cursor:**
> Copy each `## PHASE` block into a separate Cursor Composer session (Agent mode).
> Complete each phase fully before moving to the next.
> Keep this document open as a reference tab at all times.

---

## ═══════════════════════════════════════════
## REFERENCE: COMPLETE WEBSITE AUDIT
## ═══════════════════════════════════════════

The source static website (https://nikhil-lu210.github.io/winconPiling/) is a
construction/engineering company site for **Wincon Pilling Construction Limited**
(RC: 766863, Nigeria). It has the following pages and content:

### Pages Inventory
| Page | Route (current) | Content Summary |
|---|---|---|
| Home | index.html | Hero, stats, Why Choose Us, Services overview, Portfolio preview (3 items), Videos preview (2 embeds), How We Build (3 steps), Land Opportunities (2 listings), Contact form, Footer |
| About | about.html | Company history (est. 2008), Mission/Vision, Core Values (Integrity, Innovation, Safety) |
| Services | services.html | 5 service cards: Deep Piling, Geotechnical, Civil Construction, Land Acquisition, Structural Surveys |
| Service Detail | service-piling.html | Deep Piling detail: Bored, Driven, Micro piling; Equipment, Load Testing; CTA form |
| Portfolio | portfolio.html | Filterable gallery (All / Piling / Civil / Real Estate / Infrastructure) — 8 image items |
| Videos | videos.html | 4 YouTube embed cards with categories (Foundation/Piling, Civil/Structural, Site Operations, Equipment) |
| Contact | contact.html | Contact info (phone, email, WhatsApp, Instagram, Address), inquiry form (Name, Email, Subject, Message) |
| Land Investment | land-investment.html | 2 land listings with specs + Why Invest section |

### Key Business Data
- Company: Wincon Pilling Construction Limited
- RC No: 766863 | Incorporated: August 20, 2008
- Phone/WhatsApp: +234 803 756 8817
- Email: winconpillingconstruction@gmail.com
- Instagram: @winconconstruction231
- Location: Abuja, Nigeria
- Tagline: "Building Solid Foundations Across Nigeria"

---

## ═══════════════════════════════════════════
## REFERENCE: REQUIRED FOLDER STRUCTURE
## ═══════════════════════════════════════════

This structure MUST be followed exactly. Do not deviate.

```
wincon/
│
├── public/                         ← Web root (point Apache/Nginx here)
│   ├── index.php                   ← Single entry point (Front Controller)
│   ├── .htaccess                   ← URL rewriting rules
│   └── assets/
│       ├── css/
│       │   ├── app.css             ← Public frontend styles
│       │   └── admin.css           ← Admin panel styles
│       ├── js/
│       │   ├── app.js              ← Public frontend scripts
│       │   └── admin.js            ← Admin scripts
│       └── uploads/
│           ├── gallery/            ← Portfolio image uploads
│           └── thumbnails/         ← Video thumbnail uploads
│
├── app/
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── AboutController.php
│   │   ├── ServicesController.php
│   │   ├── PortfolioController.php
│   │   ├── VideosController.php
│   │   ├── ContactController.php
│   │   ├── LandController.php
│   │   └── Admin/
│   │       ├── AdminBaseController.php
│   │       ├── AuthController.php
│   │       ├── DashboardController.php
│   │       ├── ContentController.php
│   │       ├── GalleryController.php
│   │       ├── VideoController.php
│   │       ├── MessageController.php
│   │       ├── ServiceController.php
│   │       └── LandController.php
│   │
│   ├── Models/
│   │   ├── BaseModel.php
│   │   ├── PageContentModel.php
│   │   ├── GalleryModel.php
│   │   ├── VideoModel.php
│   │   ├── MessageModel.php
│   │   ├── ServiceModel.php
│   │   ├── LandListingModel.php
│   │   └── AdminUserModel.php
│   │
│   └── Views/
│       ├── layouts/
│       │   ├── main.php            ← Public layout wrapper
│       │   └── admin.php           ← Admin layout wrapper
│       ├── partials/
│       │   ├── header.php
│       │   ├── footer.php
│       │   ├── nav.php
│       │   └── admin/
│       │       ├── sidebar.php
│       │       └── topbar.php
│       ├── home/
│       │   └── index.php
│       ├── about/
│       │   └── index.php
│       ├── services/
│       │   ├── index.php
│       │   └── piling.php
│       ├── portfolio/
│       │   └── index.php
│       ├── videos/
│       │   └── index.php
│       ├── contact/
│       │   └── index.php
│       ├── land/
│       │   └── index.php
│       └── admin/
│           ├── auth/
│           │   └── login.php
│           ├── dashboard/
│           │   └── index.php
│           ├── content/
│           │   ├── index.php       ← List all editable page sections
│           │   └── edit.php        ← Edit a single content block
│           ├── gallery/
│           │   ├── index.php
│           │   └── form.php
│           ├── videos/
│           │   ├── index.php
│           │   └── form.php
│           ├── messages/
│           │   ├── index.php
│           │   └── view.php
│           ├── services/
│           │   ├── index.php
│           │   └── form.php
│           └── land/
│               ├── index.php
│               └── form.php
│
├── core/                           ← Framework kernel (no framework dependency)
│   ├── App.php                     ← Application bootstrap
│   ├── Router.php                  ← URL dispatcher
│   ├── Request.php                 ← HTTP request wrapper
│   ├── Response.php                ← HTTP response wrapper
│   ├── Session.php                 ← Session management
│   ├── Database.php                ← PDO/SQLite singleton
│   ├── Auth.php                    ← Authentication guard
│   ├── View.php                    ← View renderer
│   ├── CSRF.php                    ← CSRF token manager
│   ├── Validator.php               ← Input validation
│   ├── FileUpload.php              ← Secure file upload handler
│   ├── RateLimiter.php             ← Login brute-force protection
│   └── helpers.php                 ← Global helper functions
│
├── config/
│   ├── app.php                     ← App name, URL, timezone, debug flag
│   ├── database.php                ← DB path, options
│   └── routes.php                  ← All route definitions
│
├── database/
│   ├── wincon.db                   ← SQLite database file
│   ├── schema.sql                  ← Full DB schema
│   └── seed.php                    ← Default data seeder (admin user + content)
│
├── storage/
│   ├── logs/
│   │   └── app.log
│   └── cache/                      ← Reserved for future caching
│
├── .env                            ← Environment variables (NEVER commit)
├── .env.example                    ← Safe template
├── .gitignore
└── README.md
```

---

## ═══════════════════════════════════════════
## REFERENCE: DATABASE SCHEMA
## ═══════════════════════════════════════════

```sql
-- Admin users (single admin for now, expandable)
CREATE TABLE admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,       -- password_hash() bcrypt
    last_login DATETIME,
    login_attempts INTEGER DEFAULT 0,
    locked_until DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Page content blocks (CMS-like, keyed by page + section)
CREATE TABLE page_contents (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page TEXT NOT NULL,                -- e.g. 'home', 'about', 'services'
    section_key TEXT NOT NULL,         -- e.g. 'hero_title', 'hero_subtitle'
    label TEXT NOT NULL,               -- Human-readable label for admin UI
    content_type TEXT DEFAULT 'text',  -- 'text' | 'textarea' | 'html'
    value TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(page, section_key)
);

-- Gallery / Portfolio items
CREATE TABLE gallery_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    category TEXT NOT NULL,            -- 'piling' | 'civil' | 'infrastructure' | 'real_estate'
    image_path TEXT NOT NULL,          -- relative path under public/assets/uploads/gallery/
    alt_text TEXT,
    sort_order INTEGER DEFAULT 0,
    is_featured INTEGER DEFAULT 0,     -- 1 = show on homepage
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- YouTube video entries
CREATE TABLE videos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    youtube_id TEXT NOT NULL,          -- 11-char YouTube video ID
    category TEXT NOT NULL,            -- 'piling' | 'civil' | 'site' | 'equipment'
    thumbnail_url TEXT,                -- auto-built from YouTube or custom
    sort_order INTEGER DEFAULT 0,
    is_featured INTEGER DEFAULT 0,     -- show on homepage
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Contact / inquiry messages
CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL,
    subject TEXT,
    service_interest TEXT,
    message TEXT NOT NULL,
    ip_address TEXT,
    is_read INTEGER DEFAULT 0,
    is_starred INTEGER DEFAULT 0,
    read_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Services (manageable from admin)
CREATE TABLE services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    short_description TEXT,
    full_description TEXT,
    icon_class TEXT,                   -- CSS/Font-Awesome icon class
    sub_items TEXT,                    -- JSON array of bullet points
    detail_page_slug TEXT,             -- e.g. 'piling' for /services/piling
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Land / Real Estate listings
CREATE TABLE land_listings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    category TEXT NOT NULL,            -- 'commercial' | 'residential'
    description TEXT,
    location TEXT,
    size_sqm INTEGER,
    price TEXT,                        -- stored as string e.g. '₦5.5M' or 'Contact for Quote'
    features TEXT,                     -- JSON array e.g. ["C of O","Tarred Road"]
    image_path TEXT,
    is_active INTEGER DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Site settings (global key-value)
CREATE TABLE site_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    setting_key TEXT NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## ═══════════════════════════════════════════
## PHASE 1 — PROJECT SCAFFOLD & CORE FRAMEWORK
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 1:**

```
You are building a professional PHP MVC web application for Wincon Pilling
Construction Limited — a Nigerian engineering and construction company.

TECH STACK:
- Pure PHP 8.1+ (no Laravel, no Symfony, no Composer frameworks)
- SQLite via PDO
- Vanilla JS (no jQuery required, but allowed for admin panel if needed)
- No CSS framework required — preserve the existing site's CSS/HTML design

TASK: Build the entire project skeleton and core framework in one go.

═══ STEP 1: Create the folder structure exactly as specified ═══

Create every folder listed below (use touch .gitkeep for empty dirs):

wincon/public/index.php
wincon/public/.htaccess
wincon/public/assets/css/app.css
wincon/public/assets/css/admin.css
wincon/public/assets/js/app.js
wincon/public/assets/js/admin.js
wincon/public/assets/uploads/gallery/.gitkeep
wincon/public/assets/uploads/thumbnails/.gitkeep
wincon/app/Controllers/.gitkeep
wincon/app/Controllers/Admin/.gitkeep
wincon/app/Models/.gitkeep
wincon/app/Views/layouts/.gitkeep
wincon/app/Views/partials/admin/.gitkeep
wincon/app/Views/home/.gitkeep
wincon/app/Views/about/.gitkeep
wincon/app/Views/services/.gitkeep
wincon/app/Views/portfolio/.gitkeep
wincon/app/Views/videos/.gitkeep
wincon/app/Views/contact/.gitkeep
wincon/app/Views/land/.gitkeep
wincon/app/Views/admin/auth/.gitkeep
wincon/app/Views/admin/dashboard/.gitkeep
wincon/app/Views/admin/content/.gitkeep
wincon/app/Views/admin/gallery/.gitkeep
wincon/app/Views/admin/videos/.gitkeep
wincon/app/Views/admin/messages/.gitkeep
wincon/app/Views/admin/services/.gitkeep
wincon/app/Views/admin/land/.gitkeep
wincon/core/.gitkeep
wincon/config/.gitkeep
wincon/database/.gitkeep
wincon/storage/logs/.gitkeep
wincon/storage/cache/.gitkeep

═══ STEP 2: Create .env and .env.example ═══

.env content:
APP_NAME="Wincon Pilling Construction"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/wincon/public
APP_TIMEZONE=Africa/Lagos

DB_PATH=../database/wincon.db

ADMIN_SETUP_TOKEN=CHANGE_THIS_RANDOM_STRING_BEFORE_DEPLOY

SESSION_NAME=wincon_session
SESSION_LIFETIME=7200

UPLOAD_MAX_SIZE=5242880
ALLOWED_IMAGE_TYPES=image/jpeg,image/png,image/webp

LOG_CHANNEL=file

.env.example: copy of .env but with all values as placeholder strings.

═══ STEP 3: Create config/ files ═══

config/app.php:
- Load .env via a custom loadEnv() helper
- Define constants: APP_NAME, APP_ENV, APP_URL, APP_DEBUG, APP_TIMEZONE
- Set default timezone
- Set error reporting based on APP_DEBUG

config/database.php:
- Returns array: ['driver' => 'sqlite', 'path' => DB_PATH]

config/routes.php:
- Returns an array of route definitions.
- Format: [METHOD, '/uri', 'ControllerClass', 'methodName']
- Define ALL routes (public + admin) listed below:

PUBLIC ROUTES:
GET  /                          HomeController@index
GET  /about                     AboutController@index
GET  /services                  ServicesController@index
GET  /services/piling           ServicesController@piling
GET  /portfolio                 PortfolioController@index
GET  /videos                    VideosController@index
GET  /contact                   ContactController@index
POST /contact/send              ContactController@send
GET  /land-investment           LandController@index

ADMIN ROUTES:
GET  /admin                     Admin\AuthController@loginPage
POST /admin/login               Admin\AuthController@login
POST /admin/logout              Admin\AuthController@logout

GET  /admin/dashboard           Admin\DashboardController@index

GET  /admin/content             Admin\ContentController@index
GET  /admin/content/edit/{id}   Admin\ContentController@edit
POST /admin/content/update/{id} Admin\ContentController@update

GET  /admin/gallery             Admin\GalleryController@index
GET  /admin/gallery/create      Admin\GalleryController@create
POST /admin/gallery/store       Admin\GalleryController@store
GET  /admin/gallery/edit/{id}   Admin\GalleryController@edit
POST /admin/gallery/update/{id} Admin\GalleryController@update
POST /admin/gallery/delete/{id} Admin\GalleryController@delete
POST /admin/gallery/reorder     Admin\GalleryController@reorder

GET  /admin/videos              Admin\VideoController@index
GET  /admin/videos/create       Admin\VideoController@create
POST /admin/videos/store        Admin\VideoController@store
GET  /admin/videos/edit/{id}    Admin\VideoController@edit
POST /admin/videos/update/{id}  Admin\VideoController@update
POST /admin/videos/delete/{id}  Admin\VideoController@delete

GET  /admin/messages            Admin\MessageController@index
GET  /admin/messages/view/{id}  Admin\MessageController@view
POST /admin/messages/star/{id}  Admin\MessageController@star
POST /admin/messages/delete/{id} Admin\MessageController@delete
POST /admin/messages/mark-read  Admin\MessageController@markRead

GET  /admin/services            Admin\ServiceController@index
GET  /admin/services/create     Admin\ServiceController@create
POST /admin/services/store      Admin\ServiceController@store
GET  /admin/services/edit/{id}  Admin\ServiceController@edit
POST /admin/services/update/{id} Admin\ServiceController@update
POST /admin/services/delete/{id} Admin\ServiceController@delete

GET  /admin/land                Admin\LandController@index
GET  /admin/land/create         Admin\LandController@create
POST /admin/land/store          Admin\LandController@store
GET  /admin/land/edit/{id}      Admin\LandController@edit
POST /admin/land/update/{id}    Admin\LandController@update
POST /admin/land/delete/{id}    Admin\LandController@delete

═══ STEP 4: Create public/index.php (Front Controller) ═══

<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CORE_PATH', ROOT_PATH . '/core');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('STORAGE_PATH', ROOT_PATH . '/storage');

require_once CONFIG_PATH . '/app.php';
require_once CORE_PATH . '/helpers.php';
require_once CORE_PATH . '/Database.php';
require_once CORE_PATH . '/Session.php';
require_once CORE_PATH . '/CSRF.php';
require_once CORE_PATH . '/Request.php';
require_once CORE_PATH . '/Response.php';
require_once CORE_PATH . '/Auth.php';
require_once CORE_PATH . '/View.php';
require_once CORE_PATH . '/Validator.php';
require_once CORE_PATH . '/FileUpload.php';
require_once CORE_PATH . '/RateLimiter.php';
require_once CORE_PATH . '/Router.php';
require_once CORE_PATH . '/App.php';

Session::start();
$app = new App();
$app->run();

═══ STEP 5: Create public/.htaccess ═══

Options -Indexes
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"

═══ STEP 6: Create core/ files ═══

--- core/helpers.php ---
Define these global helper functions:
- env(string $key, mixed $default = null): mixed
  Reads from a loaded $_ENV array. Call loadEnv() in config/app.php first.
- loadEnv(string $path): void
  Parses .env file into $_ENV and putenv().
- base_url(string $path = ''): string
  Returns APP_URL . '/' . ltrim($path, '/')
- asset(string $path): string
  Returns base_url('assets/' . $path)
- upload_url(string $path): string
  Returns base_url('assets/uploads/' . $path)
- old(string $key, mixed $default = ''): mixed
  Returns $_SESSION['_old_input'][$key] ?? $default
- flash(string $key, mixed $value = null): mixed
  Sets or gets a flash message from session.
- e(string $value): string
  Alias for htmlspecialchars($value, ENT_QUOTES, 'UTF-8')
- redirect(string $url): never
  header('Location: ' . $url); exit;
- csrf_token(): string
  Returns CSRF::getToken()
- csrf_field(): string
  Returns '<input type="hidden" name="_csrf_token" value="' . csrf_token() . '">'
- is_admin_logged_in(): bool
  Returns Auth::check()
- log_error(string $message, array $context = []): void
  Appends formatted line to storage/logs/app.log

--- core/Database.php ---
Implement as a singleton using PDO + SQLite.
- Private static ?PDO $instance = null
- public static function getInstance(): PDO
  - On first call: creates PDO with 'sqlite:' . ROOT_PATH . DB_PATH
  - Sets PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  - Sets PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  - Executes PRAGMA foreign_keys = ON; and PRAGMA journal_mode=WAL;
  - Returns the PDO instance
- No other public methods. All DB access goes through PDO directly in models.

--- core/Session.php ---
- public static function start(): void
  - Configure session: name from config, lifetime, cookie HttpOnly+SameSite=Strict
  - session_start()
- public static function set(string $key, mixed $value): void
- public static function get(string $key, mixed $default = null): mixed
- public static function has(string $key): bool
- public static function delete(string $key): void
- public static function flash(string $key, mixed $value): void
  Set a flash message: $_SESSION['_flash'][$key] = $value
- public static function getFlash(string $key, mixed $default = null): mixed
  Returns and removes the flash message.
- public static function regenerate(): void
  session_regenerate_id(true)
- public static function destroy(): void
  Clears session data and destroys session.

--- core/CSRF.php ---
- public static function getToken(): string
  If token not in session, generate with bin2hex(random_bytes(32)), store and return.
- public static function validate(string $token): bool
  Constant-time comparison: hash_equals(Session::get('_csrf_token'), $token)
- public static function verifyRequest(): void
  On non-GET requests: check $_POST['_csrf_token'], if invalid → 403 abort.

--- core/Request.php ---
- public function getMethod(): string — strtoupper($_SERVER['REQUEST_METHOD'])
- public function getUri(): string — Parses REQUEST_URI, strips query string, strips base path
- public function get(string $key, mixed $default = null): mixed — $_GET[$key] ?? $default
- public function post(string $key, mixed $default = null): mixed — sanitized $_POST[$key]
- public function files(string $key): mixed — $_FILES[$key] ?? null
- public function ip(): string — REMOTE_ADDR with proxy awareness
- public function isPost(): bool
- public function all(): array — merged GET + POST
- public function sanitize(mixed $value): mixed — recursive trim + strip_tags on strings

--- core/Response.php ---
- public function json(mixed $data, int $status = 200): never
- public function redirect(string $url, int $status = 302): never
- public function abort(int $code, string $message = ''): never
  Sends HTTP status header and renders a simple error page.

--- core/Auth.php ---
- private static string $sessionKey = '_admin_user'
- public static function check(): bool — Session::has(self::$sessionKey)
- public static function login(array $user): void
  Session::regenerate(); Session::set(self::$sessionKey, $user)
- public static function logout(): void
  Session::delete(self::$sessionKey); Session::regenerate()
- public static function user(): ?array — Session::get(self::$sessionKey)
- public static function guard(): void
  If !self::check() → redirect to /admin → exit

--- core/View.php ---
- private string $viewsPath
- public function __construct() — sets viewsPath to APP_PATH . '/Views/'
- public function render(string $view, array $data = [], string $layout = 'main'): void
  1. Extract $data into local variables
  2. ob_start(); include viewsPath . str_replace('.', '/', $view) . '.php'; $content = ob_get_clean()
  3. include viewsPath . 'layouts/' . $layout . '.php'
  The layout file outputs $content where appropriate.
- public function partial(string $partial, array $data = []): void
  Includes viewsPath . 'partials/' . $partial . '.php' with extracted $data.

--- core/Validator.php ---
- public array $errors = []
- public function validate(array $data, array $rules): bool
  Rules supported: required, email, min:n, max:n, numeric, in:a,b,c, url, image_ext
- public function getErrors(): array
- public function getError(string $field): ?string
- public function passes(): bool
- public function fails(): bool

--- core/FileUpload.php ---
- public function handle(array $file, string $destination, array $options = []): string|false
  $options: ['maxSize' => bytes, 'allowedTypes' => [], 'prefix' => '']
  Validates: size, MIME type (finfo, not just extension), no executable content
  Generates: uniqid() + random_bytes hash filename + original extension
  Moves to $destination directory
  Returns relative path from public/assets/uploads/ on success, false on fail.
- private function validateMime(string $tmpPath, array $allowedMimes): bool
- private function sanitizeFilename(string $name): string

--- core/RateLimiter.php ---
Uses session-based rate limiting for login attempts.
- public function tooManyAttempts(string $key, int $maxAttempts = 5, int $decaySeconds = 900): bool
- public function hit(string $key): void — increments attempt counter
- public function clear(string $key): void — resets counter
- public function availableIn(string $key): int — seconds until unlock

--- core/Router.php ---
- private array $routes = []
- public function addRoute(string $method, string $uri, string $controller, string $action): void
- public function dispatch(Request $request): void
  1. Match URI against routes, extract {param} segments
  2. Instantiate controller from app/Controllers/ (handle Admin\ namespace with subdirectory)
  3. Call $controller->$action(...$params)
  4. If no match → 404 abort
- Route matching must support: /admin/gallery/edit/{id}

--- core/App.php ---
- public function run(): void
  1. $request = new Request()
  2. $routes = require CONFIG_PATH . '/routes.php'
  3. Build Router, add all routes
  4. Apply CSRF check on POST requests: CSRF::verifyRequest()
  5. Dispatch
```

---

## ═══════════════════════════════════════════
## PHASE 2 — DATABASE, MODELS & SEEDER
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 2:**

```
Continue building the Wincon Pilling PHP MVC application.
The core framework from Phase 1 is in place.

TASK: Create the database schema, all Models, and the seeder.

═══ STEP 1: Create database/schema.sql ═══

Create the EXACT SQL from the schema defined in the project reference.
Tables: admin_users, page_contents, gallery_items, videos, messages,
services, land_listings, site_settings.

═══ STEP 2: Create database/seed.php ═══

This is a CLI script (run once: php database/seed.php).
It should:
1. Read the schema.sql and execute it against wincon.db using PDO
2. Insert the default admin user:
   username: admin
   email: admin@wincon.com
   password: Admin@123456  (stored as password_hash('Admin@123456', PASSWORD_BCRYPT))
   NOTE: Print a warning to change this immediately after setup.
3. Seed page_contents with ALL editable text blocks from the site:
   HOME PAGE sections: hero_title, hero_subtitle, hero_established,
     hero_stat_label, stats_years, stats_years_label, stats_licensed,
     stats_licensed_label, stats_tier, stats_tier_label,
     why_us_title, why_us_subtitle,
     why_safety_title, why_safety_text,
     why_team_title, why_team_text,
     why_client_title, why_client_text,
     why_finance_title, why_finance_text,
     workflow_title, workflow_step1_title, workflow_step1_text,
     workflow_step2_title, workflow_step2_text,
     workflow_step3_title, workflow_step3_text,
     contact_section_title, contact_section_subtitle
   ABOUT PAGE: about_hero_title, about_hero_subtitle, about_history_title,
     about_history_text, mission_title, mission_text,
     vision_title, vision_text,
     value1_title, value1_text, value2_title, value2_text,
     value3_title, value3_text
   SERVICES PAGE: services_hero_title, services_hero_subtitle
   LAND PAGE: land_hero_title, land_hero_subtitle,
     why_invest_point1, why_invest_point2, why_invest_point3
4. Seed site_settings:
   company_name, company_tagline, company_rc, company_founded,
   company_phone, company_email, company_whatsapp,
   company_instagram, company_address, company_city,
   footer_copyright, google_maps_api_key (empty)
5. Seed 3 default services from the site content.
6. Seed 2 default land listings from the site content.
7. Seed 4 default video entries with placeholder YouTube IDs.

═══ STEP 3: Create app/Models/BaseModel.php ═══

abstract class BaseModel {
    protected PDO $db;
    protected string $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    protected function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    protected function findAll(string $orderBy = 'id ASC'): array {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}")->fetchAll();
    }

    protected function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    protected function updateTimestamp(int $id): void {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$id]);
    }
}

═══ STEP 4: Create all Model files ═══

--- app/Models/PageContentModel.php ---
extends BaseModel, $table = 'page_contents'
Methods:
- getByPage(string $page): array — returns keyed array [section_key => value]
- getById(int $id): ?array
- getAll(): array
- update(int $id, string $value): bool
- updateByKey(string $page, string $key, string $value): bool

--- app/Models/GalleryModel.php ---
extends BaseModel, $table = 'gallery_items'
Methods:
- getAll(bool $activeOnly = true): array
- getByCategory(string $category): array
- getFeatured(int $limit = 3): array
- getById(int $id): ?array
- create(array $data): int — returns new ID
- update(int $id, array $data): bool
- delete(int $id): bool — also deletes the image file
- updateSortOrder(array $order): void — takes [['id'=>1,'sort'=>0],...]
- getCategories(): array — distinct categories

--- app/Models/VideoModel.php ---
extends BaseModel, $table = 'videos'
Methods:
- getAll(bool $activeOnly = true): array
- getFeatured(int $limit = 2): array
- getByCategory(string $category): array
- getById(int $id): ?array
- create(array $data): int
- update(int $id, array $data): bool
- delete(int $id): bool
- buildThumbnailUrl(string $youtubeId): string
  Returns: 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg'

--- app/Models/MessageModel.php ---
extends BaseModel, $table = 'messages'
Methods:
- create(array $data): int
- getAll(): array — newest first
- getUnread(): array
- getById(int $id): ?array
- markRead(int $id): bool
- markReadMultiple(array $ids): bool
- toggleStar(int $id): bool
- delete(int $id): bool
- countUnread(): int
- countAll(): int

--- app/Models/ServiceModel.php ---
extends BaseModel, $table = 'services'
Methods:
- getAll(bool $activeOnly = true): array
- getById(int $id): ?array
- getBySlug(string $slug): ?array
- create(array $data): int
- update(int $id, array $data): bool
- delete(int $id): bool
- decodeSubItems(array $service): array — JSON-decodes sub_items field

--- app/Models/LandListingModel.php ---
extends BaseModel, $table = 'land_listings'
Methods:
- getAll(bool $activeOnly = true): array
- getById(int $id): ?array
- getByCategory(string $category): array
- create(array $data): int
- update(int $id, array $data): bool
- delete(int $id): bool
- decodeFeatures(array $listing): array

--- app/Models/AdminUserModel.php ---
extends BaseModel, $table = 'admin_users'
Methods:
- findByUsername(string $username): ?array
- findByEmail(string $email): ?array
- updateLastLogin(int $id): void
- incrementLoginAttempts(int $id): void
- resetLoginAttempts(int $id): void
- lockAccount(int $id, int $minutes = 15): void
- isLocked(array $user): bool
- updatePassword(int $id, string $newHash): bool

--- app/Models/SiteSettingModel.php ---
extends BaseModel, $table = 'site_settings'
Methods:
- getAll(): array — returns keyed array [setting_key => setting_value]
- get(string $key, mixed $default = null): mixed
- set(string $key, mixed $value): bool
- updateMultiple(array $settings): void — loop update
```

---

## ═══════════════════════════════════════════
## PHASE 3 — PUBLIC CONTROLLERS & VIEWS
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 3:**

```
Continue building the Wincon Pilling PHP MVC application.
Core + Models from Phase 1 & 2 are complete.

TASK: Build all public-facing Controllers and their Views.
Replicate the EXACT structure, layout, and content of the original static
HTML website. The HTML/CSS should be identical or near-identical to the
original. Use inline or embedded CSS to match the original site styling.

═══ STEP 1: app/Controllers/BaseController.php ═══

abstract class BaseController {
    protected View $view;
    protected Request $request;
    protected Response $response;

    public function __construct() {
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
    }

    protected function render(string $viewName, array $data = [], string $layout = 'main'): void {
        $this->view->render($viewName, $data, $layout);
    }

    protected function redirect(string $url): never {
        $this->response->redirect($url);
    }

    protected function jsonResponse(mixed $data, int $code = 200): never {
        $this->response->json($data, $code);
    }

    protected function abort(int $code): never {
        $this->response->abort($code);
    }
}

═══ STEP 2: Create app/Views/layouts/main.php ═══

This is the main public layout. It should:
- Output proper <!DOCTYPE html> with lang="en"
- Include <head> with: charset, viewport, title (from $pageTitle variable or default),
  meta description (from $metaDescription or default),
  link to /assets/css/app.css
- Include the header partial (which has the top banner + navbar)
- Echo $content (the rendered view output)
- Include the footer partial
- Include /assets/js/app.js at bottom

═══ STEP 3: Create partials: header.php, nav.php, footer.php ═══

header.php: Top registration bar "REGISTERED WITH CORPORATE AFFAIRS COMMISSION
NIGERIA • RC: 766863" + the main navigation. Nav links: About, Services,
Portfolio, Videos, Contact, "Get a Quote" (button style). Logo: "WINCON PILLING".
Mark active nav item based on current URI.

footer.php: 3-column footer with:
- Col 1: Company name + tagline
- Col 2: Services quick links
- Col 3: Company links + Accreditation block (RC, incorporated date)
- Copyright line: "© 2024 Wincon Pilling Construction Limited. All Rights Reserved."
All text from $settings (site_settings) where possible.

═══ STEP 4: Create all public Controllers ═══

Each controller loads data from Models and passes to views.

--- HomeController.php ---
index():
- Load page_contents for page='home' → $content
- Load GalleryModel::getFeatured(3) → $featuredGallery
- Load VideoModel::getFeatured(2) → $featuredVideos
- Load ServiceModel::getAll() → $services
- Load LandListingModel::getAll() → $landListings
- Load SiteSettingModel::getAll() → $settings
- render('home/index', compact(...), 'main')

--- AboutController.php ---
index(): Load page_contents page='about', $settings. render('about/index')

--- ServicesController.php ---
index(): Load ServiceModel::getAll(), page_contents page='services', $settings
piling(): Load ServiceModel::getBySlug('piling'), page_contents
Both: render respective view

--- PortfolioController.php ---
index():
- $category = request->get('category', 'all')
- If 'all': load GalleryModel::getAll()
- Else: load GalleryModel::getByCategory($category)
- $categories = GalleryModel::getCategories()
- render('portfolio/index', ...)

--- VideosController.php ---
index(): Load VideoModel::getAll() grouped by category. render('videos/index')

--- ContactController.php ---
index(): render contact form with $settings
send() [POST]:
- CSRF already verified by App
- Validate: full_name (required, max 100), email (required, email),
  subject (required), message (required, min 10, max 2000)
- Honeypot field check (add hidden _hp field, if filled → silently discard)
- Rate limit: max 3 submissions per IP per hour using RateLimiter
- If valid: MessageModel::create([...])
- flash('success', 'Thank you! Your message has been sent.')
- redirect to /contact
- If invalid: store errors + old input in session, redirect back

--- LandController.php ---
index(): Load LandListingModel::getAll(), page_contents page='land', $settings

═══ STEP 5: Create all public View files ═══

For EACH view file, replicate the original HTML structure faithfully.
Use <?= e($var) ?> for all output. Use <?= $content['key'] ?? '' ?> for
dynamic content blocks. Include CSRF field in all forms.

--- app/Views/home/index.php ---
Sections (match original exactly):
1. Hero: headline from $content['hero_title'], subtitle, CTA buttons, client avatars
2. Stats bar: 3 stats (15+ Years, Fully Licensed, Top Tier)
3. "Why Choose Us": 4 feature cards
4. Services preview: loop $services, show first 3 with icon, title, sub-items
5. Portfolio preview: loop $featuredGallery, clickable lightbox-ready images
6. Videos preview: loop $featuredVideos, YouTube lite-embed pattern
   (img thumbnail + play button overlay; load iframe only on click)
7. How We Build: 3 numbered steps
8. Land Opportunities: loop $landListings (max 2)
9. Contact section: info blocks + contact form (POST /contact/send)
   Include CSRF field + honeypot hidden field named "website" (must be empty)

--- app/Views/about/index.php ---
- Page hero with breadcrumb
- History section with image
- Mission/Vision cards
- Values grid (3 cards)

--- app/Views/services/index.php ---
- Page hero
- 5 service cards in grid

--- app/Views/services/piling.php ---
- Page hero
- Detail content: 3 piling types, equipment, load testing
- CTA form (links to /contact)

--- app/Views/portfolio/index.php ---
- Page hero
- Filter tabs (All / Piling / Civil / Real Estate / Infrastructure)
  Use ?category=piling URL parameter, highlight active tab
- Masonry/grid gallery: loop $galleryItems, show image + overlay with title + category
- Lightbox: implement a simple CSS+JS lightbox using <dialog> or overlay div
  (no jQuery needed, vanilla JS)

--- app/Views/videos/index.php ---
- Page hero
- Video grid by category
- Each card: YouTube thumbnail, title, category badge, play button overlay
- On click: replace thumbnail with <iframe> embed (lazy load pattern)

--- app/Views/contact/index.php ---
- Page hero
- Contact info sidebar: phone, email, WhatsApp link, Instagram, address
- Contact form: Full Name, Email, Subject (dropdown), Message textarea
  Include flash success/error messages display
  Include CSRF + honeypot field
- Map placeholder div

--- app/Views/land/index.php ---
- Page hero
- 2-column listing grid from $landListings
- Each card: image, category badge, title, description, specs (size, features), price, CTA
- "Why Invest" section: 3 bullet points

IMPORTANT FOR ALL VIEWS:
- Wrap all user-supplied/DB text in e() helper
- Display flash messages at top of content area when present
- All forms include csrf_field()
```

---

## ═══════════════════════════════════════════
## PHASE 4 — ADMIN AUTHENTICATION & SECURITY
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 4:**

```
Continue building the Wincon Pilling PHP MVC application.
Phases 1-3 are complete (framework, models, public site).

TASK: Build the Admin Authentication system with maximum security.

SECURITY REQUIREMENTS (non-negotiable):
1. password_hash / password_verify with bcrypt
2. Session fixation prevention (regenerate session ID on login)
3. Brute-force protection: lockout after 5 failed attempts for 15 minutes
4. CSRF protection on all POST forms
5. Rate limiting via RateLimiter class
6. Auth::guard() called in every admin controller method
7. HttpOnly + SameSite=Strict session cookies
8. No user-enumeration (same error for wrong username AND wrong password)
9. Timing-safe comparisons (hash_equals for CSRF, password_verify for passwords)
10. Admin area is under /admin/* — all routes require Auth::check()

═══ STEP 1: app/Controllers/Admin/AdminBaseController.php ═══

abstract class AdminBaseController extends BaseController {
    protected SiteSettingModel $settings;
    protected int $unreadMessages;

    public function __construct() {
        parent::__construct();
        Auth::guard(); // Redirect to /admin if not logged in
        $this->settings = new SiteSettingModel();
        $msgModel = new MessageModel();
        $this->unreadMessages = $msgModel->countUnread();
    }

    protected function render(string $viewName, array $data = [], string $layout = 'admin'): void {
        $data['unreadMessages'] = $this->unreadMessages;
        $data['adminUser'] = Auth::user();
        $data['settings'] = $this->settings->getAll();
        parent::render($viewName, $data, $layout);
    }
}

Exception: AuthController does NOT extend AdminBaseController.
It extends BaseController directly (no auth guard on login page).

═══ STEP 2: app/Controllers/Admin/AuthController.php ═══

loginPage() [GET]:
- If already logged in → redirect to /admin/dashboard
- render('admin/auth/login', ['pageTitle' => 'Admin Login'], 'admin_auth')
  (admin_auth is a minimal layout with no sidebar)

login() [POST]:
- CSRF already verified by App
- $limiter = new RateLimiter()
- $ipKey = 'login_' . md5($request->ip())
- If $limiter->tooManyAttempts($ipKey, 5, 900):
  flash error: 'Too many login attempts. Try again in ' . ceil($limiter->availableIn($ipKey)/60) . ' minutes.'
  redirect('/admin')
- $username = $request->post('username')
- $password = $request->post('password')
- if empty → flash error + redirect back
- $user = AdminUserModel::findByUsername($username)
- Artificial delay: usleep(random_int(100000, 300000)) — prevent timing attacks
- if (!$user || !password_verify($password, $user['password_hash'])):
  $limiter->hit($ipKey)
  flash error: 'Invalid credentials. Please try again.'
  redirect('/admin')
- If AdminUserModel::isLocked($user):
  flash error: 'Account temporarily locked. Try later.'
  redirect('/admin')
- SUCCESS:
  $limiter->clear($ipKey)
  AdminUserModel::resetLoginAttempts($user['id'])
  AdminUserModel::updateLastLogin($user['id'])
  Auth::login($user)
  redirect('/admin/dashboard')

logout() [POST]:
- CSRF verify (done by App)
- Auth::logout()
- flash('info', 'You have been logged out.')
- redirect('/admin')

═══ STEP 3: app/Views/layouts/admin_auth.php ═══

Minimal centered layout for login page only.
Clean, modern design. Dark theme preferred for admin.
No sidebar. Just centered card with logo and form.

═══ STEP 4: app/Views/admin/auth/login.php ═══

Admin login form:
- WINCON logo/title at top
- "Admin Panel" subtitle
- Flash message display (error/success)
- Form: POST /admin/login
  - CSRF hidden field
  - Username input (autocomplete="username")
  - Password input (autocomplete="current-password") with show/hide toggle
  - "Sign In" button
- DO NOT include any "forgot password" or "register" links (not needed)
- Security notice at bottom: "Authorized access only"

═══ STEP 5: app/Views/layouts/admin.php ═══

Professional admin layout with:
- Top bar: logo, page title area, unread messages badge, admin username, logout button (POST form)
- Left sidebar (collapsible on mobile):
  Navigation items:
  1. Dashboard (icon: grid)
  2. Content Management (icon: edit) — sub: Page Contents, Site Settings
  3. Gallery (icon: image)
  4. Videos (icon: play)
  5. Messages (icon: mail) + unread badge count
  6. Services (icon: tool)
  7. Land Listings (icon: map-pin)
  8. --- separator ---
  9. View Website (external link icon, opens in new tab)
- Main content area: outputs $content
- Highlight active nav item based on current URI
- Responsive: sidebar collapses to hamburger on mobile

Use a clean, professional admin style. Suggested color scheme:
- Sidebar: #1e2a3a (dark navy)
- Accent: #f0a500 (amber/gold — matches construction/engineering theme)
- Background: #f5f7fa
- Cards: white with subtle shadow
- Use CSS Grid/Flexbox — no Bootstrap required but allowed for admin

═══ STEP 6: app/Controllers/Admin/DashboardController.php ═══

class DashboardController extends AdminBaseController {
    index():
    - Load counts: gallery total, videos total, messages total, unread messages, land listings
    - Load last 5 messages (newest)
    - Load site_settings
    - render('admin/dashboard/index', compact(...))
}

═══ STEP 7: app/Views/admin/dashboard/index.php ═══

Stat cards row (4 cards):
- Total Gallery Items
- Total Videos
- Total Messages (+ unread badge)
- Land Listings

Quick Actions row:
- Upload Gallery Image
- Add Video
- View Messages
- Add Land Listing

Recent Messages table: last 5 messages with name, email, subject, date, read status
Quick links to all management sections.
```

---

## ═══════════════════════════════════════════
## PHASE 5 — ADMIN MANAGEMENT MODULES
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 5:**

```
Continue building the Wincon Pilling PHP MVC application.
Phases 1–4 are complete. Now build all Admin Management modules.

For EVERY admin controller and view, remember:
- Extend AdminBaseController (which calls Auth::guard())
- Use layout 'admin' in all render() calls
- All POST forms include csrf_field()
- All user output wrapped in e()
- Flash success/error messages displayed in views
- After any write operation: flash + redirect (PRG pattern)

═══ MODULE 1: Content Management ═══

--- app/Controllers/Admin/ContentController.php ---
index():
  Load PageContentModel::getAll() grouped by page.
  render('admin/content/index', ['contentGroups' => ...])

edit(int $id):
  $item = PageContentModel::getById($id) or abort(404)
  render('admin/content/edit', ['item' => $item])

update(int $id) [POST]:
  Validate: value not null (can be empty string for textarea types)
  PageContentModel::update($id, $request->post('value'))
  flash('success', 'Content updated successfully.')
  redirect('/admin/content')

--- Views: admin/content/index.php ---
Accordion or tab layout grouped by page name (Home, About, Services...).
Each content item shows: Label, current value preview (truncated 80 chars), Edit button.

--- Views: admin/content/edit.php ---
Form with:
- Label (read-only display)
- Page and section_key (read-only display)
- Value input: if content_type='text' → <input type="text">
              if content_type='textarea' → <textarea>
              if content_type='html' → <textarea> with note about HTML
- Save button + Cancel link

═══ MODULE 2: Gallery Management ═══

--- app/Controllers/Admin/GalleryController.php ---
index(): Load all gallery items, sorted by sort_order. render index view.

create(): render form view with empty data.

store() [POST]:
  Validate: title (required), category (required, in:piling,civil,infrastructure,real_estate),
            alt_text, sort_order (numeric)
  Handle file upload: $file = $request->files('image')
  Use FileUpload::handle($file, ROOT_PATH.'/public/assets/uploads/gallery/', [...])
  If upload fails → flash error + redirect back
  GalleryModel::create([...])
  flash('success', 'Gallery item added.')
  redirect('/admin/gallery')

edit(int $id): Load item or 404. render form view.

update(int $id) [POST]:
  Validate fields.
  If new image uploaded: delete old image, upload new.
  GalleryModel::update($id, [...])
  flash + redirect.

delete(int $id) [POST]:
  Load item. Delete image file. GalleryModel::delete($id).
  flash + redirect.

reorder() [POST]:
  Expects JSON body: [{id: 1, sort: 0}, ...]
  Update sort_order for each. Return JSON response.

--- Views ---
admin/gallery/index.php:
  - "Add New" button
  - Sortable table/grid (drag-and-drop sort with JS, POST to /admin/gallery/reorder)
  - Columns: Thumbnail (50px), Title, Category badge, Featured toggle, Active toggle, Actions
  - Actions: Edit, Delete (with confirm dialog)

admin/gallery/form.php (used for both create and edit):
  - Title, Alt Text (text inputs)
  - Category (select: Piling, Civil, Infrastructure, Real Estate)
  - Sort Order (number input)
  - Is Featured (checkbox)
  - Is Active (checkbox)
  - Image upload field:
    - If editing: show current image thumbnail
    - File input with client-side preview
    - Accepted: .jpg, .jpeg, .png, .webp (max 5MB note)
  - Submit + Cancel

═══ MODULE 3: Videos Management ═══

--- app/Controllers/Admin/VideoController.php ---
index(): All videos sorted by sort_order.
create(): Render form.
store() [POST]:
  Validate: title (required), youtube_id (required, exactly 11 chars alphanumeric + dash/underscore),
            category (required, in:piling,civil,site,equipment)
  Auto-build thumbnail_url via VideoModel::buildThumbnailUrl($youtubeId)
  VideoModel::create([...])
  flash + redirect.
edit(int $id): Load or 404. Render form.
update(int $id) [POST]: Validate, update, flash, redirect.
delete(int $id) [POST]: Delete, flash, redirect.

--- Views ---
admin/videos/index.php:
  Sortable list. Columns: Thumbnail (from YouTube), Title, YouTube ID (with link icon), Category, Featured, Active, Actions.

admin/videos/form.php:
  - Title, Description (textarea)
  - YouTube Video ID (text, 11 chars) with helper text: "From youtube.com/watch?v=XXXXXXXXXXX"
  - Live preview: on input change, update thumbnail preview image
    src = https://img.youtube.com/vi/{id}/hqdefault.jpg
  - Category (select)
  - Sort Order, Is Featured, Is Active

═══ MODULE 4: Messages Management ═══

--- app/Controllers/Admin/MessageController.php ---
index():
  $filter = $request->get('filter', 'all') — 'all' | 'unread' | 'starred'
  Load messages accordingly.
  render('admin/messages/index', ...)

view(int $id):
  $msg = MessageModel::getById($id) or abort(404)
  MessageModel::markRead($id)
  render('admin/messages/view', ['message' => $msg])

star(int $id) [POST]:
  MessageModel::toggleStar($id)
  flash + redirect back

delete(int $id) [POST]:
  MessageModel::delete($id)
  flash('success', 'Message deleted.')
  redirect('/admin/messages')

markRead() [POST]:
  $ids = $request->post('ids') — array of IDs
  MessageModel::markReadMultiple($ids)
  jsonResponse(['success' => true])

--- Views ---
admin/messages/index.php:
  - Filter tabs: All | Unread (N) | Starred
  - Bulk actions: Mark as read, Delete selected (checkboxes)
  - Table: checkbox, ★ star toggle, Name, Email, Subject (truncated), Date, Read indicator
  - Row click → view message
  - Unread rows styled distinctly (bold or tinted background)

admin/messages/view.php:
  - Back button
  - Message header: From, Email (mailto link), Subject, Service Interest, Date, IP
  - Message body in a card
  - Action buttons: ★ Star/Unstar, Delete
  - "Reply via Email" button (mailto: link with subject pre-filled)

═══ MODULE 5: Services Management ═══

--- app/Controllers/Admin/ServiceController.php ---
Standard CRUD: index, create, store, edit, update, delete.

store/update validation:
  title (required), slug (required, unique, lowercase-dash-only),
  short_description, icon_class, sort_order (numeric), is_active

--- Views ---
admin/services/index.php:
  Sortable table: Title, Slug, Active toggle, Sort, Actions

admin/services/form.php:
  - Title, Slug (auto-generate from title via JS, editable)
  - Short Description (textarea), Full Description (textarea)
  - Icon Class (text input, hint: e.g. "fas fa-hard-hat")
  - Sub Items (dynamic JS list — add/remove bullet points)
    Stored as JSON array. Add row button adds new text input.
  - Detail Page Slug, Sort Order, Is Active
  - Submit + Cancel

═══ MODULE 6: Land Listings Management ═══

--- app/Controllers/Admin/LandController.php ---
Standard CRUD: index, create, store, edit, update, delete.

store/update validation:
  title (required), category (in:commercial,residential),
  location, size_sqm (numeric), price, description

Handle image upload same as gallery.
Features: stored as JSON — use same dynamic JS list as services sub-items.

--- Views ---
admin/land/index.php: Table with image thumb, title, category, price, active, actions.
admin/land/form.php: All fields including dynamic features list and image upload.

═══ MODULE 7: Site Settings ═══
Add to ContentController or create SiteSettingController:

index() → list all settings in groups:
  Company Info group: company_name, company_tagline, company_rc, etc.
  Contact Info group: phone, email, whatsapp, instagram, address
  SEO group: meta_description, og_image
  Other: google_maps_api_key, footer_copyright

updateAll() [POST]:
  Loop through posted settings, update each via SiteSettingModel::set()
  flash + redirect.

View: Single long form with sections/groups, all inputs, one "Save All Settings" button.
```

---

## ═══════════════════════════════════════════
## PHASE 6 — FINISHING, SECURITY HARDENING & README
## ═══════════════════════════════════════════

**Cursor prompt — paste this as Phase 6:**

```
Final phase of the Wincon Pilling PHP MVC application.
All phases 1–5 are complete. Perform final hardening and finishing tasks.

═══ STEP 1: Security hardening review ═══

Go through EVERY file and verify:
1. All POST routes call CSRF::verifyRequest() via App.php (already in place).
2. All file uploads use FileUpload class — no direct move_uploaded_file() elsewhere.
3. All SQL uses PDO prepared statements — zero raw string interpolation in queries.
4. All output through e() — grep views for <?= that don't use e() and fix.
5. Admin routes all call Auth::guard() via AdminBaseController constructor.
6. Login throttle via RateLimiter is active.
7. Session cookie is HttpOnly + SameSite=Strict.
8. .htaccess blocks access to /app, /core, /config, /database, /storage:

Add to root .htaccess (or create per-directory .htaccess files):
  <Directory "app">
    deny from all
  </Directory>
  etc.

9. Add to public/.htaccess: block access to .env, .git, *.sql, *.db files.
10. Log all errors to storage/logs/app.log, never display in production.
    config/app.php: if APP_DEBUG=false → ini_set('display_errors', '0')

═══ STEP 2: Error pages ═══

Create app/Views/errors/:
  - 403.php (Forbidden)
  - 404.php (Page Not Found) — with navigation back to homepage
  - 500.php (Server Error)

Response::abort() should render these views with correct HTTP status code.

═══ STEP 3: Input sanitization middleware ═══

In Request::post() and Request::get():
- trim() all string values
- DO NOT strip_tags by default (admin may need HTML in content)
- For public contact form: strip_tags in ContactController before saving

═══ STEP 4: JavaScript enhancements ═══

public/assets/js/app.js:
- Mobile hamburger menu toggle
- Smooth scroll for anchor links
- Portfolio filter: handle ?category= parameter or add JS-based filter using CSS classes
- Video lazy-load: replace thumbnail+play-button with iframe on click
- Contact form: client-side validation before submit (non-blocking, UX only)
- Lightbox for portfolio images: vanilla JS, no jQuery
  - On image click: show overlay with full image, close on click/Escape
- Scroll-reveal animations (simple IntersectionObserver, no library needed)

public/assets/js/admin.js:
- Sidebar toggle (mobile collapse)
- Confirm delete dialogs: intercept delete form submits
- Gallery drag-and-drop sort: use HTML5 drag API or SortableJS CDN
  On drag end, collect order, POST to /admin/gallery/reorder as JSON
- Image file input preview (show thumbnail before upload)
- YouTube ID live preview in video form
- Dynamic add/remove bullet rows for services and land features
- Slug auto-generation from title input (lowercase, replace spaces with dashes)
- Mark messages as read via fetch() when viewed

═══ STEP 5: CSS polish ═══

public/assets/css/app.css:
- Replicate all styles from the original static site exactly
- Add responsive breakpoints (mobile-first)
- Add utility classes used by views

public/assets/css/admin.css:
- Professional dark sidebar admin panel style
- Sidebar: #1e2a3a, accent: #f0a500
- Card components, table styles, form styles, badge styles
- Responsive admin layout (sidebar collapses on <768px)
- Flash message styles: success (green), error (red), info (blue)
- Loading states for AJAX actions

═══ STEP 6: README.md ═══

Write a professional README.md with:

# Wincon Pilling — PHP MVC Web Application

## Requirements
- PHP 8.1+
- SQLite3 extension enabled
- Apache with mod_rewrite OR Nginx with rewrite rules
- File write permission for /database/ and /storage/logs/ and /public/assets/uploads/

## Installation
1. Clone / upload to server
2. Copy .env.example to .env and fill in values
3. Run: php database/seed.php
4. Point web server document root to /public/
5. Login at: yoursite.com/admin (username: admin, password: Admin@123456)
6. IMPORTANT: Change admin password immediately after first login

## Folder structure explanation (one-liner per folder)

## Admin Panel Features
- List all features

## Security Features
- List all implemented security measures

## Customization Guide
- How to add a new page
- How to add a new admin module
- How to change site settings

## Deployment Checklist
- [ ] Set APP_ENV=production in .env
- [ ] Set APP_DEBUG=false
- [ ] Change admin password
- [ ] Set correct APP_URL
- [ ] Verify /database/wincon.db is not web-accessible
- [ ] Verify /storage/logs/ is not web-accessible
- [ ] Enable HTTPS and update APP_URL
- [ ] Set up regular database backups (cp wincon.db wincon.db.bak)

═══ STEP 7: Final .gitignore ═══

.env
/database/wincon.db
/storage/logs/*.log
/storage/cache/*
/public/assets/uploads/gallery/*
/public/assets/uploads/thumbnails/*
!**/.gitkeep
/vendor/
.DS_Store
Thumbs.db
```

---

## ═══════════════════════════════════════════
## PROFESSIONAL ARCHITECTURE NOTES FOR CURSOR
## ═══════════════════════════════════════════

These are additional suggestions to communicate to Cursor for code quality:

**1. Naming Conventions (PSR-12 compatible)**
- Classes: PascalCase
- Methods/variables: camelCase
- Constants: UPPER_SNAKE_CASE
- Files: Same name as class (e.g., HomeController.php)
- DB columns: snake_case
- View files: snake_case

**2. Type Safety**
- All function/method signatures MUST use PHP 8 type hints
- Return types declared on all methods
- Use declare(strict_types=1) at top of every PHP file

**3. Single Responsibility**
- Controllers: only orchestrate (get data, pass to view, redirect)
- Models: only DB operations
- Views: only presentation
- Core classes: only their declared single concern

**4. No Business Logic in Views**
- Views receive prepared data only
- No DB calls in views
- No complex conditionals — move to controller

**5. Consistent Error Handling**
- Models throw exceptions for DB errors (PDOException bubbles up)
- Controllers catch and log, show user-friendly error
- Always log with context: log_error($msg, ['user_id'=>..., 'route'=>...])

**6. PRG Pattern (Post-Redirect-Get)**
- EVERY POST action ends with a redirect (never render directly after POST)
- Flash messages communicate result after redirect

**7. Immutable Config**
- config/ files return arrays, never modify at runtime
- .env loaded ONCE in config/app.php into constants

**8. Code Comments**
- PHPDoc blocks on all class methods with @param, @return, @throws
- Inline comments for non-obvious logic only

---
*End of Cursor AI Master Prompt — Wincon Pilling PHP MVC Conversion*
*Designed for use with Cursor Composer in Agent mode, PHP 8.1+, SQLite*
