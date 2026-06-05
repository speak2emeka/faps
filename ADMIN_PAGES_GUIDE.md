# 🛠️ ADMIN PAGES CREATION GUIDE
## How to Create Additional Management Pages

---

## 📋 OVERVIEW

This guide shows how to create additional admin management pages following the pattern established in `/admin/manage-news.php`.

### Pages to Create:

1. **manage-events.php** - Events CRUD
2. **manage-gallery.php** - Gallery/Media CRUD
3. **manage-stem.php** - STEM Programs CRUD
4. **manage-sliders.php** - Homepage Sliders
5. **manage-downloads.php** - Downloads management
6. **manage-testimonials.php** - Testimonials CRUD
7. **view-contacts.php** - View contact submissions
8. **view-subscribers.php** - View newsletter subscribers

---

## 🔄 COMMON PATTERN

All admin pages follow this structure:

```php
<?php
// 1. Session Start & Includes
session_start();
require_once __DIR__ . '/../config.php';

// 2. Security Check
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.html');
    exit;
}

// 3. Handle CRUD Operations
$action = isset($_GET['action']) ? sanitize_input($_GET['action']) : '';

// 4. Get List of Items
$items = $pdo->query("SELECT * FROM `table_name` ORDER BY ... DESC")->fetchAll();

// 5. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate, Process, Save to Database
}

// 6. Handle Delete
if ($action === 'delete' && $id > 0) {
    // Delete from database
}
?>
<!-- HTML Interface -->
```

---

## 📚 TEMPLATE: MANAGE EVENTS

Use this template to create `/admin/manage-events.php`:

```php
<?php
/**
 * Admin: Manage Events
 * /admin/manage-events.php
 */

session_start();
require_once __DIR__ . '/../config.php';

// Check admin session
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.html');
    exit;
}

$action = isset($_GET['action']) ? sanitize_input($_GET['action']) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get all events
try {
    $events_list = $pdo->query("SELECT * FROM `events` ORDER BY `event_date` DESC")->fetchAll();
} catch (Exception $e) {
    $events_list = [];
}

// Get event to edit
$edit_event = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM `events` WHERE `id` = :id");
    $stmt->execute([':id' => $id]);
    $edit_event = $stmt->fetch();
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title'] ?? '');
    $description = $_POST['description'] ?? '';
    $event_date = sanitize_input($_POST['event_date'] ?? '');
    $location = sanitize_input($_POST['location'] ?? '');
    $category = sanitize_input($_POST['category'] ?? 'academic');
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    
    if (!$title || !$event_date) {
        $message = '<div class="alert alert-danger">Title and date are required</div>';
    } else {
        try {
            if ($action === 'edit' && $id > 0) {
                $stmt = $pdo->prepare("
                    UPDATE `events` 
                    SET `title` = :title, `description` = :description, 
                        `event_date` = :event_date, `location` = :location,
                        `category` = :category, `is_published` = :is_published
                    WHERE `id` = :id
                ");
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':event_date' => $event_date,
                    ':location' => $location,
                    ':category' => $category,
                    ':is_published' => $is_published,
                    ':id' => $id
                ]);
                $message = '<div class="alert alert-success">Event updated successfully</div>';
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO `events` 
                    (`title`, `description`, `event_date`, `location`, `category`, `is_published`)
                    VALUES (:title, :description, :event_date, :location, :category, :is_published)
                ");
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':event_date' => $event_date,
                    ':location' => $location,
                    ':category' => $category,
                    ':is_published' => $is_published
                ]);
                $message = '<div class="alert alert-success">Event created successfully</div>';
            }
            
            $events_list = $pdo->query("SELECT * FROM `events` ORDER BY `event_date` DESC")->fetchAll();
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }
}

// Handle delete
if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM `events` WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
        $message = '<div class="alert alert-success">Event deleted successfully</div>';
        $events_list = $pdo->query("SELECT * FROM `events` ORDER BY `event_date` DESC")->fetchAll();
    } catch (Exception $e) {
        $message = '<div class="alert alert-danger">Error deleting event</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Educational Excellence CMS</title>
    <link rel="stylesheet" href="../css/school.css">
    <!-- Include sidebar styles from manage-news.php -->
</head>
<body>
    <div class="admin-layout">
        <!-- Copy sidebar from manage-news.php, change active link -->
        
        <div class="main-content">
            <div class="admin-header">
                <h1><?php echo $action === 'edit' ? 'Edit Event' : 'Add Event'; ?></h1>
                <button onclick="logout()">Logout</button>
            </div>

            <div class="admin-content">
                <?php echo $message; ?>

                <?php if ($action === 'edit' || $action === 'add'): ?>
                <!-- Form -->
                <div class="form-container">
                    <form method="POST">
                        <div class="form-group">
                            <label for="title">Event Title *</label>
                            <input type="text" id="title" name="title" required 
                                   value="<?php echo $edit_event['title'] ?? ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="6"
                                      ><?php echo $edit_event['description'] ?? ''; ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="event_date">Event Date & Time *</label>
                                <input type="datetime-local" id="event_date" name="event_date" required
                                       value="<?php echo $edit_event['event_date'] ?? ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location"
                                       value="<?php echo $edit_event['location'] ?? ''; ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category">
                                    <option value="academic" <?php echo ($edit_event['category'] ?? '') === 'academic' ? 'selected' : ''; ?>>Academic</option>
                                    <option value="sports" <?php echo ($edit_event['category'] ?? '') === 'sports' ? 'selected' : ''; ?>>Sports</option>
                                    <option value="cultural" <?php echo ($edit_event['category'] ?? '') === 'cultural' ? 'selected' : ''; ?>>Cultural</option>
                                    <option value="stem" <?php echo ($edit_event['category'] ?? '') === 'stem' ? 'selected' : ''; ?>>STEM</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="is_published" name="is_published" 
                                           <?php echo ($edit_event['is_published'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="is_published" style="margin-bottom: 0;">Publish this event</label>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group" style="margin-top: 30px;">
                            <button type="submit" class="btn-submit">Save Event</button>
                            <a href="manage-events.php" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
                <?php else: ?>
                <!-- List -->
                <div style="margin-bottom: 20px;">
                    <a href="?action=add" class="btn btn-primary">+ Add New Event</a>
                </div>

                <table class="news-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events_list as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($item['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($item['location'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="status-badge <?php echo $item['is_published'] ? 'status-published' : 'status-draft'; ?>">
                                    <?php echo $item['is_published'] ? 'Published' : 'Draft'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="?action=delete&id=<?php echo $item['id']; ?>" class="btn-delete" 
                                       onclick="return confirm('Delete this event?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                fetch('../admin/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=logout'
                }).then(() => {
                    window.location.href = 'login.html';
                });
            }
        }
    </script>
</body>
</html>
```

