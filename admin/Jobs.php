<?php
session_start();

if (!isset($_SESSION['user_id'])) {   
    header("Location: login.php"); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job List</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="min-h-screen bg-slate-100">
    <?php include 'navigation/nav.php'; ?>
    <!-- Main Container -->
    <div class="flex items-center justify-center  p-6">

        <!-- Modern Box -->
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

<div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] px-8 py-6 flex items-center justify-between">
    
    <h1 class="text-3xl font-bold text-white">
        Job Listing
    </h1>

    <a href="add-job.php" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-medium px-4 py-2.5 rounded-xl transition duration-300 backdrop-blur-sm border border-white/20 shadow-sm">
        <i class="fa-solid fa-plus"></i>
        <span>Add Job</span>
    </a>

</div>

<div class="p-8">

<div class="p-8">

    <div class="grid grid-cols-1 gap-4">

        <!-- Box 1: Active Job Postings -->
        <div class="bg-white border-l-4 border-[#0a5d3c] border-y border-r border-slate-200 rounded-r-xl p-5 hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-briefcase text-xl text-[#0a5d3c]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Active Job Postings</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Currently open positions</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-[#0a5d3c]">24</p>
                <p class="text-xs text-green-600">+3 this week</p>
            </div>
        </div>

        <!-- Box 2: New Applications -->
        <div class="bg-white border-l-4 border-blue-500 border-y border-r border-slate-200 rounded-r-xl p-5 hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-file-signature text-xl text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">New Applications</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Unreviewed applicant submissions</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">148</p>
                <p class="text-xs text-orange-500">12 need review</p>
            </div>
        </div>
    </div>

</body>
</html>