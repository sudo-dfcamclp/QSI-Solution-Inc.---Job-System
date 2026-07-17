<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-login.php

// 1. Start Output Buffering to catch any accidental whitespace/echoes from included files
ob_start();

// Set header to return JSON
header('Content-Type: application/json');

// Include database config
require_once '../../database/db.php';

// 2. Get the raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

// 3. Check if we received valid JSON data
if (!$input || empty($input['email']) || empty($input['password'])) {
    ob_end_clean(); // Clear buffer before sending response
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request. Please provide email and password.'
    ]);
    exit;
}

$email = $input['email'];
$password = $input['password'];

try {
    // UPDATED: Added status and user_type to SELECT
    $stmt = $pdo->prepare("SELECT user_id, f_name, l_name, email, password, status, user_type FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password first (security best practice)
        if (password_verify($password, $user['password'])) {
            
            // --- CHECK STATUS AND USER TYPE ---

            // 1. Check if account is pending
            if ($user['status'] === 'pending') {
                ob_end_clean(); // Clear buffer
                echo json_encode([
                    'status' => 'pending', // Custom status for JS to catch
                    'message' => 'Your account status is pending. Please wait for admin approval or verify your email.'
                ]);
                exit;
            }

            // 2. Check if account is banned/inactive
            if ($user['status'] !== 'active') {
                ob_end_clean(); // Clear buffer
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Account is inactive or banned.'
                ]);
                exit;
            }

            // 3. Check User Type Restrictions
            // If you want ONLY admins/super_admins to login here:
            if ($user['user_type'] === 'user') {
                 ob_end_clean(); // Clear buffer
                 echo json_encode([
                    'status' => 'error', 
                    'message' => 'Access denied. Regular users cannot access the admin dashboard.'
                ]);
                exit;
            }
            
            // --- IF ALL CHECKS PASS, LOG IN ---

            // Start Session
            session_start();
            
            // Store user info
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['f_name'] = $user['f_name'];
            $_SESSION['l_name'] = $user['l_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['logged_in'] = true;

            ob_end_clean(); // Clear buffer
            echo json_encode([
                'status' => 'success', 
                'message' => 'Login successful',
                'redirect' => 'dashboard.php'
            ]);

        } else {
            ob_end_clean(); // Clear buffer
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }
    } else {
        ob_end_clean(); // Clear buffer
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

} catch (PDOException $e) {
    ob_end_clean(); // Clear buffer
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred']);
}
?>