<?php
/**
 * API: Contact Form Handler
 * POST /api/contact.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo get_json_response(false, 'Method not allowed');
    exit;
}

try {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $school_office = sanitize_input($_POST['school_office'] ?? '');
    $subject = sanitize_input($_POST['subject'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    // Validate
    if (!$name || !$email || !$subject || !$message) {
        echo get_json_response(false, 'Please fill all required fields');
        exit;
    }
    
    if (!validate_email($email)) {
        echo get_json_response(false, 'Invalid email address');
        exit;
    }

    if (!$pdo) {
        echo get_json_response(true, 'Message received. Database storage will be available after CMS setup.');
        exit;
    }
    
    if ($school_office) {
        $subject = '[' . $school_office . '] ' . $subject;
        $message = "School/Admin Office: " . $school_office . "\n\n" . $message;
    }

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO `contact_submissions` (`name`, `email`, `phone`, `subject`, `message`)
        VALUES (:name, :email, :phone, :subject, :message)
    ");
    
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
    ]);
    
    // Send email notification (optional)
    // mail(SCHOOL_EMAIL, "New Contact Form: $subject", "From: $name ($email)\n\n$message");
    
    echo get_json_response(true, 'Message sent successfully! We will contact you soon.');
    
} catch (Exception $e) {
    echo get_json_response(false, 'Error: ' . $e->getMessage());
}
?>
