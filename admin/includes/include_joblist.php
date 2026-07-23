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
        // ADDED: company1 to SELECT
        $sql = "SELECT job_id, title, company1, description1, salary1, location1, job_type, date_time FROM joblist WHERE job_id = :job_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':job_id' => $job_id]);
        $result = $stmt->fetch();
        
        // Return as an array with one element, or empty array if not found
        return $result ? [$result] : [];
    } else {
        // Fetch all jobs, ordered by date_time descending (newest first)
        // ADDED: company1 to SELECT
        $sql = "SELECT job_id, title, company1, description1, salary1, location1, job_type, date_time FROM joblist ORDER BY date_time DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}

/**
 * Insert a new job into the joblist table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param string $title The job title.
 * @param string $company The job company.
 * @param string $description The job description.
 * @param float $salary The job salary.
 * @param string $location The job location.
 * @param string $job_type The type of job (e.g., Full-time, Part-time, Contract).
 * @return int The ID of the newly inserted job.
 * @throws InvalidArgumentException If required fields are empty.
 */
// ADDED: $company parameter
function insertJob(PDO $pdo, string $title, string $company, string $description, float $salary, string $location, string $job_type): int
{
    // Validate required fields
    if (empty(trim($title))) {
        throw new InvalidArgumentException("Job title cannot be empty.");
    }
    
    // ADDED: Validation for company
    if (empty(trim($company))) {
        throw new InvalidArgumentException("Job company cannot be empty.");
    }
    
    if (empty(trim($location))) {
        throw new InvalidArgumentException("Job location cannot be empty.");
    }
    
    if (empty(trim($job_type))) {
        throw new InvalidArgumentException("Job type cannot be empty.");
    }

    // ADDED: company1 to INSERT columns and VALUES
    $sql = "INSERT INTO joblist (title, company1, description1, salary1, location1, job_type, date_time) 
            VALUES (:title, :company, :description, :salary, :location, :job_type, NOW())";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':title' => trim($title),
        ':company' => trim($company), // ADDED binding
        ':description' => trim($description),
        ':salary' => $salary,
        ':location' => trim($location),
        ':job_type' => trim($job_type)
    ]);

    // Return the ID of the newly created job so we can use it if needed
    return (int) $pdo->lastInsertId();
}


/**
 * Update an existing job in the joblist table.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int $job_id The ID of the job to update.
 * @param string $title The new job title.
 * @param string $company The new job company.
 * @param string $description The new job description.
 * @param float $salary The new job salary.
 * @param string $location The new job location.
 * @param string $job_type The new job type.
 * @return bool True if the job was updated, false otherwise.
 * @throws InvalidArgumentException If required fields are empty.
 */
// ADDED: $company parameter
function updateJob(PDO $pdo, int $job_id, string $title, string $company, string $description, float $salary, string $location, string $job_type): bool
{
    // Validate job_id
    if ($job_id <= 0) {
        throw new InvalidArgumentException("Invalid job ID.");
    }
    
    // Validate required fields
    if (empty(trim($title))) {
        throw new InvalidArgumentException("Job title cannot be empty.");
    }

    // ADDED: Validation for company
    if (empty(trim($company))) {
        throw new InvalidArgumentException("Job company cannot be empty.");
    }
    
    if (empty(trim($location))) {
        throw new InvalidArgumentException("Job location cannot be empty.");
    }
    
    if (empty(trim($job_type))) {
        throw new InvalidArgumentException("Job type cannot be empty.");
    }

    // ADDED: company1 to SET clause
    $sql = "UPDATE joblist SET title = :title, company1 = :company, description1 = :description, salary1 = :salary, 
            location1 = :location, job_type = :job_type WHERE job_id = :job_id";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([
        ':title' => trim($title),
        ':company' => trim($company), // ADDED binding
        ':description' => trim($description),
        ':salary' => $salary,
        ':location' => trim($location),
        ':job_type' => trim($job_type),
        ':job_id' => $job_id
    ]);
}


/**
 * Delete a job from the joblist table by ID.
 * 
 * @param PDO $pdo The PDO database connection object.
 * @param int $job_id The ID of the job to delete.
 * @return bool True if the job was deleted, false otherwise.
 * @throws InvalidArgumentException If job_id is invalid.
 */
function deleteJob(PDO $pdo, int $job_id): bool
{
    // Validate job_id
    if ($job_id <= 0) {
        throw new InvalidArgumentException("Invalid job ID.");
    }

    $sql = "DELETE FROM joblist WHERE job_id = :job_id";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([':job_id' => $job_id]);
}
?>