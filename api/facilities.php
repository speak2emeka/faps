<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

$school = isset($_GET['school']) ? sanitize_input($_GET['school']) : null;

if (!$pdo) {
    echo get_json_response(true, 'Fallback content', ['items' => [], 'pagination' => ['total' => 0, 'page' => 1, 'limit' => 0, 'pages' => 0]]);
    exit;
}

try {
    $query = "SELECT * FROM `facilities` WHERE `is_published` = TRUE";
    $params = [];
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $query .= " AND `school_scope` = :school";
        $params[':school'] = $school;
    }
    $query .= " ORDER BY `sort_order` ASC, `id` DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $items = $stmt->fetchAll();
    foreach ($items as &$item) {
        $item['image_url'] = $item['image'] ? SITE_URL . 'assets/uploads/' . $item['image'] : null;
    }
    echo get_json_response(true, 'Success', ['items' => $items, 'pagination' => ['total' => count($items), 'page' => 1, 'limit' => count($items), 'pages' => 1]]);
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
