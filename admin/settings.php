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

            <!-- Content -->
            <div class="p-8">

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <h2 class="text-xl font-semibold text-slate-800">
                            Card One
                        </h2>
                        <p class="text-slate-500 mt-3">
                            Place your content here.
                        </p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <h2 class="text-xl font-semibold text-slate-800">
                            Card Two
                        </h2>
                        <p class="text-slate-500 mt-3">
                            Modern responsive design.
                        </p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition duration-300">
                        <h2 class="text-xl font-semibold text-slate-800">
                            Card Three
                        </h2>
                        <p class="text-slate-500 mt-3">
                            Easily customize with Tailwind.
                        </p>
                    </div>

                </div>

                <!-- Large Content Box -->
                <div class="mt-8 bg-slate-50 border border-slate-200 rounded-2xl p-8">

                    <h2 class="text-2xl font-bold text-slate-800 mb-4">
                        Main Content
                    </h2>

                    <p class="text-slate-600 leading-7">
                        This area is intended for your page content, forms,
                        tables, charts, or other dashboard components.
                    </p>
    </div>

</body>
</html>