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
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-300 max-w-2xl mx-auto">
        
        <h2 class="text-xl font-semibold text-slate-800 mb-6">
            Edit Information
        </h2>

        <form class="space-y-5">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
                <input type="text" id="name" placeholder="Enter your name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" id="email" placeholder="Enter your email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Contact Field -->
            <div>
                <label for="contact" class="block text-sm font-medium text-slate-700 mb-1.5">Contact</label>
                <input type="tel" id="contact" placeholder="Enter your contact number" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Save Button -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-3 px-4 rounded-lg transition duration-300 shadow-sm">
                    Save Changes
                </button>
            </div>
        </form>

    </div>

</div>
   </div>

</body>
</html>