---

## 🖼️ TEMPLATE: MANAGE GALLERY

For `/admin/manage-gallery.php`, follow the same pattern but with file upload:

```php
// Key differences for file upload:

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... other fields ...
    
    // Handle file upload
    $image_url = '';
    if (!empty($_FILES['image']['name'])) {
        $upload_result = upload_file($_FILES['image']);
        if ($upload_result['success']) {
            $image_url = $upload_result['path'];
        } else {
            $message = '<div class="alert alert-danger">' . $upload_result['error'] . '</div>';
        }
    }
    
    // Save to database with image path
    if ($image_url || $action === 'edit') {
        $stmt = $pdo->prepare("
            INSERT INTO `gallery` 
            (`title`, `media_file`, `media_type`, `category`, `is_published`)
            VALUES (:title, :media_file, :media_type, :category, :is_published)
        ");
        $stmt->execute([
            ':title' => $title,
            ':media_file' => $image_url,
            ':media_type' => 'image',
            ':category' => $category,
            ':is_published' => $is_published
        ]);
    }
}

// In form:
<div class="form-group">
    <label for="image">Upload Image *</label>
    <input type="file" id="image" name="image" accept="image/*" required>
</div>
```

---

## 📝 KEY PATTERNS

### Pattern 1: Get List
```php
$items = $pdo->query("SELECT * FROM `table` ORDER BY ... DESC")->fetchAll();
```

### Pattern 2: Check for Edit
```php
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM `table` WHERE `id` = :id");
    $stmt->execute([':id' => $id]);
    $edit_item = $stmt->fetch();
}
```

### Pattern 3: Insert/Update
```php
$stmt = $pdo->prepare("INSERT INTO `table` (...) VALUES (...)");
$stmt->execute([':field' => $value, ...]);
```

### Pattern 4: Delete
```php
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM `table` WHERE `id` = :id");
    $stmt->execute([':id' => $id]);
}
```

### Pattern 5: Form Display
```php
<?php if ($action === 'edit' || $action === 'add'): ?>
    <!-- Show form -->
<?php else: ?>
    <!-- Show list -->
<?php endif; ?>
```

---

## 🎯 QUICK CHECKLIST FOR NEW PAGES

When creating a new admin page:

