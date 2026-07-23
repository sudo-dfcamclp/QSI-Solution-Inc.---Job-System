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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>

<body class="min-h-screen bg-slate-100">
    <?php include 'navigation/nav.php'; ?>
    
    <!-- Main Container -->
    <div class="flex items-center justify-center p-6">

        <!-- Modern Box -->
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] px-8 py-6">
                <h1 class="text-3xl font-bold text-white">
                    Analytics Dashboard
                </h1>
            </div>

            <!-- Content -->
            <div class="p-8">

                            <!-- Summary Cards -->
               <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                
                <!-- 1. Total Jobs -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-blue-600">Total Jobs</h3>
                            <p class="text-3xl font-bold text-slate-800 mt-2" id="statTotalJobs">0</p>
                        </div>
                        <div class="bg-blue-500/20 p-3 rounded-xl">
                            <i class="fa-solid fa-briefcase text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- 2. Total Admins -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-emerald-600">Total Admins</h3>
                            <p class="text-3xl font-bold text-slate-800 mt-2" id="statTotalAdmins">0</p>
                        </div>
                        <div class="bg-emerald-500/20 p-3 rounded-xl">
                            <i class="fa-solid fa-user-shield text-emerald-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- 3. Latest Job Post (Combined Title & Date) -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between">
                        <!-- Text Content -->
                        <div class="overflow-hidden pr-4">
                            <h3 class="text-sm font-medium text-purple-600">Latest Job Post</h3>
                            <p class="text-lg font-bold text-slate-800 mt-1 truncate" id="statLatestJobTitle" title="No jobs yet">No jobs yet</p>
                            
                            <!-- Date Posted -->
                            <div class="flex items-center gap-2 mt-2 text-sm text-slate-600">
                                <i class="fa-solid fa-calendar-day text-purple-500"></i>
                                <span id="statLatestJobDate">N/A</span>
                            </div>
                        </div>
                        
                        <!-- Icon -->
                        <div class="bg-purple-500/20 p-3 rounded-xl flex-shrink-0">
                            <i class="fa-solid fa-star text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

            
                </div>

                        <!-- Filter Buttons -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-slate-800">
                        <i class="fa-solid fa-chart-line text-[#0a5d3c] mr-2"></i>Job Postings Over Time
                    </h2>
                    
                    <!-- Added IDs: btnWeek, btnMonth, btnYear -->
                    <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                        <button id="btnWeek" class="px-4 py-1.5 text-xs font-semibold bg-white text-slate-600 border border-slate-200 rounded-md hover:bg-slate-50 transition shadow-sm">Week</button>
                        <button id="btnMonth" class="px-4 py-1.5 text-xs font-semibold bg-emerald-600 text-white rounded-md shadow-sm transition">Month</button>
                        <button id="btnYear" class="px-4 py-1.5 text-xs font-semibold bg-white text-slate-600 border border-slate-200 rounded-md hover:bg-slate-50 transition shadow-sm">Year</button>
                    </div>
                </div>

                <!-- Line Graph Container -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300 mb-8">
                    <div class="relative" style="height: 320px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                            <!-- Two Boxes Horizontal (Bottom Section - Bar Chart & Pie Chart) -->
                <!-- Changed gap-8 to gap-12 for more space between the boxes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    <!-- Left Box - Bar Chart -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-slate-800">
                                Jobs by Category
                            </h2>
                            <i class="fa-solid fa-ellipsis-vertical text-slate-400 cursor-pointer hover:text-slate-600"></i>
                        </div>
                        <div class="h-72 relative">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>

            <!-- Right Box - Pie Chart -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-slate-800">
                        Job Type Distribution
                    </h2>
                    <i class="fa-solid fa-ellipsis-vertical text-slate-400 cursor-pointer hover:text-slate-600"></i>
                </div>
                <div class="h-72 flex items-center justify-center relative">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

         </div>

     </div>

 </div>

    <!-- Include the Dashboard JavaScript -->
    <script src="script/analytics.js"></script>
    <script src="script/dashboard.js"></script>
</body>
</html>