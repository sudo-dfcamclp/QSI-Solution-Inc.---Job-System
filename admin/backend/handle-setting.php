<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-setting.php

ob_start();
header('Content-Type: application/json');
session_start();

require_once '../../database/db.php';
require_once '../includes/include_user.php'; // Your Reusable Center

if (!isset($_SESSION['user_id'])) {
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please login first.']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // ==========================================
    // HANDLE GET: Fetch current user data
    // ==========================================
    if ($method === 'GET') {
        // 1. Use reusable function to fetch user
        $users = fetchUsers($pdo, $user_id);
        
        if (empty($users)) {
            throw new Exception('User not found.');
        }

        $user = $users[0];

        // 2. Filter data: NEVER send the password hash to the frontend
        $userData = [
            'user_id'  => $user['user_id'],
            'f_name'   => $user['f_name'],
            'l_name'   => $user['l_name'],
            'email'    => $user['email'],
            'contact'  => $user['contact']
        ];

        ob_end_clean();
        echo json_encode(['status' => 'success', 'data' => $userData]);
        exit;
    }

    // ==========================================
    // HANDLE POST: Update user data
    // ==========================================
    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        $f_name = trim($input['f_name'] ?? '');
        $l_name = trim($input['l_name'] ?? '');
        $email = trim($input['email'] ?? '');
        $contact = trim($input['contact'] ?? '');
        
        $old_password = trim($input['old_password'] ?? '');
        $new_password = trim($input['new_password'] ?? '');

        if (empty($f_name) || empty($l_name) || empty($email)) {
            throw new Exception('Name and Email are required.');
        }

        $updateData = [
            'f_name' => $f_name,
            'l_name' => $l_name,
            'email' => $email,
            'contact' => $contact
        ];

        // Handle Password Change if requested
        if (!empty($old_password) && !empty($new_password)) {
            // 1. Use the SAME reusable function to fetch the user (including password) for verification
            $users = fetchUsers($pdo, $user_id);
            
            if (empty($users)) {
                throw new Exception('User not found in database.');
            }
            
            $dbUser = $users[0];

            // 2. Verify old password
            if (!password_verify($old_password, $dbUser['password'])) {
                throw new Exception('Old password is incorrect.');
            }

            // 3. Hash new password and add to update array
            $updateData['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        // 4. Execute Update using your reusable function
        $isUpdated = updateUser($pdo, $user_id, $updateData);

        if ($isUpdated) {
            ob_end_clean();
            echo json_encode([
                'status' => 'success',
                'message' => 'Information updated successfully.'
            ]);
        } else {
            throw new Exception('Failed to update information in the database.');
        }
        exit;
    }

    // If method is not GET or POST
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);

} catch (Exception $e) {
    ob_end_clean();
    error_log("Error in handle-setting.php: " . $e->getMessage());
    http_response_code(400); // Bad Request for validation errors
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>