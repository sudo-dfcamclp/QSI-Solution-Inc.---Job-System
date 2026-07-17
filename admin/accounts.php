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
    <title>Accounts</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="min-h-screen bg-slate-100">
    <?php include 'navigation/nav.php'; ?>
    <!-- Main Container -->
    <div class="flex items-center justify-center  p-6">

        <!-- Modern Box -->
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r  from-[#0a5d3c] to-[#0d9488] px-8 py-6">
                <h1 class="text-3xl font-bold text-white">
                    Account Management
                </h1>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Large Content Box -->
              <div class="mt-8 bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">User Management</h2>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="hidden text-center py-10">
        <p class="text-slate-500">Loading users...</p>
    </div>

    <!-- Table Container -->
<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Name</th>
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Email</th>
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Contact</th>
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider">Type</th>
                <th class="p-4 text-sm font-semibold text-slate-600 uppercase tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody" class="divide-y divide-slate-100">
            <!-- Data will be inserted here by JavaScript -->
        </tbody>
    </table>
</div>
    
    <!-- Empty State -->
    <div id="emptyState" class="hidden text-center py-10">
        <p class="text-slate-500">No users found.</p>
    </div>
</div>

<!-- Include the JS file at the bottom of your body -->
    <script src="script/account.js"></script>

            </div>

        </div>

    </div>

</body>
</html>