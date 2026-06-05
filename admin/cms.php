<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.html');
    exit;
}
cms_require_database();

$modules = [
    'news' => [
        'title' => 'News and Announcements',
        'table' => 'news',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'excerpt' => ['label' => 'Excerpt', 'type' => 'textarea'],
            'content' => ['label' => 'Rich Content', 'type' => 'rich', 'required' => true],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['announcement','news','event','stem','robotics']],
            'featured_image' => ['label' => 'Featured Image', 'type' => 'file'],
            'published_date' => ['label' => 'Published Date', 'type' => 'datetime-local']
        ]
    ],
    'events' => [
        'title' => 'Events',
        'table' => 'events',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'rich'],
            'event_date' => ['label' => 'Event Date', 'type' => 'datetime-local', 'required' => true],
            'location' => ['label' => 'Location', 'type' => 'text'],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['academic','sports','cultural','stem','robotics','other']],
            'image' => ['label' => 'Image', 'type' => 'file']
        ]
    ],
    'gallery' => [
        'title' => 'Gallery Photos and Videos',
        'table' => 'gallery',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'media_type' => ['label' => 'Media Type', 'type' => 'select', 'options' => ['image','video']],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['school-life','academics','stem','robotics','sports','events','facilities']],
            'media_file' => ['label' => 'Photo or Video', 'type' => 'file', 'required' => true],
            'thumbnail' => ['label' => 'Optional Thumbnail', 'type' => 'file']
        ]
    ],
    'primary-gallery' => [
        'title' => 'Primary Gallery',
        'table' => 'gallery',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'primary'],
        'defaults' => ['school_scope' => 'primary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'media_type' => ['label' => 'Media Type', 'type' => 'select', 'options' => ['image','video']],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['school-life','academics','stem','sports','events','facilities']],
            'media_file' => ['label' => 'Primary Photo or Video', 'type' => 'file', 'required' => true],
            'thumbnail' => ['label' => 'Optional Thumbnail', 'type' => 'file']
        ]
    ],
    'secondary-gallery' => [
        'title' => 'Secondary Gallery',
        'table' => 'gallery',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'secondary'],
        'defaults' => ['school_scope' => 'secondary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'media_type' => ['label' => 'Media Type', 'type' => 'select', 'options' => ['image','video']],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['school-life','academics','stem','robotics','sports','events','facilities']],
            'media_file' => ['label' => 'Secondary Photo or Video', 'type' => 'file', 'required' => true],
            'thumbnail' => ['label' => 'Optional Thumbnail', 'type' => 'file']
        ]
    ],
    'primary-facilities' => [
        'title' => 'Primary Facilities',
        'table' => 'facilities',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'primary'],
        'defaults' => ['school_scope' => 'primary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Facility Name', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'facility_type' => ['label' => 'Facility Type', 'type' => 'select', 'options' => ['classroom','playground','library','ict','science-lab','security','transportation','sports','other']],
            'image' => ['label' => 'Facility Image', 'type' => 'file'],
            'sort_order' => ['label' => 'Sort Order', 'type' => 'number']
        ]
    ],
    'secondary-facilities' => [
        'title' => 'Secondary Facilities',
        'table' => 'facilities',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'secondary'],
        'defaults' => ['school_scope' => 'secondary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Facility Name', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'facility_type' => ['label' => 'Facility Type', 'type' => 'select', 'options' => ['classroom','library','ict','science-lab','robotics-lab','sports','leadership','security','transportation','other']],
            'image' => ['label' => 'Facility Image', 'type' => 'file'],
            'sort_order' => ['label' => 'Sort Order', 'type' => 'number']
        ]
    ],
    'primary-activities' => [
        'title' => 'Primary Activities',
        'table' => 'school_activities',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'primary'],
        'defaults' => ['school_scope' => 'primary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Activity Name', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'activity_type' => ['label' => 'Activity Type', 'type' => 'select', 'options' => ['academics','arts','sports','stem','care','events','other']],
            'image' => ['label' => 'Activity Image', 'type' => 'file'],
            'sort_order' => ['label' => 'Sort Order', 'type' => 'number']
        ]
    ],
    'secondary-activities' => [
        'title' => 'Secondary Activities',
        'table' => 'school_activities',
        'status' => 'is_published',
        'filters' => ['school_scope' => 'secondary'],
        'defaults' => ['school_scope' => 'secondary'],
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'hidden'],
            'title' => ['label' => 'Activity Name', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'activity_type' => ['label' => 'Activity Type', 'type' => 'select', 'options' => ['stem','robotics','leadership','clubs','sports','academics','events','other']],
            'image' => ['label' => 'Activity Image', 'type' => 'file'],
            'sort_order' => ['label' => 'Sort Order', 'type' => 'number']
        ]
    ],
    'stem' => [
        'title' => 'STEM and Robotics Content',
        'table' => 'stem_programs',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Short Description', 'type' => 'textarea'],
            'program_type' => ['label' => 'Program Type', 'type' => 'select', 'options' => ['coding','robotics','engineering','science-lab','competitions']],
            'target_level' => ['label' => 'Target Level', 'type' => 'select', 'options' => ['pre-nursery','nursery','primary','jss','sss','all']],
            'featured_image' => ['label' => 'Featured Image', 'type' => 'file'],
            'content' => ['label' => 'Rich Content', 'type' => 'rich']
        ]
    ],
    'sliders' => [
        'title' => 'Homepage Sliders and Banners',
        'table' => 'sliders',
        'status' => 'is_active',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'subtitle' => ['label' => 'Subtitle', 'type' => 'textarea'],
            'image' => ['label' => 'Banner Image', 'type' => 'file', 'required' => true],
            'button_text' => ['label' => 'Button Text', 'type' => 'text'],
            'button_link' => ['label' => 'Button Link', 'type' => 'text'],
            'sort_order' => ['label' => 'Sort Order', 'type' => 'number']
        ]
    ],
    'downloads' => [
        'title' => 'Downloads and Links',
        'table' => 'downloads',
        'status' => 'is_available',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'description' => ['label' => 'Description', 'type' => 'textarea'],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['admission-forms','policies','curriculum','schedules','resources','other']],
            'file_path' => ['label' => 'File Upload or URL', 'type' => 'file_or_text', 'required' => true],
            'file_type' => ['label' => 'File Type', 'type' => 'text']
        ]
    ],
    'newsletter-posts' => [
        'title' => 'Newsletter Updates',
        'table' => 'newsletter_posts',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
            'content' => ['label' => 'Rich Content', 'type' => 'rich', 'required' => true],
            'category' => ['label' => 'Category', 'type' => 'select', 'options' => ['newsletter','announcement','stem','robotics','admissions']],
            'featured_image' => ['label' => 'Featured Image', 'type' => 'file'],
            'published_date' => ['label' => 'Published Date', 'type' => 'datetime-local']
        ]
    ],
    'testimonials' => [
        'title' => 'Testimonials',
        'table' => 'testimonials',
        'status' => 'is_published',
        'fields' => [
            'school_scope' => ['label' => 'School', 'type' => 'select', 'options' => ['all','primary','secondary']],
            'name' => ['label' => 'Name', 'type' => 'text', 'required' => true],
            'position' => ['label' => 'Position', 'type' => 'text'],
            'content' => ['label' => 'Testimonial', 'type' => 'textarea', 'required' => true],
            'image' => ['label' => 'Image', 'type' => 'file'],
            'rating' => ['label' => 'Rating', 'type' => 'number']
        ]
    ]
];

