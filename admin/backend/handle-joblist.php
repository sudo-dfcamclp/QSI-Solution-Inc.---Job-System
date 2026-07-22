<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-joblist.php

ob_start();
header('Content-Type: application/json');

// 1. Include Database Connection
require_once '../../database/db.php';
require_once '../includes/include_joblist.php';

try {
    // HANDLE POST: Save a new job
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $salary = floatval($input['salary'] ?? 0);
        $location = trim($input['location'] ?? '');
        $job_type = trim($input['job_type'] ?? 'Full-time'); // Default to Full-time if not provided

        // Validate required fields
        if (empty($title)) {
            throw new Exception("Job title is required.");
        }
        if (empty($location)) {
            throw new Exception("Job location is required.");
        }

        // 3. USE THE REUSABLE FUNCTION instead of raw SQL
        $new_job_id = insertJob($pdo, $title, $description, $salary, $location, $job_type);

        ob_end_clean();
        echo json_encode([
            'status'  => 'success',
            'message' => 'Job added successfully!',
            'job_id'  => $new_job_id // Optional: useful for frontend if needed
        ]);
        exit; // Stop execution after saving
    }

     // HANDLE PUT: Update an existing job
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $job_id = intval($input['job_id'] ?? 0);
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $salary = floatval($input['salary'] ?? 0);
        $location = trim($input['location'] ?? '');
        $job_type = trim($input['job_type'] ?? 'Full-time'); // Default to Full-time if not provided

        // Validate required fields
        if ($job_id <= 0) {
            throw new Exception("Invalid Job ID.");
        }
        if (empty($title)) {
            throw new Exception("Job title is required.");
        }
        if (empty($location)) {
            throw new Exception("Job location is required.");
        }

        // Call the update function from include_joblist.php
        $isUpdated = updateJob($pdo, $job_id, $title, $description, $salary, $location, $job_type);

        if ($isUpdated) {
            ob_end_clean();
            echo json_encode([
                'status'  => 'success',
                'message' => 'Job updated successfully.'
            ]);
        } else {
            throw new Exception("Failed to update job.");
        }
        exit;
    }

    // HANDLE DELETE: Delete a specific job
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $input = json_decode(file_get_contents('php://input'), true);
        $job_id = intval($input['job_id'] ?? 0);

        if ($job_id <= 0) {
            throw new Exception("Invalid Job ID.");
        }

        // Call the delete function from include_joblist.php
        $isDeleted = deleteJob($pdo, $job_id);

        if ($isDeleted) {
            ob_end_clean();
            echo json_encode([
                'status'  => 'success',
                'message' => 'Job deleted successfully.'
            ]);
        } else {
            throw new Exception("Failed to delete job or job not found.");
        }
        exit;
    }

    // HANDLE GET: Fetch all jobs
    $jobs = fetchJobs($pdo, null);

    // Clean up data for JavaScript
    $cleanJobs = [];
    foreach ($jobs as $job) {
        $cleanJobs[] = [
            'job_id'      => $job['job_id'],
            'title'       => $job['title'] ?? 'No Title',
            'description1' => $job['description1'] ?? '',
            'salary1'     => $job['salary1'] ?? 0,
            'location1'   => $job['location1'] ?? 'N/A',
            'job_type'    => $job['job_type'] ?? 'Full-time',
            'date_time'   => $job['date_time'] ?? 'Unknown Date'
        ];
    }

    ob_end_clean();
    echo json_encode([
        'status' => 'success',
        'data'   => $cleanJobs,
        'count'  => count($cleanJobs)
    ]);

} catch (Exception $e) {
    ob_end_clean();
    error_log("Error in handle-joblist.php: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to process request.',
        'debug'   => $e->getMessage() // Remove 'debug' in production
    ]);
}
?>