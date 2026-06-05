# DEPLOYMENT & QUICK START GUIDE
## Educational Excellence School Website & CMS

---

## ⚡ QUICK START (5 Minutes)

### If You Have phpMyAdmin Access:

1. **Import Database**
   - Open phpMyAdmin
   - Create database: `faps_cms`
   - Go to Import tab
   - Select `/db/database.sql` file
   - Click Import ✓

2. **Update config.php**
   - Open `/config.php`
   - Find database section (lines 7-10)
   - Update with your database details:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'faps_cms');
     ```

3. **Test It**
   - Website: `http://yourdomain.com/FAPS/public/index.html`
   - Admin: `http://yourdomain.com/FAPS/admin/login.html`
   - Login: admin / admin123

4. **Important: Change Password**
   - Log in to admin
   - Change admin password in database immediately

---

## 📋 DETAILED SETUP STEPS

### Step 1: Upload Files to Server

**Via FTP:**
```
Connect to: ftp.yourdomain.com
Username: your_ftp_username
Upload folder: public_html/FAPS/
(or your desired path)
```

**Folder structure after upload:**
```
public_html/
└── FAPS/
    ├── config.php
    ├── api/
    ├── admin/
    ├── public/
    ├── css/
    ├── js/
    ├── db/
    └── README.md
```

### Step 2: Create Database

**In cPanel:**
1. Go to MySQL Databases
2. Database name: `yourusername_faps_cms`
3. MySQL user: `yourusername_fapsadmin`
4. Password: (create strong password)
5. Add user to database with ALL privileges

**Note:** cPanel prepends your username to database names

### Step 3: Import Database Schema

**Via phpMyAdmin:**
1. Select your database
2. Click "Import" tab
3. Choose File: `/db/database.sql`
4. Click "Go"
5. Wait for success message

**Result:** All tables created with sample data

### Step 4: Update Configuration

**Edit `/config.php`** (lines 5-10):

```php
// Change these to your actual cPanel credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'yourusername_fapsadmin');  // Your cPanel user_
define('DB_PASS', 'strong_password_here');    // The password you created
define('DB_NAME', 'yourusername_faps_cms');   // With cPanel prefix
```

**Update Site URL** (line 11):
```php
define('SITE_URL', 'https://yourdomain.com/FAPS/');
// or for subdomain:
define('SITE_URL', 'https://school.yourdomain.com/');
```

**Update School Info** (lines 23-27):
```php
define('SCHOOL_EMAIL', 'admin@yourdomain.edu');
define('SCHOOL_PHONE', '+234 XXX XXX XXXX');
define('SCHOOL_ADDRESS', 'Your Address Here');
define('WHATSAPP_NUMBER', '234XXXXXXXXX');
define('WHATSAPP_MESSAGE', 'Custom message');
```

### Step 5: Set File Permissions

**Via cPanel File Manager or FTP:**

```
/FAPS/assets/uploads/ → 755 (Writable)
/FAPS/admin/         → 755
/FAPS/api/           → 755
```

**Or via SSH (if available):**
```bash
chmod -R 755 /home/username/public_html/FAPS/assets/uploads/
chmod -R 755 /home/username/public_html/FAPS/admin/
chmod -R 755 /home/username/public_html/FAPS/api/
```

### Step 6: Enable HTTPS (Highly Recommended)

1. Go to cPanel → SSL/TLS
2. Install Free SSL Certificate (AutoSSL)
3. Update `config.php` SITE_URL to use `https://`

### Step 7: Test Everything

✅ **Homepage:** `https://yourdomain.com/FAPS/public/`
- Should load with school info, news, events

✅ **Admin Login:** `https://yourdomain.com/FAPS/admin/login.html`
- Default: admin / admin123
- Should see dashboard with statistics

✅ **Test API:** `https://yourdomain.com/FAPS/api/news.php`
- Should return JSON data

---

## 🔑 DEFAULT LOGIN CREDENTIALS

```
Username: admin
Password: admin123
```

⚠️ **CHANGE IMMEDIATELY IN PRODUCTION**

### To Change Admin Password:

**Via phpMyAdmin:**
1. Go to `faps_cms` database
2. Select `users` table
3. Edit admin user
4. Update password (note: uses bcrypt hash)

**Or manually update:**
```sql
UPDATE `users` SET `password` = MD5('yournewpassword')
WHERE `username` = 'admin';
```

---

## 📱 ACCESSING YOUR WEBSITE

### Public Website
```
https://yourdomain.com/FAPS/public/
```

**Available Pages:**
- Homepage (`index.html`)
- About (`about.html`)
- Academics (`academics.html`)
- Admissions (`admissions.html`)
- News (`news.html`)
- Gallery (`gallery.html`)
- Contact (`contact.html`)

### Admin Dashboard
```
https://yourdomain.com/FAPS/admin/login.html
```

**Management Modules:**
- Dashboard (Overview & statistics)
- News Management
- Event Management
- Gallery Management
- STEM Programs
- Homepage Sliders
- Downloads
- Testimonials
- Contact Messages
- Newsletter Subscribers

---

## 🎨 CUSTOMIZATION

### Change School Name & Branding

**In `/config.php`:**
```php
define('SITE_NAME', 'Your School Name');
define('SCHOOL_EMAIL', 'contact@yourschool.edu');
define('SCHOOL_PHONE', '+234 XXX XXX XXXX');
```

