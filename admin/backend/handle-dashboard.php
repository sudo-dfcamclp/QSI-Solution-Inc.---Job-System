<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-dashboard.php

header('Content-Type: application/json');
require_once '../../database/db.php';
require_once '../includes/include_joblist.php';

try {
    // 1. Fetch all jobs using the reusable function from include_joblist.php
    $allJobs = fetchJobs($pdo);

    // 2. Initialize Analytics Arrays
    $currentYear = date('Y');
    
    // Yearly: Jan-Dec (Initialize with 0)
    $yearlyCounts = array_fill(0, 12, 0); 
    $monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    // Monthly: Last 6 Months
    $monthlyLabels = [];
    $monthlyCounts = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = strtotime("-$i months");
        $monthlyLabels[] = date('M Y', $date); // e.g., "Jul 2024"
        $monthlyCounts[] = 0;
    }

    // Weekly: Last 7 Days
    $weeklyLabels = [];
    $weeklyCounts = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = strtotime("-$i days");
        $weeklyLabels[] = date('D', $date); // e.g., "Mon"
        $weeklyCounts[] = 0;
    }

    // Job Type Counts
    $typeCounts = [
        'Full-Time' => 0,
        'Hybrid'    => 0,
        'On-site'   => 0
    ];

    // 3. Process Each Job
    foreach ($allJobs as $job) {
        $jobDate = new DateTime($job['date_time']);
        $jobYear = (int)$jobDate->format('Y');
        $jobMonthIndex = (int)$jobDate->format('m') - 1; // 0-11
        $jobType = $job['job_type'] ?? 'Full-Time';

        // A. Yearly Logic (Current Year Only)
        if ($jobYear == $currentYear) {
            $yearlyCounts[$jobMonthIndex]++;
        }

        // B. Monthly Logic (Last 6 Months)
        // Check if job falls into any of the last 6 month buckets
        for ($i = 0; $i < 6; $i++) {
            $targetDate = strtotime("-$i months");
            if ($jobDate->format('Y-m') == date('Y-m', $targetDate)) {
                // Index 0 is 5 months ago, Index 5 is current month. 
                // We need to map this correctly to our array which was built backwards.
                // Our array: [5 months ago, 4, 3, 2, 1, Current]
                $monthlyCounts[$i]++; 
                break;
            }
        }

        // C. Weekly Logic (Last 7 Days)
        for ($i = 0; $i < 7; $i++) {
            $targetDate = strtotime("-$i days");
            if ($jobDate->format('Y-m-d') == date('Y-m-d', $targetDate)) {
                // Our array: [6 days ago, 5, 4, 3, 2, 1, Today]
                $weeklyCounts[$i]++;
                break;
            }
        }

        // D. Job Type Logic
        if (isset($typeCounts[$jobType])) {
            $typeCounts[$jobType]++;
        } else {
            // Handle unexpected types or group them
            $typeCounts['Other'] = ($typeCounts['Other'] ?? 0) + 1;
        }
    }

    // 4. Return JSON Response
    echo json_encode([
        'status' => 'success',
        'data' => [
            'yearly' => [
                'labels' => $monthNames,
                'counts' => $yearlyCounts
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'counts' => $monthlyCounts
            ],
            'weekly' => [
                'labels' => $weeklyLabels,
                'counts' => $weeklyCounts
            ],
            'types' => $typeCounts,
            'total' => count($allJobs)
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
