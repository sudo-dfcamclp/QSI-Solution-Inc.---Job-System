//------------------------------------------------------------realtime psuedo code - polling type

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
        loadingState.classList.remove('hidden');
        emptyState.classList.add('hidden');
    }

    try {
        // Call the PHP backend
        const response = await fetch('backend/handle-account.php');
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();

        if (!isBackgroundUpdate) {
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
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            if (!isBackgroundUpdate || tableBody.children.length === 0) {
                emptyState.classList.remove('hidden');
            }
        }

    } catch (error) {
        console.error('Error fetching users:', error);
        if (!isBackgroundUpdate) {
            loadingState.classList.add('hidden');
            // Updated colspan to 6 to match the new number of columns
            tableBody.innerHTML = `<tr><td colspan="6" class="p-4 text-red-500 text-center">Error loading data. Check console.</td></tr>`;
        }
    }
}

// Helper to prevent XSS attacks
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}