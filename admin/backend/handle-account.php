<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-account.php

ob_start();
header('Content-Type: application/json');

// 1. Include Database Connection
require_once '../../database/db.php';
require_once '../includes/include_user.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // ==========================================
    // HANDLE PUT: Update user type
    // ==========================================
    if ($method === 'PUT') {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $user_id = intval($input['user_id'] ?? 0);
        $user_type = trim($input['user_type'] ?? '');

        // Validate input
        if ($user_id <= 0) {
            throw new Exception("Invalid user ID.");
        }
        
        // Ensure only allowed types are passed
        $allowedTypes = ['user', 'admin', 'super_admin'];
        if (!in_array($user_type, $allowedTypes)) {
            throw new Exception("Invalid user type selected.");
        }

        // Use the reusable function from include_user.php
        $isUpdated = updateUser($pdo, $user_id, ['user_type' => $user_type]);

        if ($isUpdated) {
            ob_end_clean();
            echo json_encode([
                'status'  => 'success',
                'message' => 'User type updated successfully.'
            ]);
        } else {
            throw new Exception("Failed to update user in database.");
        }
        exit; // Stop execution after updating
    }

    // ==========================================
    // HANDLE GET: Fetch all users (Default)
    // ==========================================
    // 3. Use the reusable function to fetch all users
    $users = fetchUsers($pdo, null);

    // 4. Clean up data (Remove sensitive fields like 'password' before sending to JS)
    $cleanUsers = [];
    foreach ($users as $user) {
        $cleanUsers[] = [
            'user_id'   => $user['user_id'],
            'f_name'    => $user['f_name'],
            'l_name'    => $user['l_name'],
            'email'     => $user['email'],
            'contact'   => $user['contact'],
            'status'    => $user['status'] ?? 'unknown',      // Fallback if null
            'user_type' => $user['user_type'] ?? 'unknown'     // Fallback if null
        ];
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'data'   => $cleanUsers,
        'count'  => count($cleanUsers)
    ]);

} catch (Exception $e) {
    ob_end_clean();
    error_log("Error in handle-account.php: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage() // Shows the exact error for debugging
    ]);
}
?>