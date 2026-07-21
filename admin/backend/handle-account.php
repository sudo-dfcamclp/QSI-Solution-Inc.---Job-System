<?php
// File: C:\xampp\htdocs\qsi_inc\admin\handle-alluser.php

ob_start();
header('Content-Type: application/json');

// 1. Include Database Connection
require_once '../../database/db.php';
require_once '../includes/include_user.php';

try {
    // 3. Use the reusable function to fetch all users
    // Passing 'null' as the second argument tells the function to fetch ALL users
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
    error_log("Error in handle-alluser.php: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch user data.'
    ]);
}
?>