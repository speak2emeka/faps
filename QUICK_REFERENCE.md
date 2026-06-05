# 🔗 QUICK REFERENCE GUIDE
## Educational Excellence CMS - Developer & Admin Cheat Sheet

---

## 🌐 WEBSITE URLS

### Local Development
```
Website:  http://localhost/FAPS/public/
Admin:    http://localhost/FAPS/admin/login.html
API:      http://localhost/FAPS/api/
```

### Production (Update with your domain)
```
Website:  https://yourdomain.com/FAPS/public/
Admin:    https://yourdomain.com/FAPS/admin/login.html
API:      https://yourdomain.com/FAPS/api/
```

---

## 🔑 DEFAULT CREDENTIALS

```
Admin Username:  admin
Admin Password:  admin123

⚠️  CHANGE IMMEDIATELY IN PRODUCTION!
```

---

## 📂 KEY FILE PATHS

| File | Purpose | Location |
|------|---------|----------|
| Database Config | DB credentials | `/config.php` (lines 5-10) |
| Database Schema | Tables & data | `/db/database.sql` |
| Homepage | Main website | `/public/index.html` |
| Admin Login | Admin panel | `/admin/login.html` |
| News API | Get/Post news | `/api/news.php` |
| Events API | Get/Post events | `/api/events.php` |
| Gallery API | Get/Post gallery | `/api/gallery.php` |
| Theme Styles | All CSS | `/css/school.css` |
| JS Functions | Core JS | `/js/school.js` |

---

## 🔌 API ENDPOINTS

### GET Requests (Retrieve Data)

```
GET /api/news.php
  Parameters: category, page, limit
  Response: {success, data: {items: [], pagination: {}}}

GET /api/events.php
  Parameters: upcoming, category
  Response: {success, data: []}

GET /api/gallery.php
  Parameters: category, type, page
  Response: {success, data: []}

GET /api/stem.php
  Parameters: type, level
  Response: {success, data: []}

GET /api/sliders.php
  Response: {success, data: []}
```

### POST Requests (Submit Data)

```
POST /api/contact.php
  Required: name, email, subject, message
  Response: {success, message}

POST /api/newsletter.php
  Required: email
  Optional: name
  Response: {success, message}
```

---

## 📊 DATABASE TABLES

### Quick Reference

```
users              → Admin user accounts
news               → News & announcements
events             → School events & calendar
gallery            → Photos & videos
stem_programs      → STEM & Robotics programs
sliders            → Homepage hero sliders
downloads          → Downloadable documents
testimonials       → Student/Parent testimonials
newsletter_subscribers → Email list
contact_submissions    → Contact form messages
```

---

## 🎨 CSS VARIABLES

### Colors
```css
--primary-blue:      #1B4D7D    /* School main color */
--primary-gold:      #D4AF37    /* School accent */
--primary-white:     #FFFFFF    /* Background */
--accent-light-blue: #E8F0F7
--accent-dark-blue:  #0A1F2E
--text-dark:         #2C3E50    /* Main text */
--text-light:        #7F8C8D    /* Secondary text */
--bg-light:          #F5F7FA
--border:            #E0E4E8    /* Borders */
--success:           #27AE60
--warning:           #F39C12
--danger:            #E74C3C
```

### Spacing
```css
--spacing-xs:   0.5rem
--spacing-sm:   1rem
--spacing-md:   1.5rem
--spacing-lg:   2rem
--spacing-xl:   2.5rem
--spacing-2xl:  3rem
--spacing-3xl:  4rem
```

---

## 📝 COMMON CODE SNIPPETS

### Display Published News
```php
<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM `news` WHERE `is_published` = 1 ORDER BY `published_date` DESC LIMIT 10");
$news = $stmt->fetchAll();
?>
```

### Upload File
```php
<?php
$file = $_FILES['file'];
$result = upload_file($file); // Returns: ['success' => true/false, 'path' => '...', 'error' => '...']
?>
```

### Sanitize Input
```php
<?php
$clean = sanitize_input($_POST['user_input']);
?>
```

