<?php
// 1. Set header to return JSON
header('Content-Type: application/json');

// 2. Include database configuration (go up 2 levels to root, then into database)
require_once '../../database/db.php';

// 3. Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// 4. Get JSON input from the frontend
$input = json_decode(file_get_contents('php://input'), true);

// 5. Extract and sanitize input data
$f_name    = trim($input['f_name'] ?? '');
$l_name    = trim($input['l_name'] ?? '');
$email     = trim($input['email'] ?? '');
$contact   = trim($input['contact'] ?? '');
$password  = $input['password'] ?? '';

// 6. Basic Validation
if (empty($f_name) || empty($l_name) || empty($email) || empty($contact) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

try {
    // 7. Check if email already exists in the database
    $checkStmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
    $checkStmt->execute([':email' => $email]);
    
    if ($checkStmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'This email is already registered.']);
        exit;
    }

    // 8. Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 9. Insert the new user into the database
    $insertStmt = $pdo->prepare("
        INSERT INTO users (f_name, l_name, email, contact, password) 
        VALUES (:f_name, :l_name, :email, :contact, :password)
    ");
    
    $insertStmt->execute([
        ':f_name'    => $f_name,
        ':l_name'    => $l_name,
        ':email'     => $email,
        ':contact'   => $contact,
        ':password'  => $hashed_password
    ]);

    // 10. Return success response
    echo json_encode([
        'status' => 'success', 
        'message' => 'Account registered successfully.'
    ]);

} catch (PDOException $e) {
    // Log the actual error for debugging, but show a generic message to the user
    error_log("Registration Error: " . $e->getMessage());
    echo json_encode([
        'status' => 'error', 
        'message' => 'A database error occurred. Please try again later.'
    ]);
}
?>