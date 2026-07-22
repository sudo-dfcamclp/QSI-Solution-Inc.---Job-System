let refreshInterval; // Variable to store the timer

document.addEventListener('DOMContentLoaded', () => {
    loadUsers(); // Load immediately on page load

    // Start realtime polling (every 5 seconds)
    startRealtimeUpdates();

    // Manual refresh button logic
    const refreshBtn = document.getElementById('refreshUsers');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            loadUsers();
            // Reset the timer so it doesn't double-fetch immediately after clicking
            clearInterval(refreshInterval);
            startRealtimeUpdates();
        });
    }
});

function startRealtimeUpdates() {
    // Clear any existing interval to prevent duplicates
    if (refreshInterval) clearInterval(refreshInterval);
    
    // Fetch data every 5000 milliseconds (5 seconds)
    refreshInterval = setInterval(() => {
        loadUsers(true); // Pass 'true' to indicate it's a background update
    }, 5000);
}

async function loadUsers(isBackgroundUpdate = false) {
    const tableBody = document.getElementById('userTableBody');
    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');

    // Only show loading spinner if it's NOT a background update
    if (!isBackgroundUpdate) {
        tableBody.innerHTML = '';
        if (loadingState) loadingState.classList.remove('hidden');
        if (emptyState) emptyState.classList.add('hidden');
    }

    try {
        // Call the PHP backend
        const response = await fetch('backend/handle-account.php');
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();

        if (!isBackgroundUpdate && loadingState) {
            loadingState.classList.add('hidden');
        }

        if (result.status === 'success' && result.data.length > 0) {
            tableBody.innerHTML = ''; // Clear current rows
            
            result.data.forEach(user => {
                const row = document.createElement('tr');
                row.className = "hover:bg-slate-50 transition";
                
                // Determine badge color based on status
                let statusBadgeClass = 'bg-gray-100 text-gray-800'; // Default
                if (user.status === 'active') {
                    statusBadgeClass = 'bg-green-100 text-green-800';
                } else if (user.status === 'pending') {
                    statusBadgeClass = 'bg-yellow-100 text-yellow-800';
                } else if (user.status === 'banned' || user.status === 'inactive') {
                    statusBadgeClass = 'bg-red-100 text-red-800';
                }

                row.innerHTML = `
                    <td class="p-4">
                        <div class="font-medium text-slate-800">${escapeHtml(user.f_name)} ${escapeHtml(user.l_name)}</div>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ${statusBadgeClass} capitalize">
                            ${escapeHtml(user.status)}
                        </span>
                    </td>
                    <td class="p-4 text-slate-600 capitalize">
                        ${escapeHtml(user.user_type)}
                    </td>
                    <td class="p-4 text-right">
                            <!-- Edit Icon Button -->
                            <button onclick="editUser(${user.user_id}, '${escapeHtml(user.user_type)}')" 
                                class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-lg transition duration-200" 
                                title="Edit User Type">
                                <i class="fa-solid fa-pen-to-square text-2xl"></i> <!-- Changed from text-lg to text-xl -->
                            </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            if (!isBackgroundUpdate || tableBody.children.length === 0) {
                if (emptyState) emptyState.classList.remove('hidden');
            }
        }

    } catch (error) {
        console.error('Error fetching users:', error);
        if (!isBackgroundUpdate) {
            if (loadingState) loadingState.classList.add('hidden');
            // Updated colspan to 4 to match the 4 columns in your HTML
            tableBody.innerHTML = `<tr><td colspan="4" class="p-4 text-red-500 text-center">Error loading data. Check console.</td></tr>`;
        }
    }
}

// ============================================
// SWEETALERT2: EDIT USER TYPE
// ============================================
function editUser(userId, currentType) {
    Swal.fire({
        title: 'Edit User Type',
        html: `
            <label class="block text-left text-sm font-medium text-slate-700 mb-1">Select User Type</label>
            <select id="swal-user-type" class="swal2-input" style="width: 100%; box-sizing: border-box; margin: 0; background-color: white;">
                <option value="user" ${currentType === 'user' ? 'selected' : ''}>User</option>
                <option value="admin" ${currentType === 'admin' ? 'selected' : ''}>Admin</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#0a5d3c',
        cancelButtonColor: '#d33',
        focusConfirm: false,
        preConfirm: () => {
            const userType = document.getElementById('swal-user-type').value;
            if (!userType) {
                Swal.showValidationMessage('Please select a user type');
                return false;
            }
            return { user_id: userId, user_type: userType };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            saveUserTypeUpdate(result.value);
        }
    });
}

// ============================================
// SAVE UPDATED USER TYPE (PUT Request)
// ============================================
async function saveUserTypeUpdate(userData) {
    Swal.fire({ title: 'Saving...', didOpen: () => { Swal.showLoading(); } });

    try {
        // Note: Ensure your backend/handle-account.php handles the 'PUT' method for updates
        const response = await fetch('backend/handle-account.php', {
            method: 'PUT', 
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({ 
                icon: 'success', 
                title: 'Updated!', 
                text: 'User type updated successfully.', 
                timer: 1500, 
                showConfirmButton: false 
            });
            // Refresh the table to show the new data
            loadUsers(); 
        } else {
            throw new Error(result.message || 'Failed to update user type');
        }
    } catch (error) {
        console.error('Update error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: error.message || 'An unexpected error occurred.' });
    }
}

// ============================================
// HELPER: Prevent XSS attacks
// ============================================
function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}