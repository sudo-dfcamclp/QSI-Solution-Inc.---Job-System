<?php
// File: C:\xampp\htdocs\qsi_inc\admin\includes\user_functions.php

/**
 * Fetch all users or specific user by ID from the users table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int|null $user_id Optional. If provided, fetches only this user.
 * @return array Array of user records.
 */
function fetchUsers(PDO $pdo, ?int $user_id = null): array
{
    if ($user_id !== null) {
        // Fetch a single user by ID
        $sql = "SELECT user_id, f_name, l_name, email, contact, password, status, user_type FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch();
        
        // Return as an array with one element, or empty array if not found
        return $result ? [$result] : [];
    } else {
        // Fetch all users
        $sql = "SELECT user_id, f_name, l_name, email, contact, password, status, user_type FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>