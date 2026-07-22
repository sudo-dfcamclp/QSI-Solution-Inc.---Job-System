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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-blue-600">Total Jobs</h3>
                                <p class="text-3xl font-bold text-slate-800 mt-2" id="totalJobsStat">156</p>
                            </div>
                            <div class="bg-blue-500/20 p-3 rounded-xl">
                                <i class="fa-solid fa-briefcase text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-xs text-blue-500 mt-3"><i class="fa-solid fa-arrow-up mr-1"></i>12% from last month</p>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-emerald-600">Applicants</h3>
                                <p class="text-3xl font-bold text-slate-800 mt-2" id="totalApplicantsStat">1,248</p>
                            </div>
                            <div class="bg-emerald-500/20 p-3 rounded-xl">
                                <i class="fa-solid fa-users text-emerald-600 text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-xs text-emerald-500 mt-3"><i class="fa-solid fa-arrow-up mr-1"></i>8% from last month</p>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-purple-600">Hired</h3>
                                <p class="text-3xl font-bold text-slate-800 mt-2" id="totalHiredStat">42</p>
                            </div>
                            <div class="bg-purple-500/20 p-3 rounded-xl">
                                <i class="fa-solid fa-user-check text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-xs text-purple-500 mt-3"><i class="fa-solid fa-arrow-up mr-1"></i>15% from last month</p>
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