- [ ] Copy entire HTML structure from manage-news.php
- [ ] Update page title and header
- [ ] Update sidebar active link
- [ ] Change database table name
- [ ] Add form fields for your data
- [ ] Update INSERT/UPDATE queries
- [ ] Update SELECT queries
- [ ] Create DELETE functionality
- [ ] Test CRUD operations
- [ ] Update sidebar navigation link

---

## 🔗 LINKING NEW PAGES

To add a new management page to the sidebar:

In `dashboard.php` (and all admin pages):

```html
<li><a href="manage-yourpage.php">🎯 Your Page Title</a></li>
```

Make sure to:
1. Create the PHP file
2. Add link in sidebar
3. Update active class when viewing that page

---

## 📊 REQUIRED FORM FIELDS BY PAGE

### manage-events.php
- Title
- Description (textarea)
- Event Date/Time (datetime-local)
- Location
- Category (select)
- Publish toggle

### manage-gallery.php
- Title
- Image (file upload)
- Category (select)
- Publish toggle

### manage-stem.php
- Title
- Program Type (select)
- Target Level (select)
- Featured Image (file upload)
- Content (textarea)
- Publish toggle

### manage-sliders.php
- Title
- Subtitle
- Image (file upload)
- Button Text
- Button Link
- Sort Order
- Active toggle

### manage-downloads.php
- Title
- File (file upload)
- Category (select)
- File Type (select)
- Available toggle

### manage-testimonials.php
- Author Name
- Position/Title
- Content (textarea)
- Rating (1-5)
- Image (file upload)
- Publish toggle

---

## 🎨 SHARED CSS CLASSES

All admin pages use these classes (from manage-news.php):

```css
.admin-layout          /* Main layout container */
.sidebar               /* Left sidebar */
.main-content          /* Right content area */
.admin-header          /* Top header */
.admin-content         /* Content padding */
.form-container        /* Form wrapper */
.form-group            /* Form field wrapper */
.form-row              /* Multi-column form row */
.btn-submit            /* Submit button */
.btn-cancel            /* Cancel button */
.news-table            /* Data table */
.status-badge          /* Status indicator */
.alert                 /* Alert messages */
.alert-success         /* Success alert */
.alert-danger          /* Error alert */
```

---

## 🚀 TESTING NEW PAGES

For each new page:

1. **Test Create**
   - Fill form
   - Click Save
   - Verify in database

2. **Test Read**
   - View list
   - Click Edit
   - Verify data loads

3. **Test Update**
   - Edit existing item
   - Change values
   - Click Save
   - Verify in database

4. **Test Delete**
   - Click Delete
   - Confirm
   - Verify removed from list

---

## 💾 DATABASE OPERATIONS REFERENCE

### Common SQL for Admin Pages

```sql
-- Get published items
SELECT * FROM `table` WHERE `is_published` = 1;

-- Get paginated items
SELECT * FROM `table` ORDER BY `created_at` DESC LIMIT 10 OFFSET 0;

-- Count items by category
SELECT COUNT(*) as count FROM `table` WHERE `category` = ?;

-- Search items
SELECT * FROM `table` WHERE `title` LIKE ? ORDER BY `created_at` DESC;

-- Get item with related data
SELECT * FROM `table` WHERE `id` = ? AND `is_published` = 1;
```

---

## 🎯 SUGGESTED ORDER TO CREATE

1. ✅ **manage-news.php** (Already created - use as template)
2. **manage-events.php** (Events - similar to news)
3. **manage-gallery.php** (Gallery - includes file upload)
4. **manage-stem.php** (STEM - with rich content)
5. **manage-sliders.php** (Sliders - drag-drop order)
6. **manage-downloads.php** (Downloads - file management)
7. **manage-testimonials.php** (Testimonials - ratings)
8. **view-contacts.php** (Contacts - view-only)
9. **view-subscribers.php** (Subscribers - list view)

---

## ⚡ TIME ESTIMATES

- manage-events.php: 20 minutes
- manage-gallery.php: 30 minutes
- manage-stem.php: 25 minutes
- manage-sliders.php: 25 minutes
- manage-downloads.php: 20 minutes
- manage-testimonials.php: 20 minutes
- view-contacts.php: 15 minutes
- view-subscribers.php: 15 minutes

**Total: ~2.5 hours to complete all 9 pages**

---

## 📚 RESOURCES

- manage-news.php - See full working example
- school.css - All styling classes
- config.php - Database functions
- database.sql - Table structure

---

**Good luck creating your admin pages! Follow the patterns and you'll have a complete CMS in no time!** 🚀
