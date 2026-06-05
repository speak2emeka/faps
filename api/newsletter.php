<?php
/**
 * API: Newsletter Subscription
 * POST /api/newsletter.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$pdo) {
        echo get_json_response(true, 'Fallback content', ['items' => fallback_news(), 'pagination' => ['total' => 3, 'page' => 1, 'limit' => 10, 'pages' => 1]]);
        exit;
    }
    try {
        $school = isset($_GET['school']) ? sanitize_input($_GET['school']) : null;
        $query = "SELECT * FROM `newsletter_posts` WHERE `is_published` = TRUE";
        $params = [];
        if ($school && in_array($school, ['primary', 'secondary'], true)) {
            $query .= " AND (`school_scope` = :school OR `school_scope` = 'all')";
            $params[':school'] = $school;
        }
        $query .= " ORDER BY `published_date` DESC, `created_at` DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $items = $stmt->fetchAll();
        echo get_json_response(true, 'Success', ['items' => $items, 'pagination' => ['total' => count($items), 'page' => 1, 'limit' => count($items), 'pages' => 1]]);
    } catch (Exception $e) {
        echo get_json_response(false, 'Error: ' . $e->getMessage());
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo get_json_response(false, 'Method not allowed');
    exit;
}

try {
    $email = sanitize_input($_POST['email'] ?? '');
    $name = sanitize_input($_POST['name'] ?? '');
    
    if (!$email) {
        echo get_json_response(false, 'Email is required');
        exit;
    }
    
    if (!validate_email($email)) {
        echo get_json_response(false, 'Invalid email address');
        exit;
    }

    if (!$pdo) {
        echo get_json_response(true, 'Subscription received. Database storage will be available after CMS setup.');
        exit;
    }
    
    // Check if already subscribed
    $check = $pdo->prepare("SELECT `id` FROM `newsletter_subscribers` WHERE `email` = :email");
    $check->execute([':email' => $email]);
    
    if ($check->fetch()) {
        echo get_json_response(false, 'You are already subscribed to our newsletter');
        exit;
    }
    
    // Subscribe
    $stmt = $pdo->prepare("
        INSERT INTO `newsletter_subscribers` (`email`, `name`)
        VALUES (:email, :name)
    ");
    
    $stmt->execute([
        ':email' => $email,
        ':name' => $name
    ]);
    
    echo get_json_response(true, 'Successfully subscribed to our newsletter!');
    
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
