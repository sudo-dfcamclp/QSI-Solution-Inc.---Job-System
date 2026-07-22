<?php
date_default_timezone_set('Asia/Manila');

define('DB_HOST', 'localhost');
define('DB_NAME', 'qsi_inc');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // This creates the $pdo variable in the GLOBAL scope
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>