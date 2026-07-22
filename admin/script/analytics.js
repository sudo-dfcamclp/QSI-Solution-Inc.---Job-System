// ============================================
// ANALYTICS - Chart Rendering & Data Fetching
// Path: C:\xampp\htdocs\qsi_inc\admin\script\analytics.js
// ============================================

// 1. DECLARE ALL CHART INSTANCES HERE (Fixed the error)
let lineChartInstance = null;
let barChartInstance = null;
let pieChartInstance = null;

let cachedAnalyticsData = null;

// ============================================
// FETCH DATA FROM BACKEND
// ============================================
async function fetchAnalyticsData() {
    try {
        const response = await fetch('backend/handle-dashboard.php');
        if (!response.ok) throw new Error('Network error');
        
        const result = await response.json();
        
        if (result.status === 'success') {
            cachedAnalyticsData = result.data;
            return result.data;
        }
    } catch (error) {
        console.error('Error fetching analytics:', error);
        return null;
    }
}

// ============================================
// LINE CHART
// ============================================
function renderLineChart(period) {
    if (!cachedAnalyticsData) return;

    const ctx = document.getElementById('lineChart');
    if (!ctx) return;

    // Destroy existing chart
    if (lineChartInstance) lineChartInstance.destroy();

    let labels = [];
    let counts = [];

    if (period === 'week') {
        labels = cachedAnalyticsData.weekly.labels;
        counts = cachedAnalyticsData.weekly.counts;
    } else if (period === 'month') {
        labels = cachedAnalyticsData.monthly.labels;
        counts = cachedAnalyticsData.monthly.counts;
    } else if (period === 'year') {
        labels = cachedAnalyticsData.yearly.labels;
        counts = cachedAnalyticsData.yearly.counts;
    }

    // Smart Max with "Puwang"
    const maxDataValue = Math.max(...counts, 0);
    let niceMax = 10;
    
    if (maxDataValue > 0) {
        if (maxDataValue <= 10) niceMax = 10;
        else if (maxDataValue <= 20) niceMax = 20;
        else if (maxDataValue <= 50) niceMax = 50;
        else if (maxDataValue <= 100) niceMax = 100;
        else niceMax = Math.ceil(maxDataValue * 1.2);
    }

    lineChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jobs Posted',
                data: counts,
                borderColor: '#0a5d3c',
                backgroundColor: 'rgba(10, 93, 60, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0a5d3c',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 800, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.y} Jobs Posted`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: niceMax,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
}

// ============================================
// BAR CHART
// ============================================
function renderBarChart(fullTime, hybrid, onsite) {
    const ctx = document.getElementById('barChart');
    if (!ctx) return;

    // Destroy existing chart
    if (barChartInstance) barChartInstance.destroy();

    barChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Full-Time', 'Hybrid', 'On-site'],
            datasets: [{
                label: 'Number of Jobs',
                data: [fullTime, hybrid, onsite],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(249, 115, 22, 0.8)'
                ],
                borderColor: [
                    'rgb(34, 197, 94)',
                    'rgb(168, 85, 247)',
                    'rgb(249, 115, 22)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
}

// ============================================
// PIE CHART
// ============================================
function renderPieChart(fullTime, hybrid, onsite) {
    const ctx = document.getElementById('pieChart');
    if (!ctx) return;

    // Destroy existing chart
    if (pieChartInstance) pieChartInstance.destroy();

    const total = fullTime + hybrid + onsite;

    pieChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Full-Time', 'Hybrid', 'On-site'],
            datasets: [{
                data: [fullTime, hybrid, onsite],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.85)',
                    'rgba(168, 85, 247, 0.85)',
                    'rgba(249, 115, 22, 0.85)'
                ],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '55%',
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return ` ${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// ============================================
// INITIALIZE ALL CHARTS
// ============================================
async function initializeCharts() {
    const data = await fetchAnalyticsData();
    
    if (data) {
        // Render line chart with default period (month)
        renderLineChart('month');
        
        // Render bar and pie charts
        renderBarChart(
            data.types['Full-Time'] || 0,
            data.types['Hybrid'] || 0,
            data.types['On-site'] || 0
        );
        renderPieChart(
            data.types['Full-Time'] || 0,
            data.types['Hybrid'] || 0,
            data.types['On-site'] || 0
        );
    }
}