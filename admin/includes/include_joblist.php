<?php
// File: C:\xampp\htdocs\qsi_inc\admin\includes\job_functions.php

/**
 * Fetch all jobs or a specific job by ID from the joblist table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int|null $job_id Optional. If provided, fetches only this job.
 * @return array Array of job records.
 */
function fetchJobs(PDO $pdo, ?int $job_id = null): array
{
    if ($job_id !== null) {
        // Fetch a single job by ID
        $sql = "SELECT job_id, title, description, salary, date_time FROM joblist WHERE job_id = :job_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':job_id' => $job_id]);
        $result = $stmt->fetch();
        
        // Return as an array with one element, or empty array if not found
        return $result ? [$result] : [];
    } else {
        // Fetch all jobs, ordered by date_time descending (newest first)
        $sql = "SELECT job_id, title, description, salary, date_time FROM joblist ORDER BY date_time DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}

/**
 * Insert a new job into the joblist table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param string $title The job title.
 * @param string $description The job description.
 * @param float $salary The job salary.
 * @return int The ID of the newly inserted job.
 */
function insertJob(PDO $pdo, string $title, string $description, float $salary): int
{
    $sql = "INSERT INTO joblist (title, description, salary, date_time) VALUES (:title, :description, :salary, NOW())";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':salary' => $salary
    ]);

    // Return the ID of the newly created job so we can use it if needed
    return (int) $pdo->lastInsertId();
}

/**
 * Delete a job from the joblist table by ID.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int $job_id The ID of the job to delete.
 * @return bool True if the job was deleted, false otherwise.
 */
function deleteJob(PDO $pdo, int $job_id): bool
{
    $sql = "DELETE FROM joblist WHERE job_id = :job_id";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([':job_id' => $job_id]);
}
?>