<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!$pdo) {
    echo get_json_response(true, 'Fallback content', [
        'items' => fallback_downloads(),
        'pagination' => ['total' => count(fallback_downloads()), 'page' => 1, 'limit' => 20, 'pages' => 1]
    ]);
    exit;
}

$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : null;
$school = isset($_GET['school']) ? sanitize_input($_GET['school']) : null;

try {
    $query = "SELECT * FROM `downloads` WHERE `is_available` = TRUE";
    if ($category) {
        $query .= " AND `category` = :category";
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $query .= " AND (`school_scope` = :school OR `school_scope` = 'all')";
    }
    $query .= " ORDER BY `created_at` DESC";
    $stmt = $pdo->prepare($query);
    if ($category) {
        $stmt->bindValue(':category', $category);
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $stmt->bindValue(':school', $school);
    }
    $stmt->execute();
    $items = $stmt->fetchAll();
    foreach ($items as &$item) {
        if ($item['file_path'] && !preg_match('/^https?:\/\//', $item['file_path'])) {
            $item['file_path'] = SITE_URL . 'assets/uploads/' . $item['file_path'];
        }
    }
    echo get_json_response(true, 'Success', [
        'items' => $items,
        'pagination' => ['total' => count($items), 'page' => 1, 'limit' => count($items), 'pages' => 1]
    ]);
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
