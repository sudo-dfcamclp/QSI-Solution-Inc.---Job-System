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

/**
 * Update a single user record in the users table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int $user_id The ID of the user to update.
 * @param array $data Associative array of column names and their new values.
 *                    Allowed columns: f_name, l_name, email, contact, password, status, user_type
 * @return bool True if the update was successful, false otherwise.
 * @throws InvalidArgumentException If no valid data is provided or user_id is invalid.
 */
function updateUser(PDO $pdo, int $user_id, array $data): bool
{
    // Validate user_id
    if ($user_id <= 0) {
        throw new InvalidArgumentException("Invalid user ID.");
    }

    // Define allowed columns for update
    $allowedColumns = ['f_name', 'l_name', 'email', 'contact', 'password', 'status', 'user_type'];
    
    // Filter data to only include allowed columns
    $filteredData = [];
    foreach ($data as $column => $value) {
        if (in_array($column, $allowedColumns)) {
            $filteredData[$column] = $value;
        }
    }

    // Check if there's any data to update
    if (empty($filteredData)) {
        throw new InvalidArgumentException("No valid data provided for update.");
    }

    // Build the SET clause dynamically
    $setClauses = [];
    $params = [];
    foreach ($filteredData as $column => $value) {
        $setClauses[] = "$column = :$column";
        $params[":$column"] = $value;
    }

    // Add user_id to parameters
    $params[':user_id'] = $user_id;

    // Build the SQL query
    $sql = "UPDATE users SET " . implode(', ', $setClauses) . " WHERE user_id = :user_id";

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        // Log the error or handle it as needed
        error_log("Update user failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a single user record from the users table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int $user_id The ID of the user to delete.
 * @return bool True if the deletion was successful, false otherwise.
 * @throws InvalidArgumentException If user_id is invalid.
 */
function deleteUser(PDO $pdo, int $user_id): bool
{
    // Validate user_id
    if ($user_id <= 0) {
        throw new InvalidArgumentException("Invalid user ID.");
    }

    $sql = "DELETE FROM users WHERE user_id = :user_id";

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':user_id' => $user_id]);
    } catch (PDOException $e) {
        // Log the error or handle it as needed
        error_log("Delete user failed: " . $e->getMessage());
        return false;
    }
}
?>