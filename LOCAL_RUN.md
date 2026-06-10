# Local Run Checklist

Run the full Bravo Secure website with active navigation and CMS:

```bash
brew install php
brew services start mysql
mysqladmin -u root -p ping
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS bravo_secure CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p bravo_secure < database/schema.sql
mysql -u root -p bravo_secure < database/seed.sql
mysql -u root -p bravo_secure < database/migrations/2026_05_24_add_logo_and_video_media.sql
mysql -u root -p bravo_secure < database/migrations/2026_05_24_add_page_hierarchy.sql
cp .env.example .env
php -S localhost:8000 -t public public/router.php
```

Then open:

- Public website: `http://localhost:8000`
- CMS setup: `http://localhost:8000/admin/setup`

Update `.env` if your MySQL username or password is different:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bravo_secure
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

After creating the first admin user, use:

- CMS login: `http://localhost:8000/admin/login`
- CMS dashboard: `http://localhost:8000/admin`
- Manage pages: `http://localhost:8000/admin/pages`
- Add a page or subpage: `http://localhost:8000/admin/pages/new`

To create a subpage, choose an existing page in the Parent Page dropdown. The public URL will follow the parent path, such as `/services/executive-transfers`.
