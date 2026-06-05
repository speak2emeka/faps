# Educational Excellence - School Website & CMS

A complete, modern, responsive school website with integrated content management system for a unified institution offering education from Pre-Nursery to Senior Secondary with emphasis on STEM and Robotics.

## 🎓 Features

### Website Features
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- **Modern UI** - Clean, professional interface using school colors (Blue, Gold, White)
- **Dynamic Content** - All content pulled from database via API
- **WhatsApp Integration** - Floating WhatsApp button for instant chat
- **Photo Gallery** - Dynamic gallery with lightbox viewer
- **Event Calendar** - Upcoming events from database
- **Newsletter Signup** - Email subscription system
- **Contact Form** - Integrated contact form with database storage

### CMS Features
- **News Management** - Create, edit, delete news and announcements
- **Event Management** - Manage school events and calendar
- **Gallery Management** - Upload and organize photos and videos
- **STEM Programs** - Dedicated STEM and Robotics content management
- **Homepage Sliders** - Manage hero section sliders
- **Document Downloads** - Manage downloadable files and forms
- **Testimonials** - Student and parent testimonials
- **Newsletter Subscribers** - Manage email subscribers
- **Contact Submissions** - View and manage contact form submissions
- **User Management** - Create and manage admin users (extensible)

### Technical Features
- **PHP Backend** - Robust server-side processing
- **MySQL Database** - Reliable data storage with proper schema
- **RESTful API** - Clean API endpoints for frontend
- **Secure Authentication** - Session-based admin login
- **File Upload** - Image and document upload with validation
- **Rich Text Editor** - TinyMCE integration for content editing
- **Responsive Admin Panel** - Mobile-friendly admin interface

## 📁 Project Structure

```
FAPS/
├── config.php                 # Global configuration & database connection
├── index.html                 # Old homepage (backup)
├── db/
│   └── database.sql          # MySQL database schema & sample data
├── api/                       # RESTful API endpoints
│   ├── news.php              # News/announcements API
│   ├── events.php            # Events API
│   ├── gallery.php           # Gallery API
│   ├── stem.php              # STEM programs API
│   ├── sliders.php           # Homepage sliders API
│   ├── contact.php           # Contact form submission
│   └── newsletter.php        # Newsletter subscription
├── admin/                     # Admin CMS interface
│   ├── login.html            # Admin login page
│   ├── auth.php              # Authentication handler
│   ├── dashboard.php         # Admin dashboard
│   ├── manage-news.php       # News management
│   ├── manage-events.php     # Events management
│   ├── manage-gallery.php    # Gallery management
│   ├── manage-stem.php       # STEM programs management
│   ├── manage-sliders.php    # Slider management
│   ├── manage-downloads.php  # Download management
│   ├── manage-testimonials.php # Testimonials management
│   ├── view-contacts.php     # Contact submissions viewer
│   └── view-subscribers.php  # Subscribers viewer
├── public/
│   ├── index.html            # Modern homepage
│   ├── about.html            # About Us page
│   ├── academics.html        # Academics & Programs page
│   ├── admissions.html       # Admissions page
│   ├── school-life.html      # School life & activities
│   ├── facilities.html       # Facilities page
│   ├── news.html             # News & updates page
│   ├── gallery.html          # Photo & video gallery
│   └── contact.html          # Contact page
├── css/
│   ├── school.css            # Unified theme & components
│   └── (existing Bootstrap, fonts, etc.)
├── js/
│   ├── school.js             # Common functionality & API client
│   └── (existing jQuery, etc.)
└── assets/
    └── uploads/              # User-uploaded files

```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.2+ (or higher)
- MySQL 5.7+ (or MariaDB)
- Web Server (Apache/Nginx)
- cPanel/FTP access for shared hosting

### Local Setup

1. **Clone or Download the Project**
   ```bash
   cd /your/web/root/path
   ```

2. **Create Database**
   - Open your MySQL admin (phpMyAdmin)
   - Create new database: `faps_cms`
   - Import SQL schema:
     - Open `/db/database.sql`
     - Copy all content and execute in phpMyAdmin
   - This creates all tables and inserts default admin user

3. **Update Configuration**
   - Edit `config.php`
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'faps_cms');
     ```
   - Update site URL:
     ```php
     define('SITE_URL', 'http://yourdomain.com/path-to-faps/');
     ```
   - Update school contact info
   - Update WhatsApp number

4. **Set Permissions**
   - Make `/assets/uploads/` writable:
     ```bash
     chmod 755 assets/uploads/
     ```

5. **Access Website & Admin**
   - Website: `http://yourdomain.com/path-to-faps/public/`
   - Admin: `http://yourdomain.com/path-to-faps/admin/login.html`

### Production Deployment (cPanel)

1. **Upload Files via FTP**
   - Connect to your cPanel FTP
   - Upload all files to public_html or subdomain

2. **Create Database in cPanel**
   - Go to MySQL Databases
   - Create database (cPanel prefixes with username)
   - Create user with all privileges
   - Note the credentials

3. **Import Database Schema**
   - Use phpMyAdmin in cPanel
   - Select your database
   - Go to Import tab
   - Upload `/db/database.sql`
   - Click Import

