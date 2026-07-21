// File: C:\xampp\htdocs\qsi_inc\admin\js\joblist.js (or wherever your JS is)

let refreshInterval;
let lastJobCount = 0; // Track the number of jobs to detect changes

document.addEventListener('DOMContentLoaded', () => {
    // 1. Load jobs immediately
    loadJobs();

    // 2. Start realtime polling (every 5 seconds)
    startRealtimeUpdates();

    // 3. Attach SweetAlert2 to the "Add Job" button
    const addJobBtn = document.getElementById('addJobBtn');
    if (addJobBtn) {
        addJobBtn.addEventListener('click', showAddJobPopup);
    }
});

function startRealtimeUpdates() {
    if (refreshInterval) clearInterval(refreshInterval);
    refreshInterval = setInterval(() => {
        loadJobs(true); // true = background update (silent check)
    }, 5000);
}

// --- SWEETALERT2 POPUP ---
function showAddJobPopup() {
    Swal.fire({
        title: 'Add New Job',
        html: `
            <input id="swal-title" class="swal2-input" placeholder="Job Title" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
            <textarea id="swal-desc" class="swal2-textarea" placeholder="Job Description" style="width: 100%; box-sizing: border-box; margin: 0.5em 0; resize: vertical;"></textarea>
            <input id="swal-salary" type="number" class="swal2-input" placeholder="Salary (e.g., 50000)" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#0a5d3c', // Green
        cancelButtonColor: '#d33',     // Red
        focusConfirm: false,
        preConfirm: () => {
            const title = document.getElementById('swal-title').value.trim();
            const description = document.getElementById('swal-desc').value.trim();
            const salary = document.getElementById('swal-salary').value.trim();

            if (!title) {
                Swal.showValidationMessage('Job Title is required');
                return false;
            }

            return { title, description, salary };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveJob(result.value);
        }
    });
}

// --- SAVE JOB (POST) ---
async function saveJob(jobData) {
    Swal.fire({
        title: 'Saving...',
        didOpen: () => { Swal.showLoading(); }
    });

    try {
        const response = await fetch('backend/handle-joblist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(jobData)
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: result.message,
                timer: 1500,
                showConfirmButton: false
            });
            // Force a full refresh after saving to show the new job immediately
            lastJobCount = 0; 
            loadJobs(); 
        } else {
            throw new Error(result.message || 'Failed to save job');
        }
    } catch (error) {
        console.error('Save error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    }
}

// --- FETCH JOBS (GET) ---
async function loadJobs(isBackgroundUpdate = false) {
    const tableBody = document.getElementById('jobTableBody');
    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');
    const totalCount = document.getElementById('totalJobsCount');

    // Only show loading spinner on the very first load
    if (!isBackgroundUpdate && !lastJobCount) {
        if (loadingState) loadingState.classList.remove('hidden');
        if (emptyState) emptyState.classList.add('hidden');
    }

    try {
        const response = await fetch('backend/handle-joblist.php');
        
        if (!response.ok) throw new Error('Network response was not ok');

        const result = await response.json();

        // Hide loading state after first successful fetch
        if (!isBackgroundUpdate && loadingState) {
            loadingState.classList.add('hidden');
        }

        if (result.status === 'success') {
            const currentCount = result.data.length;

            // UPDATE COUNT DISPLAY ALWAYS
            if (totalCount) totalCount.textContent = currentCount;

            // ONLY REDRAW TABLE IF DATA HAS CHANGED
            // This prevents the "pinging/flickering" effect
            if (currentCount !== lastJobCount || !isBackgroundUpdate) {
                
                tableBody.innerHTML = ''; // Clear existing rows
                
                if (currentCount > 0) {
                    if (emptyState) emptyState.classList.add('hidden');

                    result.data.forEach(job => {
                        const row = document.createElement('tr');
                        row.className = "border-b border-slate-100 hover:bg-slate-50 transition";
                        
                        const formattedDate = new Date(job.date_time).toLocaleDateString('en-US', {
                            year: 'numeric', month: 'short', day: 'numeric'
                        });

                        row.innerHTML = `
                            <td class="p-3 font-medium text-slate-500">#${job.job_id}</td>
                            <td class="p-3 font-semibold text-slate-800">${escapeHtml(job.title)}</td>
                            <td class="p-3 text-slate-600 max-w-xs truncate" title="${escapeHtml(job.description)}">${escapeHtml(job.description)}</td>
                            <td class="p-3 text-slate-700 font-medium">₱${Number(job.salary || 0).toLocaleString()}</td>
                            <td class="p-3 text-slate-500">${formattedDate}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    // Show empty state if no jobs
                    if (emptyState) emptyState.classList.remove('hidden');
                }
                
                // Update the tracker so we know the current state
                lastJobCount = currentCount;
            }
        }
    } catch (error) {
        console.error('Error fetching jobs:', error);
        // Only show error in UI if it's the first load
        if (!isBackgroundUpdate && !lastJobCount && loadingState) {
            loadingState.classList.add('hidden');
            tableBody.innerHTML = `<tr><td colspan="5" class="p-4 text-red-500 text-center">Error loading data. Check console.</td></tr>`;
        }
    }
}

// Helper to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}