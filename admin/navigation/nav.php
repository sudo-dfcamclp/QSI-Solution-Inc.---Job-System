<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="bg-white shadow-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto h-16 px-6 flex items-center">

        <!-- Left (Logo) -->
        <div class="flex-1">
    <a href="dashboard.php" class="block ">
        <img 
            src="../assets/logo/logo2.png" 
            alt="QuestServ Inc Logo" 
            class="h-14 w-auto object-contain"
        >
    </a>
</div>

        <!-- Center (Navigation) -->
        <nav class="flex justify-center">
            <ul class="flex items-center gap-4 md:gap-8">

                <!-- Dashboard -->
                <li>
                    <a href="dashboard.php"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition
                        <?= $currentPage == 'dashboard.php'
                            ? 'bg-[#0a5d3c] text-white shadow-md'
                            : 'text-slate-700  hover:text-[#0a5d3c]'; ?>">
                        <i class="fa-solid fa-desktop"></i>
                        <span class="hidden md:inline">Dashboard</span>
                    </a>
                </li>

                <!-- Jobs -->
                <li>
                    <a href="jobs.php"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition
                        <?= $currentPage == 'jobs.php'
                            ? 'bg-[#0a5d3c] text-white shadow-md'
                            : 'text-slate-700 hover:text-[#0a5d3c]'; ?>">
                        <i class="fa-solid fa-briefcase"></i>
                        <span class="hidden md:inline">Jobs</span>
                    </a>
                </li>

                <!-- Accounts -->
                <li>
                    <a href="accounts.php"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition
                        <?= $currentPage == 'accounts.php'
                            ? 'bg-[#0a5d3c] text-white shadow-md'
                            : 'text-slate-700 hover:text-[#0a5d3c]'; ?>">
                        <i class="fa-solid fa-users"></i>
                        <span class="hidden md:inline">Accounts</span>
                    </a>
                </li>

                <!-- Settings -->
                <li>
                    <a href="settings.php"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition
                        <?= $currentPage == 'settings.php'
                            ? 'bg-[#0a5d3c] text-white shadow-md'
                            : 'text-slate-700 hover:text-[#0a5d3c]'; ?>">
                        <i class="fa-solid fa-gear"></i>
                        <span class="hidden md:inline">Settings</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Right Spacer -->
        <div class="flex-1"></div>

    </div>
</header>