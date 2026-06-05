<?php
/**
 * API: Get STEM Programs
 * GET /api/stem.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!$pdo) {
    echo get_json_response(true, 'Fallback content', fallback_stem());
    exit;
}

$program_type = isset($_GET['type']) ? sanitize_input($_GET['type']) : null;
$level = isset($_GET['level']) ? sanitize_input($_GET['level']) : null;
$school = isset($_GET['school']) ? sanitize_input($_GET['school']) : null;

try {
    $query = "SELECT * FROM `stem_programs` WHERE `is_published` = TRUE";
    
    if ($program_type) {
        $query .= " AND `program_type` = :type";
    }
    
    if ($level && $level !== 'all') {
        $query .= " AND (`target_level` = :level OR `target_level` = 'all')";
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $query .= " AND (`school_scope` = :school OR `school_scope` = 'all')";
    }
    
    $query .= " ORDER BY `title` ASC";
    
    $stmt = $pdo->prepare($query);
    
    if ($program_type) {
        $stmt->bindValue(':type', $program_type);
    }
    if ($level && $level !== 'all') {
        $stmt->bindValue(':level', $level);
    }
    if ($school && in_array($school, ['primary', 'secondary'], true)) {
        $stmt->bindValue(':school', $school);
    }
    
    $stmt->execute();
    $programs = $stmt->fetchAll();
    
    // Add image URLs
    foreach ($programs as &$program) {
        $program['image_url'] = $program['featured_image'] ? SITE_URL . 'assets/uploads/' . $program['featured_image'] : null;
    }
    
    echo get_json_response(true, 'Success', $programs);
    
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
