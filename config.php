<?php
/**
 * Educational Excellence - School Website CMS
 * Configuration File
 * Database connection and global settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Change to your cPanel username
define('DB_PASS', '');      // Change to your cPanel password
define('DB_NAME', 'faps_cms');

// Site Configuration
define('SITE_NAME', 'FAPS and Royal Prestige Leadership Academy');
define('SITE_URL', 'http://localhost/genius-master/FAPS/'); // Change to your domain
define('ADMIN_URL', SITE_URL . 'admin/');
define('API_URL', SITE_URL . 'api/');

// Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'mp4', 'webm']);

// CMS Configuration
define('CMS_VERSION', '1.0.0');
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123'); // Change this in production!
define('SESSION_TIMEOUT', 3600); // 1 hour

// School Information
define('SCHOOL_EMAIL', 'info@fapsroyalprestige.edu.ng');
define('SCHOOL_PHONE', '+234 123 456 7890');
define('SCHOOL_ADDRESS', 'School Campus, Nigeria');
define('WHATSAPP_NUMBER', '2341234567890');
define('WHATSAPP_MESSAGE', 'Hello FAPS and Royal Prestige Leadership Academy. I would like to make an enquiry.');

// Database Connection
$pdo = null;
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    $pdo = null;
}

// Helper Functions
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function upload_file($file) {
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validate
    if ($file_size > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File too large'];
    }
    
    if (!in_array($file_ext, ALLOWED_TYPES)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    // Generate unique name
    $new_name = uniqid() . '.' . $file_ext;
    $upload_path = UPLOAD_DIR . $new_name;
    
    if (move_uploaded_file($file_tmp, $upload_path)) {
        return ['success' => true, 'filename' => $new_name, 'path' => $upload_path];
    }
    
    return ['success' => false, 'message' => 'Upload failed'];
}

function get_json_response($success, $message, $data = null) {
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}

function cms_require_database() {
    global $pdo;
    if (!$pdo) {
        http_response_code(503);
        die('Database is not configured. Import db/database.sql and update config.php credentials.');
    }
}

function fallback_news() {
    return [
        ['id' => 1, 'title' => 'Admissions open for the new academic session', 'category' => 'announcement', 'excerpt' => 'Families can now apply for FAPS early years, primary, JSS, and SSS classes.', 'content' => 'Admissions are open across the unified school system.', 'published_date' => '2026-06-01'],
        ['id' => 2, 'title' => 'Robotics learners begin engineering challenge series', 'category' => 'robotics', 'excerpt' => 'Students are designing sensor-driven prototypes in the STEM and Robotics Lab.', 'content' => 'The challenge series develops coding and teamwork.', 'published_date' => '2026-05-24'],
        ['id' => 3, 'title' => 'Digital literacy week celebrates student innovation', 'category' => 'stem', 'excerpt' => 'Learners showcased websites, data projects, and creative computing portfolios.', 'content' => 'Digital literacy remains central to 21st-century learning.', 'published_date' => '2026-05-10']
    ];
}

function fallback_events() {
    return [
        ['id' => 1, 'title' => 'STEM Fair and Robotics Showcase', 'category' => 'stem', 'event_date' => '2026-07-18', 'location' => 'Multipurpose Hall', 'description' => 'A whole-school exhibition of science, coding, and robotics projects.'],
        ['id' => 2, 'title' => 'Entrance Assessment Day', 'category' => 'academic', 'event_date' => '2026-07-25', 'location' => 'Admissions Office', 'description' => 'Prospective pupils and students complete placement assessments.'],
        ['id' => 3, 'title' => 'Leadership and Career Week', 'category' => 'other', 'event_date' => '2026-08-08', 'location' => 'Royal Prestige Leadership Academy', 'description' => 'Senior students meet professionals and practise leadership presentations.']
    ];
}

function fallback_gallery() {
    return [
        ['id' => 1, 'title' => 'Collaborative classroom learning', 'category' => 'academics', 'media_type' => 'image', 'media_url' => '../images/course-1.jpg', 'thumbnail_url' => '../images/course-1.jpg'],
        ['id' => 2, 'title' => 'Young learners at play', 'category' => 'school-life', 'media_type' => 'image', 'media_url' => '../images/image_2.jpg', 'thumbnail_url' => '../images/image_2.jpg'],
        ['id' => 3, 'title' => 'Science practical session', 'category' => 'stem', 'media_type' => 'image', 'media_url' => '../images/course-3.jpg', 'thumbnail_url' => '../images/course-3.jpg'],
        ['id' => 4, 'title' => 'Sports and teamwork', 'category' => 'sports', 'media_type' => 'image', 'media_url' => '../images/event-4.jpg', 'thumbnail_url' => '../images/event-4.jpg'],
        ['id' => 5, 'title' => 'Library reading culture', 'category' => 'facilities', 'media_type' => 'image', 'media_url' => '../images/course-5.jpg', 'thumbnail_url' => '../images/course-5.jpg'],
        ['id' => 6, 'title' => 'School celebration', 'category' => 'events', 'media_type' => 'image', 'media_url' => '../images/event-6.jpg', 'thumbnail_url' => '../images/event-6.jpg']
    ];
}

function fallback_stem() {
    return [
        ['title' => 'Coding Classes', 'program_type' => 'coding', 'target_level' => 'primary', 'description' => 'Scratch, Python, web basics, algorithms, and creative computing projects.'],
        ['title' => 'Robotics Kits', 'program_type' => 'robotics', 'target_level' => 'jss', 'description' => 'Hands-on builds using programmable kits, sensors, motors, and controllers.'],
        ['title' => 'Engineering Challenges', 'program_type' => 'engineering', 'target_level' => 'all', 'description' => 'Design thinking projects that connect maths, science, teamwork, and problem solving.'],
        ['title' => 'Science Labs', 'program_type' => 'science-lab', 'target_level' => 'sss', 'description' => 'Structured practicals in physics, chemistry, biology, observation, and reporting.'],
        ['title' => 'Competitions', 'program_type' => 'competitions', 'target_level' => 'all', 'description' => 'Preparation for STEM fairs, coding showcases, and innovation contests.']
    ];
}

function fallback_downloads() {
    return [
        ['title' => 'Admission Application Form', 'category' => 'admission-forms', 'description' => 'Application form for new pupils and students.', 'file_path' => '#'],
        ['title' => 'Parent Handbook', 'category' => 'policies', 'description' => 'Key school policies, routines, and expectations.', 'file_path' => '#'],
        ['title' => 'Academic Calendar', 'category' => 'schedules', 'description' => 'Term dates, holidays, and major events.', 'file_path' => '#']
    ];
}
?>