**In CSS colors (`/css/school.css`):**
```css
:root {
    --primary-blue: #1B4D7D;    /* School primary color */
    --primary-gold: #D4AF37;    /* School accent color */
    --primary-white: #FFFFFF;
}
```

### Update WhatsApp Number

**In `/js/school.js` (line ~25):**
```javascript
const whatsappPhone = '+2341234567890';  // Your WhatsApp number
const whatsappMessage = 'Custom message'; // Your greeting
```

### Change Homepage Logo

Edit header in `/public/index.html`:
```html
<div class="logo">Your <span>School Name</span></div>
```

---

## 🐛 TROUBLESHOOTING

### Problem: White Blank Page

**Solution:**
1. Check PHP version (should be 7.2+)
2. Enable PHP error logging:
   - In cPanel: PHP Configuration
   - Set `display_errors = On`
   - Check error log

### Problem: Can't Connect to Database

**Solution:**
1. Verify credentials in `config.php`
2. Check if MySQL is running (cPanel → MySQL)
3. Verify username/password in phpmyadmin
4. Ensure database name is correct (includes cPanel prefix)

### Problem: Can't Upload Files

**Solution:**
1. Check `/assets/uploads/` permissions (755)
2. Check disk space available
3. Verify max_upload_size in PHP:
   - cPanel → PHP Configuration
   - Check `upload_max_filesize` (recommended: 32M+)
   - Check `post_max_size` (recommended: 48M+)

### Problem: Admin Login Not Working

**Solution:**
1. Clear browser cookies/cache
2. Try in Incognito/Private mode
3. Check if MySQL server is running
4. Verify database has `users` table:
   ```sql
   SELECT * FROM `users` WHERE `username` = 'admin';
   ```

### Problem: API Returning No Data

**Solution:**
1. Check if content is published (is_published = 1)
2. Test directly: `https://yourdomain.com/FAPS/api/news.php`
3. Check browser console for errors (F12)
4. Verify database connection in config.php

---

## 📊 DATABASE STRUCTURE OVERVIEW

**Key Tables:**

| Table | Purpose |
|-------|---------|
| `users` | Admin accounts |
| `news` | News & announcements |
| `events` | School events |
| `gallery` | Photos & videos |
| `stem_programs` | STEM programs |
| `sliders` | Homepage sliders |
| `downloads` | Downloadable files |
| `testimonials` | Student/parent testimonials |
| `newsletter_subscribers` | Email subscribers |
| `contact_submissions` | Contact form messages |

---

## 🔐 SECURITY CHECKLIST

- [ ] Changed default admin password
- [ ] Updated database credentials in config.php
- [ ] Set file permissions (755 for uploads)
- [ ] Enabled HTTPS/SSL certificate
- [ ] Backed up database regularly
- [ ] Updated PHP to latest version
- [ ] Set up automatic backups
- [ ] Disabled admin folder indexing (optional .htaccess)
- [ ] Regular security updates

---

## 💾 BACKUP & MAINTENANCE

### Backup Database (Weekly)

**Via phpMyAdmin:**
1. Select database: `faps_cms`
2. Click Export
3. Format: SQL
4. Download file
5. Store safely

**Or via command line:**
```bash
mysqldump -u username -p databasename > backup.sql
```

### Regular Maintenance Tasks

- [ ] Weekly: Backup database
- [ ] Monthly: Review admin logs
- [ ] Monthly: Check disk space
- [ ] Quarterly: Update PHP/MySQL
- [ ] Quarterly: Security audit
- [ ] Annually: Review SSL certificate

---

## 📧 EMAIL SETUP (Optional)

To enable automated emails (contact form notifications):

**In `/api/contact.php` (line ~45):**
```php
// Uncomment this line:
mail(SCHOOL_EMAIL, "New Contact Form: $subject", "From: $name ($email)\n\n$message");
```

**Or use SMTP (more reliable):**
Configure PHPMailer in config.php:
```php
$mail = new PHPMailer(true);
$mail->Host = 'your-smtp-server.com';
$mail->Username = 'your-email@domain.com';
$mail->Password = 'smtp-password';
```

---

## 🎓 NEXT STEPS AFTER SETUP

1. ✅ **Test all pages** - Visit each page, check links
2. ✅ **Add school content** - News, events, photos
3. ✅ **Set up newsletter** - Configure email system
4. ✅ **Add testimonials** - From students/parents
5. ✅ **Promote WhatsApp** - Add number to social media
6. ✅ **SEO optimization** - Add meta tags, descriptions
7. ✅ **Mobile testing** - Test on phones/tablets
8. ✅ **Performance tuning** - Optimize images, cache

---

## 📞 SUPPORT

**Common Issues:**
- Database not connecting → Check credentials in config.php
- Can't upload → Check permissions on /assets/uploads/
- Admin not loading → Clear cache, try incognito mode
- API not working → Check if MySQL server is running

**Documentation:**
- See `/README.md` for full documentation
- Check database.sql for table structure
- API endpoints documented in README

---

## 🎉 INSTALLATION COMPLETE!

Your Educational Excellence website is now ready to use!

**Access Points:**
- Public Website: `https://yourdomain.com/FAPS/public/`
- Admin Panel: `https://yourdomain.com/FAPS/admin/login.html`

**Next:** Start adding your school content through the admin panel!

---

**Version:** 1.0.0  
**Last Updated:** 2024  
**Support:** See README.md for detailed documentation