### Check Admin Session
```php
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.html');
    exit;
}
?>
```

### Return JSON Response
```php
<?php
echo get_json_response(true, "Success message", ['data' => 'value']);
// Outputs: {"success": true, "message": "Success message", "data": {"data": "value"}}
?>
```

---

## 🛠️ JAVASCRIPT API CLIENT

### Fetch News
```javascript
const schoolWebsite = new SchoolWebsite();
schoolWebsite.loadNews('news', 1).then(data => {
    console.log(data); // { items: [], pagination: {} }
});
```

### Fetch Events
```javascript
schoolWebsite.loadEvents(true, 'academic').then(data => {
    console.log(data); // Array of events
});
```

### Fetch Gallery
```javascript
schoolWebsite.loadGallery('school-life', 'image', 1).then(data => {
    console.log(data);
});
```

### Fetch STEM Programs
```javascript
schoolWebsite.loadSTEMPrograms('robotics', 'sss').then(data => {
    console.log(data);
});
```

### Fetch Sliders
```javascript
schoolWebsite.loadSliders().then(data => {
    console.log(data);
});
```

### Show Notification
```javascript
schoolWebsite.showNotification('Success', 'Operation completed!', 'success');
// Types: success, error, info, warning
// Auto-dismisses after 5 seconds
```

---

## 📱 RESPONSIVE BREAKPOINTS

```css
/* Mobile First Approach */
Mobile:  < 480px
Tablet:  480px - 768px
Desktop: 768px+

/* Grid System */
.grid { grid-template-columns: 1fr; }
.grid-2 { grid-template-columns: repeat(2, 1fr); }
.grid-3 { grid-template-columns: repeat(3, 1fr); }
.grid-4 { grid-template-columns: repeat(4, 1fr); }

/* Media Queries */
@media (max-width: 768px) { ... }
@media (max-width: 480px) { ... }
```

---

## 🔐 SECURITY CONSTANTS

```php
// Session timeout (seconds)
define('SESSION_TIMEOUT', 3600); // 1 hour

// Upload settings
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_TYPES', [
    'image/jpeg', 'image/png', 'image/gif',
    'video/mp4', 'application/pdf'
]);

// Password hashing
password_hash($password, PASSWORD_BCRYPT);
password_verify($password, $hash);
```

---

## 📋 ADMIN MANAGEMENT PAGES

### Access from Admin Panel

| Page | URL | Purpose |
|------|-----|---------|
| Dashboard | `/admin/dashboard.php` | Overview & stats |
| News | `/admin/manage-news.php` | Create/Edit/Delete news |
| Events | `/admin/manage-events.php` | Manage events |
| Gallery | `/admin/manage-gallery.php` | Manage photos/videos |
| STEM | `/admin/manage-stem.php` | STEM programs |
| Sliders | `/admin/manage-sliders.php` | Homepage sliders |
| Downloads | `/admin/manage-downloads.php` | Files management |
| Testimonials | `/admin/manage-testimonials.php` | Testimonials |
| Messages | `/admin/view-contacts.php` | Contact submissions |
| Subscribers | `/admin/view-subscribers.php` | Email subscribers |

---

## 💾 DATABASE QUERIES

### Common Operations

```sql
-- View all published news
SELECT * FROM `news` WHERE `is_published` = 1 ORDER BY `published_date` DESC;

-- View upcoming events
SELECT * FROM `events` WHERE `event_date` >= NOW() ORDER BY `event_date` ASC;

-- View admin user
SELECT * FROM `users` WHERE `username` = 'admin';

-- Update news
UPDATE `news` SET `is_published` = 1 WHERE `id` = 5;

-- Delete old messages
DELETE FROM `contact_submissions` WHERE `created_at` < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Count subscribers
SELECT COUNT(*) FROM `newsletter_subscribers` WHERE `is_active` = 1;
```

---

## 🚀 DEPLOYMENT CHECKLIST

