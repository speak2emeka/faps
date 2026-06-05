<?php
/**
 * API: Get Sliders for Homepage
 * GET /api/sliders.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if (!$pdo) {
    echo get_json_response(true, 'Fallback content', []);
    exit;
}

try {
    $query = "SELECT * FROM `sliders` WHERE `is_active` = TRUE ORDER BY `sort_order` ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $sliders = $stmt->fetchAll();
    
    // Add image URLs
    foreach ($sliders as &$slider) {
        $slider['image_url'] = SITE_URL . 'assets/uploads/' . $slider['image'];
    }
    
    echo get_json_response(true, 'Success', $sliders);
    
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
