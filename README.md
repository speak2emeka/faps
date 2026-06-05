# FAPS and Royal Prestige School Website

Modern responsive school website and CMS for:

- **First Age Private School (FAPS)**: Pre-Nursery, Nursery, Primary
- **Royal Prestige Leadership Academy**: Junior Secondary and Senior Secondary

The project presents one unified school system while keeping the Primary and Secondary sections separate for colors, admins, activities, facilities, and galleries.

## Live Site

GitHub Pages:

https://speak2emeka.github.io/faps/

Project repository:

https://github.com/speak2emeka/faps

## Main Website Pages

- `public/index.html`: Homepage
- `public/about.html`: About the school system
- `public/primary-school.html`: FAPS Primary section
- `public/secondary-school.html`: Royal Prestige Secondary section
- `public/primary-facilities.html`: Primary facilities
- `public/secondary-facilities.html`: Secondary facilities
- `public/primary-gallery.html`: Primary gallery
- `public/secondary-gallery.html`: Secondary gallery
- `public/academics.html`: Academics
- `public/admissions.html`: Admissions
- `public/school-life.html`: School life
- `public/news.html`: News and updates
- `public/gallery.html`: Combined gallery entry point
- `public/facilities.html`: Combined facilities entry point
- `public/contact.html`: Contact and admin-office enquiry form

## CMS/Admin

Admin entry point:

`admin/login.html`

On GitHub Pages or when opened from `file://`, the login opens a static dashboard preview after valid demo credentials. Real content editing requires PHP and MySQL hosting.

Default demo credentials:

- Super Admin: `admin` / `admin123`
- Primary Admin: `primary_admin` / `admin123`
- Secondary Admin: `secondary_admin` / `admin123`

Change all default passwords before production use.

### CMS Modules

- News and announcements
- Events
- Homepage sliders
- Downloads and links
- Newsletter updates
- Testimonials
- STEM and Robotics
- Primary activities
- Secondary activities
- Primary facilities
- Secondary facilities
- Primary gallery
- Secondary gallery

## Database

Fresh install:

1. Create a MySQL database named `faps_cms`.
2. Import `db/database.sql`.
3. Update database credentials in `config.php`.

Existing install update:

Run:

`db/migration_sync_school_updates.sql`

This adds the Primary/Secondary school scope, activity tables, and facility tables.

## Picture Replacement Guide

A PDF guide is included:

`FAPS_Picture_Replacement_List.pdf`

It lists every placeholder image and the recommended actual school photo to replace it with.

## Uploads

CMS uploads are stored in:

`assets/uploads/`

The folder is ignored by git except for `.gitkeep`, so production uploads will not be accidentally committed.

## Notes

- The static pages work on GitHub Pages.
- PHP CMS/API features require a PHP + MySQL host.
- The frontend includes fallback sample content when the database is not connected.
- WhatsApp chat is integrated through the floating button on public pages.
