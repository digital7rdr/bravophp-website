# Bravo Secure — PHP rebuild (Phase 1: public site)

The site was rebuilt in this PHP/MySQL app (Hostinger-compatible, no Node.js).
Styling uses Tailwind via CDN with the brand config inlined in the layout.

## What's in Phase 1

- New design: dark collapsible sidebar, navy top bar, full-bleed hero banner,
  light content sections with shadowed cards, dark footer.
- Pages: Home, Request Support, Secure Services, Virtual Bodyguard, Bravo Comms,
  Long-Term Bookings, Agent Network, About, Contact, and Manage (lookup).
  `/services` redirects to `/secure-services`.
- Request panel with service tabs (Secure Transfer / Executive Protection /
  Ongoing Support / Custom Request) + contact fields → stored in MySQL.
- Contact form → stored. Manage page looks up a request by reference + email or
  reference + secure code.

Key files: `resources/views/layouts/site.php` (layout + Tailwind config),
`app/Support/SiteContent.php` (all content), `app/Support/components.php` (UI
render helpers), `app/Controllers/PageController.php`, `routes/web.php`,
`app/Models/Submission.php`, `public/assets/js/app.js` (sidebar + tabs).

## Run locally

```bash
php -S localhost:8000 -t public public/router.php
```

Then open http://localhost:8000

## Database

Set DB creds in `.env` (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`,
`DB_PASSWORD`). Create the submissions table:

```bash
mysql -u USER -p DBNAME < database/migrations/2026_06_05_add_submissions.sql
```

(or import that file in phpMyAdmin on Hostinger.)

If the database isn't connected, the public pages still render and forms still
show a confirmation — submissions just aren't saved until the DB is set up.

## Deploy to Hostinger

Upload the project; set the domain's document root to the `public/` folder
(the `.htaccess` there routes everything to `index.php`). Create a MySQL database
in hPanel, import the migration SQL, and put the DB credentials in `.env`.

## Admin (Phase 2 — done)

Sign-in-protected operations area (reuses the `users` table + `Auth`).

1. First run: visit `/admin/setup` to create the first admin account.
2. Then sign in at `/admin/login`.

- **`/admin`** — Requests dashboard: every form submission, with search +
  status/type filters. Open a request to see all fields and change its status
  (new → reviewing → confirmed → closed).
- **`/admin/settings`** — Logo + icon upload, wordmark, logo size, brand colours
  (accent, heading text, body text, sidebar/footer, panels) and font. These are
  stored in the `settings` table and applied across the public site (the layout
  reads them into the Tailwind config; the sidebar/footer use the uploaded logo).

Uploads are saved to `public/assets/uploads/`.

## Content editing (Phase 3 — done)

**`/admin/content`** lists every page; open one to edit its hero, sections,
cards, steps, CTA and SEO in a structured form (add/remove cards via the blank
"Add new" slots; clear an item to remove it). Saving stores a JSON override in
the `content` table, deep-merged over the code defaults in `SiteContent.php`, so
changes are live immediately.

Run the migration once: import `database/migrations/2026_06_05_add_content.sql`.

**Image uploads:** the content editor now has an upload button (with preview) on
the page **hero image** and on **every card** — click Upload, pick a file, it
saves to `public/assets/uploads/` and fills the field. Cards without an image
fall back to their icon; cards/heroes with one show the photo. Uploads go through
`POST /admin/upload`.

Requires PHP 8.1+ (`array_is_list`).
