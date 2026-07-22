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
    <title>Settings</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-slate-100">
    <?php include 'navigation/nav.php'; ?>
    <!-- Main Container -->
    <div class="flex items-center justify-center p-6">

        <!-- Modern Box -->
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

           <!-- Header -->
<div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] px-8 py-6 flex items-center justify-between">
    
    <!-- Title -->
    <h1 class="text-3xl font-bold text-white">
        Settings
    </h1>

    <!-- Logout Button -->
    <a href="logout.php" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-medium px-4 py-2.5 rounded-xl transition duration-300 backdrop-blur-sm border border-white/20 shadow-sm">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Logout</span>
    </a>

</div>

        <div class="p-8">
    <!-- Modern Edit Info Box -->
    <div class=" rounded-2xl p-8   transition duration-300 max-w-2xl mx-auto">
        
        <h2 class="text-xl font-semibold text-slate-800 mb-6">
            Edit Information
        </h2>

        <form id="settingsForm" class="space-y-5">
            <!-- Name Field -->
            <div>
                <label for="f_name" class="block text-sm font-medium text-slate-700 mb-1.5">First Name</label>
                <input type="text" id="f_name" name="f_name" disabled class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <div>
                <label for="l_name" class="block text-sm font-medium text-slate-700 mb-1.5">Last Name</label>
                <input type="text" id="l_name" name="l_name" disabled class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" id="email" name="email" disabled class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <!-- Contact Field -->
            <div>
                <label for="contact" class="block text-sm font-medium text-slate-700 mb-1.5">Contact</label>
                <input type="tel" id="contact" name="contact" disabled class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <hr class="border-slate-200 my-6">

            <!-- Password Section -->
            <div>
                <label for="old_password" class="block text-sm font-medium text-slate-700 mb-1.5">Old Password</label>
                <input type="password" id="old_password" name="old_password" disabled placeholder="Required to change password" class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                <input type="password" id="new_password" name="new_password" disabled placeholder="Leave blank to keep current" class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" disabled placeholder="Re-enter new password" class="form-input w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0a5d3c] focus:border-transparent transition duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <button type="button" id="actionBtn" class="w-full bg-[#0a5d3c] hover:bg-[#084a2f] text-white font-medium py-3 px-4 rounded-lg transition duration-300 shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Information</span>
                </button>
            </div>
        </form>
    </div>
</div>

</div>
   </div>
<script src="./script/settings.js"></script>
</body>
</html>