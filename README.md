# Wincon Pilling — PHP MVC Web Application

A production-oriented PHP 8.1+ MVC application for **Wincon Pilling Construction Limited**: public marketing site, contact capture, and a secured admin panel for content, media, services, land listings, and site settings. Data is stored in **SQLite**; uploads live under `public/assets/uploads/`.

## Requirements

- **PHP 8.1+** with extensions: `pdo_sqlite`, `sqlite3`, `json`, `mbstring`, `fileinfo` (recommended for image MIME checks)
- **Apache** with `mod_rewrite` (root `.htaccess` routes requests when the document root is the **project folder**; `public/.htaccess` is used when the document root is **`/public`** only)
- **File write permission** for:
  - `database/` (SQLite file)
  - `storage/logs/` and `storage/cache/`
  - `public/assets/uploads/` (gallery, land images, etc.)

## Installation

1. Clone or upload the project to your server.
2. Copy `.env.example` to `.env` and set at least `APP_URL`, `APP_ENV`, `APP_DEBUG`, and `DB_PATH` (default: `database/wincon.db`).
3. Create writable directories if needed: `storage/logs`, `storage/cache`, `public/assets/uploads/gallery`, `public/assets/uploads/land`.
4. Run the seeder:  
   `php database/seed.php`
5. Point the web server **document root** to either the **project folder** (simplest: Laragon’s default for a site under `www`) **or** only the **`public`** folder. The repo includes **`index.php`** at the project root and a root **`.htaccess`** so routes and `/assets/...` work **without** `/public` in the URL.
6. Set **`APP_URL`** in `.env` to your real site URL (scheme + host, no trailing slash), e.g. `https://winconpiling.test`. Do **not** append `/public`.
7. Open the admin login: `https://yoursite.com/admin`.
8. **Default credentials (change immediately):** username `admin`, password `Admin@123456` (see seeder output).

### Laragon / local `.test` domain

1. Keep the virtual host document root as the **project folder** (no need to point it at `public` only).
2. Use `https://winconpiling.test` if Laragon SSL is enabled; otherwise `http://winconpiling.test`. Set **`APP_URL`** to match (same scheme).
3. Restart Apache. If the host does not resolve, ensure `winconpiling.test` → `127.0.0.1` (Laragon usually adds this).

## Folder structure (overview)

| Path | Purpose |
|------|---------|
| `app/Controllers/` | HTTP controllers (public + `Admin\` namespace) |
| `app/Models/` | Data access (PDO models) |
| `app/Views/` | PHP templates (layouts, partials, admin screens) |
| `config/` | `app.php`, `routes.php`, `database.php` |
| `core/` | Framework kernel: `App`, `Router`, `Request`, `Response`, `View`, `Auth`, `CSRF`, etc. |
| `database/` | `schema.sql`, `seed.php`, SQLite DB file (gitignored when local) |
| `public/` | Web root: `index.php`, assets, uploads |
| `storage/` | Logs, cache, non-public state |
| `website_theme/` | Reference static HTML (not served by the app) |

## Admin panel features

- **Dashboard** — counts, quick links, recent messages.
- **Page contents** — edit per-page text/HTML blocks.
- **Site settings** — company, contact, SEO, maps key, etc.
- **Gallery** — upload, categories, featured/active, drag sort, delete.
- **Videos** — YouTube ID, categories, thumbnails, sort, CRUD.
- **Messages** — filter, read/star, bulk mark read, bulk delete, reply via `mailto:`.
- **Services** — CRUD with slugs, icons, JSON sub-items, sort.
- **Land listings** — CRUD with images, features JSON, sort.
- **Authentication** — bcrypt passwords, CSRF on POST, session regeneration on login, IP login throttling, account lockout, HttpOnly + SameSite session cookies.

## Security features

- CSRF verification on all **POST** requests (`App` → `CSRF::verifyRequest()`).
- Admin area gated by `Auth::guard()` via `AdminBaseController`.
- Passwords hashed with **bcrypt** (`password_hash` / `password_verify`).
- **RateLimiter** (file-backed) for admin login attempts per IP.
- Session cookies: **HttpOnly**, **SameSite=Strict**, secure flag when HTTPS.
- File uploads only through **`FileUpload`** (MIME/size checks, path under `public/assets/uploads`).
- SQL via **PDO prepared statements**; table names come from trusted model properties, not user input.
- Public contact submissions: **strip_tags** on stored text fields; honeypots + per-IP contact limiter.
- Sensitive paths blocked via **`.htaccess`** (`app/`, `core/`, `config/`, `database/`, `storage/`) when Apache allows overrides.
- PHP errors logged to `storage/logs/app.log` in production; **`APP_DEBUG=false`** disables error display.

## Customization guide

### Add a new public page

1. Add a route in `config/routes.php` (`GET`, path, controller class, action).
2. Create a controller in `app/Controllers/` extending `BaseController` (or `Admin\...` for admin).
3. Add a view under `app/Views/...` and call `$this->render('view/name', $data, 'main')`.
4. Optionally add page content rows in `page_contents` (via admin or seed) and read with `PageContentModel`.

### Add a new admin module

1. Add routes under `/admin/...` pointing to `Admin\YourController`.
2. Extend **`AdminBaseController`** (not `BaseController`) so `Auth::guard()` runs.
3. Use layout **`admin`** in `$this->render(..., [], 'admin')`.
4. POST forms must include `csrf_field()`; after writes use flash + redirect (PRG).

### Change site settings

Use **Admin → Site settings** or edit `site_settings` in the database. Keys are referenced from views via `$settings['company_name']`, etc.

## Deployment checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Change the **admin password** after first login
- [ ] Set **`APP_URL`** to the canonical public URL (including `https://`)
- [ ] Confirm **`/database/wincon.db`** is **not** directly web-accessible (root `.htaccess` blocks `/database/` when the document root is the project folder; if the document root is only `public/`, the DB is already outside the web root)
- [ ] Confirm **`/storage/`** is **not** web-accessible
- [ ] Enable **HTTPS** and align `APP_URL`
- [ ] Schedule **database backups** (e.g. copy `wincon.db` to dated files off-server)
- [ ] Restrict file permissions on `.env` and `database/`

## License / attribution

Proprietary project for Wincon Pilling Construction Limited. Third-party libraries (Bootstrap, Font Awesome, AOS, GLightbox, SortableJS, etc.) remain under their respective licenses.
