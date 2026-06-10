# Hostinger Upload Steps

This package is arranged for Hostinger shared hosting.

## 1. Create The Database

1. Open Hostinger hPanel.
2. Go to **Databases** > **MySQL Databases**.
3. Create a new database and user.
4. Copy the database name, username, password, and host.

Hostinger database names usually look like:

```text
u123456789_bravo_secure
u123456789_adminuser
```

## 2. Import The SQL

1. Open **phpMyAdmin** from Hostinger.
2. Select the new database.
3. Click **Import**.
4. Upload:

```text
database/hostinger_import.sql
```

5. Click **Go**.

## 3. Upload The Website

1. Open **File Manager**.
2. Go to your domain folder, usually:

```text
domains/your-domain.com/
```

3. Upload and extract `bravo-secure-hostinger.zip` there.
4. Confirm the final layout looks like this:

```text
domains/your-domain.com/
  app/
  bootstrap.php
  config/
  database/
  public_html/
    .htaccess
    index.php
    assets/
  resources/
  routes/
  .env
```

Important: `public_html/index.php` must be directly inside `public_html`, not inside an extra nested folder.

## 4. Update The .env File

Edit `.env` in the domain folder, not inside `public_html`.

Use your Hostinger database details:

```env
APP_NAME="Bravo Secure"
APP_ENV=production
APP_URL=https://your-domain.com

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_bravo_secure
DB_USERNAME=u123456789_adminuser
DB_PASSWORD=your_hostinger_database_password

MAIL_TO=info@your-domain.com
```

If Hostinger shows a different MySQL host, use that instead of `localhost`.

## 5. Set PHP Version

In Hostinger hPanel, set the site PHP version to PHP 8.1 or newer.

## 6. Create The CMS Admin

Open:

```text
https://your-domain.com/admin/setup
```

Create your first admin account. After that, use:

```text
https://your-domain.com/admin/login
```

## 7. Manage Content

- Pages: `/admin/pages`
- Add page or subpage: `/admin/pages/new`
- Media: `/admin/media`
- Settings and logo: `/admin/settings`

Subpages automatically use parent URLs, for example:

```text
/services/executive-transfers
```

## Troubleshooting

If the homepage works but inner links show 404, check that `public_html/.htaccess` exists.

If you see a database error, check `.env` database credentials and confirm the SQL import completed.

If the site files are inside `public_html/bravo-secure-hostinger/public_html`, move the inner `public_html` contents up so `index.php` is directly in `public_html`.