$moduleKey = $_GET['module'] ?? 'events';
if (!isset($modules[$moduleKey])) {
    $moduleKey = 'events';
}
$module = $modules[$moduleKey];
$table = $module['table'];
$statusField = $module['status'];
$filters = $module['filters'] ?? [];
$defaults = $module['defaults'] ?? [];
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

function cms_slug($title) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
}

if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM `$table` WHERE `id` = :id");
    $stmt->execute([':id' => $id]);
    $message = 'Item deleted.';
    $action = '';
}

$edit = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `id` = :id");
    $stmt->execute([':id' => $id]);
    $edit = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($module['fields'] as $name => $field) {
        if (in_array($field['type'], ['file','file_or_text'], true) && isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            $upload = upload_file($_FILES[$name]);
            if ($upload['success']) {
                $data[$name] = $upload['filename'];
                continue;
            }
        }
        if ($field['type'] === 'file') {
            if ($edit && !empty($edit[$name])) $data[$name] = $edit[$name];
            continue;
        }
        $data[$name] = $field['type'] === 'rich' ? ($_POST[$name] ?? '') : sanitize_input($_POST[$name] ?? ($defaults[$name] ?? ''));
    }
    foreach ($defaults as $key => $value) {
        $data[$key] = $value;
    }
    $data[$statusField] = isset($_POST[$statusField]) ? 1 : 0;
    foreach ($module['fields'] as $name => $field) {
        if ($field['type'] === 'datetime-local') {
            $data[$name] = $data[$name] ? str_replace('T', ' ', $data[$name]) : null;
        }
    }
    if (isset($module['fields']['title']) && in_array($table, ['news','events','stem_programs'], true)) {
        $data['slug'] = cms_slug($data['title'] ?? ('item-' . time()));
    }
    if ($table === 'news' && empty($data['published_date']) && !empty($data[$statusField])) {
        $data['published_date'] = date('Y-m-d H:i:s');
    }
    if ($action === 'edit' && $id > 0) {
        $assignments = array_map(fn($key) => "`$key` = :$key", array_keys($data));
        $stmt = $pdo->prepare("UPDATE `$table` SET " . implode(', ', $assignments) . " WHERE `id` = :id");
        $data['id'] = $id;
        $stmt->execute($data);
        $message = 'Item updated.';
    } else {
        $columns = array_keys($data);
        $stmt = $pdo->prepare("INSERT INTO `$table` (`" . implode('`,`', $columns) . "`) VALUES (:" . implode(',:', $columns) . ")");
        $stmt->execute($data);
        $message = 'Item created.';
    }
    $action = '';
    $edit = null;
}

