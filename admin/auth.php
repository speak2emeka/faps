<?php
/**
 * Admin Authentication Handler
 * /admin/auth.php
 */

session_start();
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';

// Login
if ($action === 'login') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    try {
        if (!$pdo) {
            if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_username'] = ADMIN_USERNAME;
                $_SESSION['admin_role'] = 'admin';
                $_SESSION['admin_login_time'] = time();
                echo json_encode(['success' => true, 'message' => 'Login successful. Database setup is still required for CMS storage.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username AND `is_active` = TRUE");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();
        
        // For demo purposes, also check direct comparison
        if (!$user) {
            if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_username'] = ADMIN_USERNAME;
                $_SESSION['admin_role'] = 'admin';
                $_SESSION['admin_login_time'] = time();
                
                echo json_encode(['success' => true, 'message' => 'Login successful']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
        } else {
            // Use password_verify for database users
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['admin_login_time'] = time();
                
                // Update last login
                $update = $pdo->prepare("UPDATE `users` SET `last_login` = NOW() WHERE `id` = :id");
                $update->execute([':id' => $user['id']]);
                
                echo json_encode(['success' => true, 'message' => 'Login successful']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

// Logout
if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// Check Session
if ($action === 'check') {
    if (isset($_SESSION['admin_id'])) {
        // Check timeout
        if (time() - $_SESSION['admin_login_time'] > SESSION_TIMEOUT) {
            session_destroy();
            echo json_encode(['success' => false, 'message' => 'Session expired']);
        } else {
            echo json_encode(['success' => true, 'user' => $_SESSION['admin_username']]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
?>
