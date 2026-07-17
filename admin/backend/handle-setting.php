<?php
ob_start();

// 2. Set header to return JSON
header('Content-Type: application/json');

// 3. Include database config and reusable functions
require_once '../../database/db.php';
require_once '../includes/user_functions.php';

// 4. Start session to get the logged-in user's ID
session_start();

// 5. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    ob_end_clean();
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized. Please login first.'
    ]);
    exit;
}

try {
    // 6. Get the logged-in user's ID from session
    $user_id = (int)$_SESSION['user_id'];

    // 7. Fetch the user using the reusable function
    $users = fetchUsers($pdo, $user_id);

    // 8. Check if user was found
    if (empty($users)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found.'
        ]);
        exit;
    }

    // 9. Get the first (and only) user record
    $user = $users[0];

    // 10. Prepare the response with requested columns
    $userData = [
        'user_id'  => $user['user_id'],
        'f_name'   => $user['f_name'],
        'l_name'   => $user['l_name'],
        'email'    => $user['email'],
        'contact'  => $user['contact'],
        'password' => $user['password'] // ⚠️ See security note below
    ];

    // 11. Clear buffer and send response
    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'data'   => $userData
    ]);

} catch (Exception $e) {
    ob_end_clean();
    error_log("Error in handle-setting.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch user data.'
    ]);
}
?>