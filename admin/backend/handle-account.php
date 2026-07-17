<?php
ob_start();
header('Content-Type: application/json');

require_once '../../database/db.php';

try {
    // DIRECT QUERY TEST: Bypassing user_functions.php temporarily
    $sql = "SELECT user_id, f_name, l_name, email, contact, status, user_type FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        'data'   => $cleanUsers
    ]);

} catch (Exception $e) {
    ob_end_clean();
    error_log("Error in handle-alluser.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch user data.'
    ]);
}
?>