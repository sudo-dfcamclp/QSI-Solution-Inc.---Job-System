// ============================================
// DASHBOARD - Buttons, UI, Stat Counters
// Path: C:\xampp\htdocs\qsi_inc\admin\script\dashboard.js
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    initDashboardUI();
    initializeCharts(); // From analytics.js
    updateStatCards(); // Load stats
});

function initDashboardUI() {
    const btnWeek = document.getElementById('btnWeek');
    const btnMonth = document.getElementById('btnMonth');
    const btnYear = document.getElementById('btnYear');

    if (btnWeek) btnWeek.addEventListener('click', () => handlePeriodChange('week', btnWeek, btnMonth, btnYear));
    if (btnMonth) btnMonth.addEventListener('click', () => handlePeriodChange('month', btnWeek, btnMonth, btnYear));
    if (btnYear) btnYear.addEventListener('click', () => handlePeriodChange('year', btnWeek, btnMonth, btnYear));
}

function handlePeriodChange(period, btnW, btnM, btnY) {
    const inactiveClass = "px-4 py-1.5 text-xs font-semibold bg-white text-slate-600 border border-slate-200 rounded-md hover:bg-slate-50 transition shadow-sm";
    const activeClass = "px-4 py-1.5 text-xs font-semibold bg-emerald-600 text-white rounded-md shadow-sm transition";

    btnW.className = inactiveClass;
    btnM.className = inactiveClass;
    btnY.className = inactiveClass;

    if (period === 'week') btnW.className = activeClass;
    if (period === 'month') btnM.className = activeClass;
    if (period === 'year') btnY.className = activeClass;

    renderLineChart(period);
}

function animateCounter(elementId, target) {
    const el = document.getElementById(elementId);
    if (!el) return;

    let current = 0;
    const increment = Math.max(1, Math.floor(target / 30));
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        el.textContent = current;
    }, 30);
}

async function updateStatCards() {
    try {
        // We can use the cached data from analytics.js if available, or fetch again
        // For simplicity, let's fetch again to ensure stats are fresh
        const response = await fetch('backend/handle-dashboard.php');
        if (!response.ok) throw new Error('Network error');
        
        const result = await response.json();
        
        if (result.status === 'success') {
            const data = result.data;
            animateCounter('statTotalJobs', data.total);
            animateCounter('statFullTime', data.types['Full-Time'] || 0);
            animateCounter('statHybrid', data.types['Hybrid'] || 0);
            animateCounter('statOnsite', data.types['On-site'] || 0);
        }
    } catch (error) {
        console.error('Error updating stats:', error);
    }
}

// ============================================
// UPDATE STAT CARDS (Realtime)
// ============================================
async function updateStatCards() {
    try {
        const response = await fetch('backend/handle-dashboard.php');
        if (!response.ok) throw new Error('Network error');
        
        const result = await response.json();
        
        if (result.status === 'success') {
            const data = result.data;
            
            // 1. Animate Total Jobs
            animateCounter('statTotalJobs', data.total_jobs);
            
            // 2. Animate Total Admins
            animateCounter('statTotalAdmins', data.total_admins);
            
            // 3. Update Latest Job Title (Text, no animation needed)
            const titleEl = document.getElementById('statLatestJobTitle');
            if (titleEl) {
                titleEl.textContent = data.latest_job.title;
                titleEl.title = data.latest_job.title; // Shows full text on hover if truncated
            }
            
            // 4. Update Latest Job Date
            const dateEl = document.getElementById('statLatestJobDate');
            if (dateEl) {
                dateEl.textContent = data.latest_job.date;
            }
        }
    } catch (error) {
        console.error('Error updating stats:', error);
    }
}

// Ensure this runs on page load
document.addEventListener('DOMContentLoaded', () => {
    initDashboardUI();
    initializeCharts(); // From analytics.js
    updateStatCards();  // Fetch and render summary cards
});