```
☐ Upload all files to server
☐ Create database in cPanel
☐ Import database.sql
☐ Update config.php credentials
☐ Set file permissions (755)
☐ Enable HTTPS/SSL
☐ Change admin password
☐ Test homepage loads
☐ Test admin login
☐ Test API endpoints
☐ Test contact form
☐ Test file upload
☐ Setup email (optional)
☐ Configure WhatsApp number
☐ Add school content
☐ Go live!
```

---

## 🐛 DEBUG MODE

### Enable PHP Errors (Development Only)

In `config.php`, add:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Check PHP Version
```
Should be: 7.2 or higher
Check: <?php phpinfo(); ?>
```

### Test Database Connection
```php
<?php
try {
    $pdo->query("SELECT 1");
    echo "✓ Database connected";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage();
}
?>
```

### Test API
Open in browser: `https://yourdomain.com/FAPS/api/news.php`

Should return JSON

---

## 📞 IMPORTANT CONFIG SETTINGS

File: `/config.php`

```php
// Database (lines 5-10)
DB_HOST, DB_USER, DB_PASS, DB_NAME

// URLs (line 11)
SITE_URL

// School Info (lines 23-27)
SCHOOL_EMAIL, SCHOOL_PHONE, SCHOOL_ADDRESS
WHATSAPP_NUMBER, WHATSAPP_MESSAGE

// Upload (line 39)
MAX_FILE_SIZE, ALLOWED_TYPES

// Sessions (line 42)
SESSION_TIMEOUT
```

---

## 🎯 FILE STRUCTURE REMINDER

```
FAPS/
├── config.php ..................... Update with your DB credentials
├── db/database.sql ................ Import to create tables
├── api/ ............................ 7 API endpoints (auto-working)
├── admin/ .......................... Login + Dashboard
├── public/ ......................... Main website
├── css/school.css .................. Theme & components
└── js/school.js ................... Core functionality
```

---

## ⏱️ TYPICAL SETUP TIME

- Upload files: 5-10 minutes
- Create database: 2-3 minutes
- Import schema: 1-2 minutes
- Update config: 2-3 minutes
- Test website: 5 minutes

**Total: 15-25 minutes to go live!**

---

## 🆘 QUICK TROUBLESHOOTING

| Problem | Solution |
|---------|----------|
| Blank page | Check PHP errors, verify config.php credentials |
| Can't login | Clear cookies, check users table in database |
| API returns nothing | Check if content is published (is_published=1) |
| Upload fails | Check /assets/uploads/ permissions (755) |
| White screen | Check MySQL server is running |

---

## 📚 DOCUMENTATION FILES

```
README.md                    Full documentation
DEPLOYMENT_GUIDE.md         Step-by-step setup
PROJECT_SUMMARY.md          Project overview
QUICK_REFERENCE.md          This file
```

---

## 🎓 LEARNING RESOURCES

### For Modifying Pages
1. See `/public/index.html` for page structure
2. Check `/css/school.css` for styling
3. Review `/js/school.js` for JavaScript

### For Adding Features
1. Create API in `/api/yourfeature.php`
2. Add database table in `database.sql`
3. Create admin page in `/admin/manage-yourfeature.php`
4. Load data in front-end page

### For Custom Styling
1. Modify CSS variables in `:root {}`
2. Add custom classes in `school.css`
3. Use existing classes from component library

---

## 💡 PRO TIPS

✅ **Backup regularly** - Weekly database backups
✅ **Monitor users** - Check admin access logs
✅ **Update content** - Keep news/events fresh
✅ **Test forms** - Verify submissions save
✅ **Check performance** - Monitor server response times
✅ **Use HTTPS** - Always use SSL certificate
✅ **Update passwords** - Change defaults immediately
✅ **Optimize images** - Keep file sizes small

---

## 🔗 QUICK LINKS

**Admin Access:** 
```
https://yourdomain.com/FAPS/admin/login.html
Username: admin
Password: (your new password)
```

**Public Website:**
```
https://yourdomain.com/FAPS/public/
```

**Database Management:**
```
cPanel → phpMyAdmin → faps_cms
```

---

**Version:** 1.0.0  
**Last Updated:** 2024  
**Status:** Ready for Production ✅

---

*Save this document for quick reference during development and deployment!*