$where = [];
$params = [];
foreach ($filters as $key => $value) {
    $where[] = "`$key` = :filter_$key";
    $params[":filter_$key"] = $value;
}
$query = "SELECT * FROM `$table`";
if ($where) {
    $query .= " WHERE " . implode(' AND ', $where);
}
$query .= " ORDER BY " . (isset($module['fields']['sort_order']) ? "`sort_order` ASC, " : "") . "`id` DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$items = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($module['title']); ?> CMS</title>
  <link rel="stylesheet" href="../css/school.css">
</head>
<body>
<div class="admin-layout">
  <aside class="admin-sidebar">
    <a class="brand" href="dashboard.php"><span class="brand-mark">FR</span><span><strong>School CMS</strong><span>Admin Dashboard</span></span></a>
    <nav class="admin-nav">
      <a href="dashboard.php">Dashboard</a>
      <a class="<?php echo $moduleKey === 'news' ? 'active' : ''; ?>" href="manage-news.php">News and Announcements</a>
      <a class="<?php echo $moduleKey === 'events' ? 'active' : ''; ?>" href="manage-events.php">Events</a>
      <a class="<?php echo $moduleKey === 'gallery' ? 'active' : ''; ?>" href="manage-gallery.php">Gallery</a>
      <a class="<?php echo $moduleKey === 'primary-gallery' ? 'active' : ''; ?>" href="manage-primary-gallery.php">Primary Gallery</a>
      <a class="<?php echo $moduleKey === 'secondary-gallery' ? 'active' : ''; ?>" href="manage-secondary-gallery.php">Secondary Gallery</a>
      <a class="<?php echo $moduleKey === 'primary-facilities' ? 'active' : ''; ?>" href="manage-primary-facilities.php">Primary Facilities</a>
      <a class="<?php echo $moduleKey === 'secondary-facilities' ? 'active' : ''; ?>" href="manage-secondary-facilities.php">Secondary Facilities</a>
      <a class="<?php echo $moduleKey === 'primary-activities' ? 'active' : ''; ?>" href="manage-primary-activities.php">Primary Activities</a>
      <a class="<?php echo $moduleKey === 'secondary-activities' ? 'active' : ''; ?>" href="manage-secondary-activities.php">Secondary Activities</a>
      <a class="<?php echo $moduleKey === 'stem' ? 'active' : ''; ?>" href="manage-stem.php">STEM and Robotics</a>
      <a class="<?php echo $moduleKey === 'sliders' ? 'active' : ''; ?>" href="manage-sliders.php">Homepage Sliders</a>
      <a class="<?php echo $moduleKey === 'downloads' ? 'active' : ''; ?>" href="manage-downloads.php">Downloads and Links</a>
      <a class="<?php echo $moduleKey === 'newsletter-posts' ? 'active' : ''; ?>" href="manage-newsletter.php">Newsletter Updates</a>
      <a class="<?php echo $moduleKey === 'testimonials' ? 'active' : ''; ?>" href="manage-testimonials.php">Testimonials</a>
      <a href="#" onclick="logout()">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-top">
      <div><span class="eyebrow">Content Management</span><h1><?php echo htmlspecialchars($module['title']); ?></h1></div>
      <a class="btn secondary" href="?module=<?php echo $moduleKey; ?>&action=add">Add New</a>
    </div>
    <div class="admin-content">
      <?php if ($message): ?><div class="message"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
      <?php if ($action === 'add' || $action === 'edit'): ?>
      <form class="card pad form-grid" method="post" enctype="multipart/form-data">
        <?php foreach ($module['fields'] as $name => $field): $value = $edit[$name] ?? ''; ?>
          <?php if ($field['type'] === 'hidden'): ?>
            <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo htmlspecialchars($value ?: ($defaults[$name] ?? '')); ?>">
            <?php continue; ?>
          <?php endif; ?>
          <div class="form-field <?php echo in_array($field['type'], ['textarea','rich'], true) ? 'full' : ''; ?>">
            <label for="<?php echo $name; ?>"><?php echo htmlspecialchars($field['label']); ?></label>
            <?php if ($field['type'] === 'select'): ?>
              <select id="<?php echo $name; ?>" name="<?php echo $name; ?>"><?php foreach ($field['options'] as $option): ?><option value="<?php echo $option; ?>" <?php echo $value === $option ? 'selected' : ''; ?>><?php echo ucwords(str_replace('-', ' ', $option)); ?></option><?php endforeach; ?></select>
            <?php elseif ($field['type'] === 'textarea' || $field['type'] === 'rich'): ?>
              <textarea id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo !empty($field['required']) ? 'required' : ''; ?>><?php echo htmlspecialchars($value); ?></textarea>
            <?php elseif ($field['type'] === 'file'): ?>
              <input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="file" <?php echo (!$edit && !empty($field['required'])) ? 'required' : ''; ?>>
              <?php if ($value): ?><small>Current: <?php echo htmlspecialchars($value); ?></small><?php endif; ?>
            <?php elseif ($field['type'] === 'file_or_text'): ?>
              <input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="file">
              <input class="input" name="<?php echo $name; ?>" value="<?php echo htmlspecialchars($value); ?>" placeholder="Or paste a URL">
            <?php else: ?>
              <input class="input" id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="<?php echo $field['type']; ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo !empty($field['required']) ? 'required' : ''; ?>>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <div class="form-field full"><label><input type="checkbox" name="<?php echo $statusField; ?>" <?php echo ($edit[$statusField] ?? 1) ? 'checked' : ''; ?>> Published / Active</label></div>
        <div class="form-field full button-row"><button class="btn secondary" type="submit">Save</button><a class="btn ghost" href="?module=<?php echo $moduleKey; ?>">Cancel</a></div>
      </form>
      <?php endif; ?>
      <div class="table-wrap admin-table"><table><thead><tr><th>Title</th><th>School</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead><tbody>
      <?php foreach ($items as $item): ?>
        <tr><td><?php echo htmlspecialchars($item['title'] ?? $item['name'] ?? ('Item #' . $item['id'])); ?></td><td><?php echo htmlspecialchars(ucwords($item['school_scope'] ?? 'all')); ?></td><td><?php echo htmlspecialchars($item['category'] ?? $item['program_type'] ?? $item['facility_type'] ?? $item['activity_type'] ?? ''); ?></td><td><span class="status <?php echo empty($item[$statusField]) ? 'draft' : ''; ?>"><?php echo empty($item[$statusField]) ? 'Draft' : 'Published'; ?></span></td><td><a href="?module=<?php echo $moduleKey; ?>&action=edit&id=<?php echo $item['id']; ?>">Edit</a> | <a href="?module=<?php echo $moduleKey; ?>&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Delete this item?')">Delete</a></td></tr>
      <?php endforeach; ?>
      </tbody></table></div>
    </div>
  </main>
</div>
<script>function logout(){fetch("auth.php",{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:"action=logout"}).then(()=>location.href="login.html")}</script>
</body>
</html>
