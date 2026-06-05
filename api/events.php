<?php
/**
 * API: Get Events
 * GET /api/events.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!$pdo) {
    echo get_json_response(true, 'Fallback content', [
        'items' => fallback_events(),
        'pagination' => ['total' => count(fallback_events()), 'page' => 1, 'limit' => 10, 'pages' => 1]
    ]);
    exit;
}

$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : null;
$school = isset($_GET['school']) ? sanitize_input($_GET['school']) : null;
$upcoming = isset($_GET['upcoming']) ? (bool)$_GET['upcoming'] : false;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? min((int)$_GET['limit'], 50) : 10;
$offset = ($page - 1) * $limit;

try {
    $query = "SELECT * FROM `events` WHERE `is_published` = TRUE";
    
    if ($upcoming) {
        $query .= " AND `event_date` >= NOW()";
    }
    
    if ($category) {
        $query .= " AND `category` = :category";
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $query .= " AND (`school_scope` = :school OR `school_scope` = 'all')";
    }
    
    $query .= " ORDER BY `event_date` ASC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    if ($category) {
        $stmt->bindValue(':category', $category);
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $stmt->bindValue(':school', $school);
    }
    
    $stmt->execute();
    $events = $stmt->fetchAll();
    
    // Format dates
    foreach ($events as &$event) {
        $event['event_date_formatted'] = date('F d, Y - H:i A', strtotime($event['event_date']));
        $event['image_url'] = $event['image'] ? SITE_URL . 'assets/uploads/' . $event['image'] : null;
    }
    
    // Get total count
    $count_query = "SELECT COUNT(*) as `total` FROM `events` WHERE `is_published` = TRUE";
    if ($upcoming) {
        $count_query .= " AND `event_date` >= NOW()";
    }
    if ($category) {
        $count_query .= " AND `category` = :category";
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $count_query .= " AND (`school_scope` = :school OR `school_scope` = 'all')";
    }
    
    $count_stmt = $pdo->prepare($count_query);
    if ($category) {
        $count_stmt->bindValue(':category', $category);
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $count_stmt->bindValue(':school', $school);
    }
    $count_stmt->execute();
    $total = $count_stmt->fetch()['total'];
    
    echo get_json_response(true, 'Success', [
        'items' => $events,
        'pagination' => [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ]
    ]);
    
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