4. **Update config.php with cPanel Credentials**
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'username_dbuser');
   define('DB_PASS', 'database_password');
   define('DB_NAME', 'username_faps_cms');
   ```

5. **Set File Permissions**
   - `/assets/uploads/` - 755
   - `/admin/` - 755

6. **Update .htaccess (if needed)**
   - Create/update `.htaccess` for pretty URLs

## 🔐 Admin Access

### Default Credentials
- **Username:** admin
- **Password:** admin123

**⚠️ IMPORTANT:** Change these immediately in production!

To change password in database:
```sql
UPDATE `users` SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE `username` = 'admin';
```
(Generate bcrypt hash online if needed)

### Admin Features

**Dashboard**
- View statistics and quick actions
- Access all management modules

**News Management**
- Create/edit/delete news articles
- Set publication status
- Add categories and featured images
- Rich text editor for content

**Event Management**
- Add upcoming events
- Set date, time, location
- Categorize events
- Upload event images

**Gallery Management**
- Upload photos and videos
- Organize by category
- Add titles and descriptions
- Auto-generate thumbnails

**STEM Programs Management**
- Add STEM and Robotics programs
- Target specific grade levels
- Upload program images
- Rich content editing

**Homepage Sliders**
- Manage hero section slides
- Add images, text, CTA buttons
- Control slide order
- Activate/deactivate slides

**Downloads Management**
- Upload and manage documents
- Organize by category
- Track download counts
- Make files available/unavailable

**Testimonials**
- Add student and parent testimonials
- Upload profile images
- Set star ratings
- Publish/unpublish

**View Submissions**
- Contact form messages
- Newsletter subscribers
- Manage responses

## 🌐 Website Pages

### Homepage (`/public/index.html`)
- Hero slider (from database)
- School introduction
- Statistics
- Featured news
- STEM highlights
- Upcoming events
- Testimonials
- Gallery preview
- Newsletter signup
- WhatsApp button
- Footer with contact info

### Other Main Pages (To be Created)
- **About Us** - School history, mission, vision, values
- **Academics** - Grade levels, curriculum, STEM focus
- **Admissions** - Application process, requirements, forms
- **School Life** - Clubs, sports, activities, events
- **Facilities** - Labs, classrooms, playgrounds, security
- **News & Updates** - Dynamic news list with filtering
- **Gallery** - Full photo and video gallery with lightbox
- **Contact** - Contact form, map, location info

## 📱 WhatsApp Integration

The website includes a floating WhatsApp button that:
- Appears on all pages
- Opens WhatsApp chat with customizable message
- Works on mobile and desktop
- Smooth hover animations
- Fixed position, always visible

**Configure in `/js/school.js`:**
```javascript
const whatsappPhone = '+2341234567890';
const whatsappMessage = 'Hello! I\'d like to know more about Educational Excellence.';
```

## 🎨 Customization

### Colors
Edit CSS variables in `/css/school.css`:
```css
:root {
    --primary-blue: #1B4D7D;
    --primary-gold: #D4AF37;
    --primary-white: #FFFFFF;
    /* ... other colors ... */
}
```

### Typography
- Font Family: Roboto (Google Fonts)
- Main sizes: 16px, 20px, 24px, 32px, 40px

### Branding
- Update logo in header navigation
- Change "Educational Excellence" throughout
- Update favicon
- Update school contact info

## 🔌 API Endpoints

All endpoints return JSON:

```
GET  /api/news.php?category=news&page=1&limit=10
GET  /api/events.php?upcoming=1&category=academic
GET  /api/gallery.php?category=school-life&type=image&page=1
GET  /api/stem.php?type=robotics&level=sss
GET  /api/sliders.php
POST /api/contact.php (form submission)
POST /api/newsletter.php (email subscription)
```

## 📊 Database Schema

### Tables
- `users` - Admin users
- `news` - News and announcements
- `events` - School events
- `gallery` - Photos and videos
- `stem_programs` - STEM and Robotics programs
- `sliders` - Homepage sliders
- `downloads` - Downloadable files
- `testimonials` - Student/parent testimonials
- `newsletter_subscribers` - Email subscribers
- `contact_submissions` - Contact form submissions

## 🔧 Maintenance

### Regular Tasks
- Back up database monthly
- Review contact submissions
- Update news and events
- Monitor gallery storage
- Update testimonials

### Performance Tips
- Optimize images before upload (max 2MB)
- Use categories to organize content
- Regularly delete old unpublished content
- Clean up failed uploads

## ⚠️ Security Notes

1. **Change default admin password immediately**
2. **Use HTTPS** (SSL certificate) on production
3. **Keep PHP updated** to latest version
4. **Backup database regularly**
5. **Restrict admin folder** via .htaccess if needed
6. **Validate all user inputs** (already implemented)
7. **Use strong database password**

### .htaccess Example (Optional)
```apache
<FilesMatch "\.php$">
    Require all granted
</FilesMatch>

# Protect config
<Files "config.php">
    Require all denied
</Files>

# Protect API (optional)
<Directory "/api">
    Require all denied
</Directory>
```

## 🐛 Troubleshooting

### White Blank Page
- Check PHP error logs
- Verify database connection in config.php
- Check file permissions (755)
- Ensure MySQL server is running

### Can't Login
- Verify database has default admin user
- Check session.save_path permissions
- Clear browser cookies
- Try incognito mode

### Upload Not Working
- Check `/assets/uploads/` permissions (755)
- Verify max_upload_size in php.ini
- Check file type restrictions
- Free up disk space

### API Not Returning Data
- Verify database has published content
- Check if content meets publish criteria
- Test API directly: `/api/news.php`
- Check browser console for errors

## 📝 Additional Notes

- The system uses PDO prepared statements for SQL injection protection
- All user input is sanitized using `sanitize_input()` function
- File uploads are validated by type and size
- Responsive design follows mobile-first approach
- Admin panel is fully responsive for tablet/mobile management

## 🤝 Support & Updates

For updates or issues:
1. Check database structure matches schema
2. Verify PHP version compatibility
3. Ensure MySQL server is accessible
4. Review error logs
5. Test with demo data

## 📄 License

This project is for Educational Excellence - FAPS & Royal Prestige Leadership Academy.

---

**Last Updated:** 2024
**Version:** 1.0.0
