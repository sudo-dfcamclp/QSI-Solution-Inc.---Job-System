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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-slate-100">
    <?php include 'navigation/nav.php'; ?>
    
    <!-- Main Container -->
    <div class="flex items-center justify-center p-6">
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] px-8 py-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-white">Job Listing</h1>
                
                <!-- Changed from <a> to <button> for JS trigger -->
                <button id="addJobBtn" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-medium px-4 py-2.5 rounded-xl transition duration-300 backdrop-blur-sm border border-white/20 shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Job</span>
                </button>
            </div>

 <div class="p-8">
    <!-- Stats Boxes -->
    <!-- Increased mb-8 to mb-12 to add more space below this section -->
    <div class="grid grid-cols-1 gap-4 mb-12">
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
                <p id="totalJobsCount" class="text-2xl font-bold text-[#0a5d3c]">0</p>
                <p class="text-xs text-green-600">Total</p>
            </div>
        </div>
    </div>

    <!-- Job List Container (Populated by JS) -->
    <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Recent Jobs</h3>
        <div id="loadingState" class="text-center py-8 text-slate-500">
            <i class="fa-solid fa-circle-notch fa-spin text-2xl"></i> Loading jobs...
        </div>
        <div id="emptyState" class="hidden text-center py-8 text-slate-500">
            No jobs found. Click "Add Job" to create one.
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 text-sm border-b border-slate-200">
                        <th class="p-3 font-semibold">ID</th>
                        <th class="p-3 font-semibold">Title</th>
                        <th class="p-3 font-semibold">Description</th>
                        <th class="p-3 font-semibold">Salary</th>
                        <th class="p-3 font-semibold">Date Posted</th>
                        <th class="p-3 font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="jobTableBody" class="text-sm text-slate-700">
                    <!-- Rows will be injected here by JS -->
                </tbody>
            </table>
        </div>
        
    </div>

</div> <!-- End p-8 -->


     <script src="script/joblist.js"></script>
</body>
</html>