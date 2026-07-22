<?php
// File: C:\xampp\htdocs\qsi_inc\admin\backend\handle-dashboard.php

header('Content-Type: application/json');
require_once '../../database/db.php';
require_once '../includes/include_joblist.php';

// CHANGE THIS LINE to match your filename
require_once '../includes/include_user.php'; 

try {
    // 1. Total Jobs
    $totalJobs = (int)$pdo->query("SELECT COUNT(*) FROM joblist")->fetchColumn();

    // 2. Total Admins (Using the function from include_user.php)
    $totalAdmins = getAdminCount($pdo);

    // ... rest of the code remains the same ...
    
    // 3. Latest Job Post
    $latestJobStmt = $pdo->query("SELECT title, date_time FROM joblist ORDER BY date_time DESC LIMIT 1");
    $latestJob = $latestJobStmt->fetch(PDO::FETCH_ASSOC);
    
    $latestJobTitle = $latestJob ? $latestJob['title'] : 'No jobs yet';
    $latestJobDate = $latestJob ? date('M d, Y', strtotime($latestJob['date_time'])) : 'N/A';

    // ... Analytics logic ...
    $allJobs = fetchJobs($pdo);
    $currentYear = date('Y');
    $currentDate = new DateTime();
    $yearlyCounts = array_fill(0, 12, 0); 
    $monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    $monthlyLabels = [];
    $monthlyCounts = [];
    for ($i = 5; $i >= 0; $i--) {
        $d = clone $currentDate;
        $d->modify("-$i months");
        $monthlyLabels[] = $d->format('M Y');
        $monthlyCounts[$d->format('Y-m')] = 0;
    }
    $weeklyLabels = [];
    $weeklyCounts = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = clone $currentDate;
        $d->modify("-$i days");
        $weeklyLabels[] = $d->format('D');
        $weeklyCounts[$d->format('Y-m-d')] = 0;
    }
    $typeCounts = ['Full-Time' => 0, 'Hybrid' => 0, 'On-site' => 0];

    foreach ($allJobs as $job) {
        $jobDate = new DateTime($job['date_time']);
        $jobYear = (int)$jobDate->format('Y');
        $jobMonthIndex = (int)$jobDate->format('m') - 1;
        $jobYM = $jobDate->format('Y-m');
        $jobYMD = $jobDate->format('Y-m-d');
        $jobType = $job['job_type'] ?? 'Full-Time';

        if ($jobYear == $currentYear) $yearlyCounts[$jobMonthIndex]++;
        if (isset($monthlyCounts[$jobYM])) $monthlyCounts[$jobYM]++;
        if (isset($weeklyCounts[$jobYMD])) $weeklyCounts[$jobYMD]++;
        if (isset($typeCounts[$jobType])) $typeCounts[$jobType]++;
    }

    echo json_encode([
        'status' => 'success',
        'data' => [
            'total_jobs' => $totalJobs,
            'total_admins' => $totalAdmins,
            'latest_job' => [
                'title' => $latestJobTitle,
                'date' => $latestJobDate
            ],
            'yearly' => ['labels' => $monthNames, 'counts' => $yearlyCounts],
            'monthly' => ['labels' => $monthlyLabels, 'counts' => array_values($monthlyCounts)],
            'weekly' => ['labels' => $weeklyLabels, 'counts' => array_values($weeklyCounts)],
            'types' => $typeCounts
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    // This will help us see if there is an error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>