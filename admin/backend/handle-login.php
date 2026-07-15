<?php
// Set header to return JSON
header('Content-Type: application/json');

// Include database config
require_once '../../database/db.php';

// 1. Get the raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

// 2. Check if we received valid JSON data (instead of checking $_SERVER method)
if (!$input || empty($input['email']) || empty($input['password'])) {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request. Please provide email and password.'
    ]);
    exit;
}

$email = $input['email'];
$password = $input['password'];

try {
    // Prepare statement
    $stmt = $pdo->prepare("SELECT user_id, f_name, l_name, email, password FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            
            // Start Session
            session_start();
            
            // Store user info
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['f_name'] = $user['f_name'];
            $_SESSION['l_name'] = $user['l_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;

            echo json_encode([
                'status' => 'success', 
                'message' => 'Login successful',
                'redirect' => '../dashboard.php'
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred']);
}
?>