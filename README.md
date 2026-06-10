# Bravo Secure Website

Professional PHP/MySQL website and lightweight CMS for Bravo Secure, built from the supplied PDF layout.

## What Is Included

- Public pages: Home, Services, Bravo Comms, Virtual Bodyguard, Agent Network, About, Contact.
- CMS admin for editing page copy, hero content, CTA text, section headings, cards, and contact message statuses.
- WordPress-style page management with new pages, parent pages, subpages, and nested public URLs.
- Logo settings plus image/video media uploads for hero areas.
- Contact form stored in MySQL.
- First-admin setup flow at `/admin/setup`.
- No Composer dependency required.

## Requirements

- PHP 8.1 or newer with PDO MySQL enabled.
- MySQL 8 or MariaDB 10.5+.
- Apache with `mod_rewrite`, Nginx, or PHP's built-in server.

## Setup

1. Install PHP if it is not already available.

```bash
brew install php
```

2. Make sure MySQL is running.

```bash
brew services start mysql
mysqladmin -u root -p ping
```

3. Create a MySQL database.

```sql
CREATE DATABASE bravo_secure CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Import the schema and starter content.

```bash
mysql -u root -p bravo_secure < database/schema.sql
mysql -u root -p bravo_secure < database/seed.sql
mysql -u root -p bravo_secure < database/migrations/2026_05_24_add_logo_and_video_media.sql
mysql -u root -p bravo_secure < database/migrations/2026_05_24_add_page_hierarchy.sql
```

5. Create your environment file.

```bash
cp .env.example .env
```

Update `.env` with the database credentials.

6. Serve the `public` directory as the document root.

```bash
php -S localhost:8000 -t public public/router.php
```

7. Visit:

- Public site: `http://localhost:8000`
- CMS setup: `http://localhost:8000/admin/setup`

After creating the first admin user, the setup route redirects to the login screen.

## Notes

The public site has packaged fallback content so the pages can still render while the database is unavailable. The CMS requires MySQL because edits, admin accounts, and form submissions are stored there.

## Active Links

Use the PHP app URL, not `public/preview.html`, for the real website. The PHP routes make these links active:

- `/`
- `/services`
- `/bravo-comms`
- `/virtual-bodyguard`
- `/agent-network`
- `/about`
- `/contact`
- `/admin`
- `/admin/setup`
- `/admin/pages`
- `/admin/pages/new`

New subpages use their parent path automatically, for example `/services/executive-transfers`.

The `preview.html` file is only a static visual preview and intentionally does not power the CMS.
