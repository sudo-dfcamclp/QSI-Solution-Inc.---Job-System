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
            
            <!-- Job Type Dropdown -->
            <select id="swal-job-type" class="swal2-input" style="width: 100%; box-sizing: border-box; margin: 0.5em 0; background-color: white;">
                <option value="" disabled selected>Select Job Type</option>
                <option value="Full-Time">Full-Time</option>
                <option value="Hybrid">Hybrid</option>
                <option value="On-site">On-site</option>
            </select>

            <input id="swal-salary" type="number" class="swal2-input" placeholder="Salary (e.g., 50000)" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
            <input id="swal-location" class="swal2-input" placeholder="Location" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
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
            const location = document.getElementById('swal-location').value.trim();
            const job_type = document.getElementById('swal-job-type').value; // Get selected job type

            if (!title) {
                Swal.showValidationMessage('Job Title is required');
                return false;
            }
            if (!location) {
                Swal.showValidationMessage('Location is required');
                return false;
            }
            if (!job_type) {
                Swal.showValidationMessage('Please select a Job Type');
                return false;
            }

            return { title, description, salary, location, job_type };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveJob(result.value);
        }
    });
}

// --- SWEETALERT2 POPUP FOR EDITING ---
function editJob(job) {
    // Determine current job type to set as selected (default to 'Full-Time' if missing)
    const currentType = job.job_type || 'Full-Time'; 

    Swal.fire({
        title: 'Edit Job',
        html: `
            <input id="edit-title" class="swal2-input" value="${escapeHtml(job.title)}" placeholder="Job Title" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
            <textarea id="edit-desc" class="swal2-textarea" placeholder="Job Description" style="width: 100%; box-sizing: border-box; margin: 0.5em 0; resize: vertical;">${escapeHtml(job.description1)}</textarea>
            
            <!-- Job Type Dropdown for Editing -->
            <select id="edit-job-type" class="swal2-input" style="width: 100%; box-sizing: border-box; margin: 0.5em 0; background-color: white;">
                <option value="Full-Time" ${currentType === 'Full-Time' ? 'selected' : ''}>Full-Time</option>
                <option value="Hybrid" ${currentType === 'Hybrid' ? 'selected' : ''}>Hybrid</option>
                <option value="On-site" ${currentType === 'On-site' ? 'selected' : ''}>On-site</option>
            </select>

            <input id="edit-salary" type="number" class="swal2-input" value="${job.salary1}" placeholder="Salary" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
            <input id="edit-location" class="swal2-input" value="${escapeHtml(job.location1)}" placeholder="Location" style="width: 100%; box-sizing: border-box; margin: 0.5em 0;">
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
            const location = document.getElementById('edit-location').value.trim();
            const job_type = document.getElementById('edit-job-type').value; // Get selected job type

            if (!title) {
                Swal.showValidationMessage('Job Title is required');
                return false;
            }
            if (!location) {
                Swal.showValidationMessage('Location is required');
                return false;
            }

            return { 
                job_id: job.job_id, 
                title, 
                description, 
                salary,
                location,
                job_type 
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
                        row.className = "border-b border-slate-100 hover:bg-slate-50 transition align-middle";
                        
                        const formattedDate = new Date(job.date_time).toLocaleDateString('en-US', {
                            year: 'numeric', month: 'short', day: 'numeric'
                        });

                        row.innerHTML = `
                            <!-- 1. ID (Sobrang sipit, center) -->
                            <td class="p-3 font-medium text-slate-500 text-center" style="width: 60px; min-width: 60px;">
                                #${job.job_id}
                            </td>
                            
                            <!-- 2. Title (Limitado ang lapad, may truncate) -->
                            <td class="p-3 font-semibold text-slate-800 truncate" style="width: 100px; max-width: 140px;" title="${escapeHtml(job.title)}">
                                ${escapeHtml(job.title)}
                            </td>
                            
                            <!-- 3. Description (Limitado ang lapad, may truncate) -->
                            <td class="p-3 text-slate-600 truncate" style="width: 200px; max-width: 100px;" title="${escapeHtml(job.description1)}">
                                ${escapeHtml(job.description1)}
                            </td>
                            
                            <!-- 4. Job Type (Bagong Column, may badge style) -->
                            <td class="p-3 text-slate-500 whitespace-nowrap" style="width: 110px;">
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                    ${escapeHtml(job.job_type || 'Full-time')}
                                </span>
                            </td>
                            
                            <!-- 5. Location -->
                            <td class="p-3 text-slate-500 whitespace-nowrap truncate" style="width: 130px; max-width: 130px;" title="${escapeHtml(job.location1)}">
                                ${escapeHtml(job.location1)}
                            </td>
                            
                            <!-- 6. Salary -->
                            <td class="p-3 text-slate-700 font-medium whitespace-nowrap" style="width: 120px;">
                                ₱${Number(job.salary1 || 0).toLocaleString()}
                            </td>
                            
                            <!-- 7. Date Posted -->
                            <td class="p-3 text-slate-500 whitespace-nowrap" style="width: 110px;">
                                ${formattedDate}
                            </td>
                            
                                            <!-- 8. Actions (Bigger buttons) -->
                        <td class="p-3 text-center" style="width: 120px; min-width: 120px;">
                            <div class="flex items-center justify-center gap-3">
                                <!-- Edit Button -->
                                <button onclick='editJob(${JSON.stringify(job)})' 
                                    class="text-blue-600 hover:text-blue-800 hover:bg-blue-100 p-2 rounded-lg transition duration-200 " 
                                    title="Edit Job">
                                    <i class="fa-solid fa-pen-to-square text-xl"></i>
                                </button>

                                <!-- Delete Button -->
                                <button onclick="deleteJob(${job.job_id})" 
                                    class="text-red-600 hover:text-red-800 hover:bg-red-100 p-2 rounded-lg transition duration-200 " 
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
            // Updated colspan to 8 dahil 8 columns na ngayon
            tableBody.innerHTML = `<tr><td colspan="8" class="p-4 text-red-500 text-center">Error loading data. Check console.</td></tr>`;
        }
    }
}

// Helper to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}