<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.html');
    exit;
}

$stats = [
    'News' => 0,
    'Events' => 0,
    'Gallery Items' => 0,
    'Subscribers' => 0,
    'Primary Facilities' => 0,
    'Secondary Facilities' => 0,
    'Primary Activities' => 0,
    'Secondary Activities' => 0,
];

if ($pdo) {
    try {
        $stats['News'] = (int)$pdo->query("SELECT COUNT(*) FROM `news` WHERE `is_published` = TRUE")->fetchColumn();
        $stats['Events'] = (int)$pdo->query("SELECT COUNT(*) FROM `events` WHERE `is_published` = TRUE")->fetchColumn();
        $stats['Gallery Items'] = (int)$pdo->query("SELECT COUNT(*) FROM `gallery` WHERE `is_published` = TRUE")->fetchColumn();
        $stats['Subscribers'] = (int)$pdo->query("SELECT COUNT(*) FROM `newsletter_subscribers` WHERE `is_active` = TRUE")->fetchColumn();
        $stats['Primary Facilities'] = (int)$pdo->query("SELECT COUNT(*) FROM `facilities` WHERE `school_scope` = 'primary' AND `is_published` = TRUE")->fetchColumn();
        $stats['Secondary Facilities'] = (int)$pdo->query("SELECT COUNT(*) FROM `facilities` WHERE `school_scope` = 'secondary' AND `is_published` = TRUE")->fetchColumn();
        $stats['Primary Activities'] = (int)$pdo->query("SELECT COUNT(*) FROM `school_activities` WHERE `school_scope` = 'primary' AND `is_published` = TRUE")->fetchColumn();
        $stats['Secondary Activities'] = (int)$pdo->query("SELECT COUNT(*) FROM `school_activities` WHERE `school_scope` = 'secondary' AND `is_published` = TRUE")->fetchColumn();
    } catch (Exception $e) {
        // Counts remain zero until the migration has been run.
    }
}

$actions = [
    ['Primary Activities', 'manage-primary-activities.php', 'Manage FAPS pictures and activities.'],
    ['Secondary Activities', 'manage-secondary-activities.php', 'Manage Royal Prestige pictures and activities.'],
    ['Primary Facilities', 'manage-primary-facilities.php', 'Manage FAPS facility pictures.'],
    ['Secondary Facilities', 'manage-secondary-facilities.php', 'Manage Royal Prestige facility pictures.'],
    ['Primary Gallery', 'manage-primary-gallery.php', 'Upload FAPS photos and videos.'],
    ['Secondary Gallery', 'manage-secondary-gallery.php', 'Upload Royal Prestige photos and videos.'],
    ['News and Announcements', 'manage-news.php', 'Publish school updates by school scope.'],
    ['Homepage Sliders', 'manage-sliders.php', 'Manage banners for all, primary, or secondary.'],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - FAPS and Royal Prestige CMS</title>
  <link rel="stylesheet" href="../css/school.css">
</head>
<body>
<div class="admin-layout">
  <aside class="admin-sidebar">
    <a class="brand" href="dashboard.php"><span class="brand-mark">FR</span><span><strong>School CMS</strong><span>Primary and Secondary Admin</span></span></a>
    <nav class="admin-nav">
      <a class="active" href="dashboard.php">Dashboard</a>
      <a href="manage-primary-activities.php">Primary Activities</a>
      <a href="manage-secondary-activities.php">Secondary Activities</a>
      <a href="manage-primary-facilities.php">Primary Facilities</a>
      <a href="manage-secondary-facilities.php">Secondary Facilities</a>
      <a href="manage-primary-gallery.php">Primary Gallery</a>
      <a href="manage-secondary-gallery.php">Secondary Gallery</a>
      <a href="manage-news.php">News and Announcements</a>
      <a href="manage-events.php">Events</a>
      <a href="manage-stem.php">STEM and Robotics</a>
      <a href="manage-downloads.php">Downloads and Links</a>
      <a href="manage-newsletter.php">Newsletter Updates</a>
      <a href="manage-testimonials.php">Testimonials</a>
      <a href="#" onclick="logout()">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-top">
      <div>
        <span class="eyebrow">Admin Dashboard</span>
        <h1>FAPS and Royal Prestige CMS</h1>
        <p style="margin:0;color:#627084">Signed in as <?php echo htmlspecialchars($_SESSION['admin_username']); ?> (<?php echo htmlspecialchars(ucwords($_SESSION['admin_school_scope'] ?? 'all')); ?>)</p>
      </div>
      <a class="btn secondary" href="../public/index.html">View Website</a>
    </div>
    <div class="admin-content">
      <?php if (!$pdo): ?>
        <div class="message">Database is not connected. Import db/database.sql or run db/migration_sync_school_updates.sql on an existing database, then update config.php.</div>
      <?php endif; ?>
      <div class="grid four">
        <?php foreach ($stats as $label => $count): ?>
          <article class="card pad">
            <span class="eyebrow"><?php echo htmlspecialchars($label); ?></span>
            <h2><?php echo (int)$count; ?></h2>
          </article>
        <?php endforeach; ?>
      </div>
      <section class="section" style="padding-bottom:0">
        <span class="eyebrow">Quick Actions</span>
        <h2>Manage the updated school sections</h2>
        <div class="grid four">
          <?php foreach ($actions as $action): ?>
            <a class="card pad" href="<?php echo htmlspecialchars($action[1]); ?>">
              <h3><?php echo htmlspecialchars($action[0]); ?></h3>
              <p><?php echo htmlspecialchars($action[2]); ?></p>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </main>
</div>
<script>
function logout() {
  fetch('auth.php', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: 'action=logout' })
    .then(() => location.href = 'login.html');
}
</script>
</body>
</html>
