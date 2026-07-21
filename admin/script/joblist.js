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

// --- SWEETALERT2 POPUP FOR ADDING ---
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
        confirmButtonColor: '#0a5d3c',
        cancelButtonColor: '#d33',
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

// --- SWEETALERT2 POPUP FOR EDITING (THIS WAS MISSING!) ---
function editJob(job) {
    Swal.fire({
        title: 'Edit Job',
        html: `
            <input id="edit-title" class="swal2-input" value="${escapeHtml(job.title)}" placeholder="Job Title" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
            <textarea id="edit-desc" class="swal2-textarea" placeholder="Job Description" style="width: 100%; box-sizing: border-box; margin: 0.5em 0; resize: vertical;">${escapeHtml(job.description)}</textarea>
            <input id="edit-salary" type="number" class="swal2-input" value="${job.salary}" placeholder="Salary" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#0a5d3c',
        cancelButtonColor: '#64748b',
        focusConfirm: false,
        preConfirm: () => {
            const title = document.getElementById('edit-title').value.trim();
            const description = document.getElementById('edit-desc').value.trim();
            const salary = document.getElementById('edit-salary').value.trim();

            if (!title) {
                Swal.showValidationMessage('Job Title is required');
                return false;
            }
            return { 
                job_id: job.job_id, 
                title, 
                description, 
                salary 
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveUpdate(result.value);
        }
    });
}

// --- SAVE NEW JOB (POST) ---
async function saveJob(jobData) {
    Swal.fire({ title: 'Saving...', didOpen: () => { Swal.showLoading(); } });

    try {
        const response = await fetch('backend/handle-joblist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(jobData)
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Success!', text: result.message, timer: 1500, showConfirmButton: false });
            lastJobCount = 0; 
            loadJobs(); 
        } else {
            throw new Error(result.message || 'Failed to save job');
        }
    } catch (error) {
        console.error('Save error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: error.message });
    }
}

// --- UPDATE EXISTING JOB (PUT) ---
async function saveUpdate(jobData) {
    Swal.fire({ title: 'Updating...', didOpen: () => { Swal.showLoading(); } });

    try {
        const response = await fetch('backend/handle-joblist.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(jobData)
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Updated!', text: result.message, timer: 1500, showConfirmButton: false });
            lastJobCount = 0; 
            loadJobs(); 
        } else {
            throw new Error(result.message || 'Failed to update job');
        }
    } catch (error) {
        console.error('Update error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: error.message });
    }
}

// --- DELETE JOB (DELETE) ---
async function deleteJob(jobId) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!'
    });

    if (result.isConfirmed) {
        Swal.fire({ title: 'Deleting...', didOpen: () => { Swal.showLoading(); } });

        try {
            const response = await fetch('backend/handle-joblist.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ job_id: jobId })
            });

            const data = await response.json();

            if (data.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Deleted!', text: data.message, timer: 1500, showConfirmButton: false });
                lastJobCount = 0; 
                loadJobs();
            } else {
                throw new Error(data.message || 'Failed to delete job');
            }
        } catch (error) {
            console.error('Delete error:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: error.message || 'An unexpected error occurred.' });
        }
    }
}

// --- FETCH JOBS (GET) ---
async function loadJobs(isBackgroundUpdate = false) {
    const tableBody = document.getElementById('jobTableBody');
    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');
    const totalCount = document.getElementById('totalJobsCount');

    if (!isBackgroundUpdate && !lastJobCount) {
        if (loadingState) loadingState.classList.remove('hidden');
        if (emptyState) emptyState.classList.add('hidden');
    }

    try {
        const response = await fetch('backend/handle-joblist.php');
        
        if (!response.ok) throw new Error('Network response was not ok');

        const result = await response.json();

        if (!isBackgroundUpdate && loadingState) {
            loadingState.classList.add('hidden');
        }

        if (result.status === 'success') {
            const currentCount = result.data.length;

            if (totalCount) totalCount.textContent = currentCount;

            if (currentCount !== lastJobCount || !isBackgroundUpdate) {
                
                tableBody.innerHTML = ''; 
                
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
                            <td class="p-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <button onclick='editJob(${JSON.stringify(job)})' 
                                        class="text-blue-500 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition duration-200" 
                                        title="Edit Job">
                                        <i class="fa-solid fa-pen-to-square text-xl"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button onclick="deleteJob(${job.job_id})" 
                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition duration-200" 
                                        title="Delete Job">
                                        <i class="fa-solid fa-trash-can text-xl"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    if (emptyState) emptyState.classList.remove('hidden');
                }
                
                lastJobCount = currentCount;
            }
        }
    } catch (error) {
        console.error('Error fetching jobs:', error);
        if (!isBackgroundUpdate && !lastJobCount && loadingState) {
            loadingState.classList.add('hidden');
            tableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-red-500 text-center">Error loading data. Check console.</td></tr>`;
        }
    }
}

// Helper to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}