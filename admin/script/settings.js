// File: C:\xampp\htdocs\qsi_inc\admin\script\setting.js

document.addEventListener('DOMContentLoaded', () => {
    loadUserData();
    
    const actionBtn = document.getElementById('actionBtn');
    actionBtn.addEventListener('click', handleActionClick);
});

let isEditing = false;

// 1. Fetch current user data on load
async function loadUserData() {
    try {
        const response = await fetch('backend/handle-setting.php');
        const result = await response.json();

        if (result.status === 'success') {
            const data = result.data;
            document.getElementById('f_name').value = data.f_name || '';
            document.getElementById('l_name').value = data.l_name || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('contact').value = data.contact || '';
        }
    } catch (error) {
        console.error('Error loading user data:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load user data.' });
    }
}

// 2. Handle Edit / Save Button Click
async function handleActionClick() {
    const actionBtn = document.getElementById('actionBtn');
    const inputs = document.querySelectorAll('.form-input');

    if (!isEditing) {
        // --- ENABLE FORM ---
        const confirmEdit = await Swal.fire({
            title: 'Edit Information?',
            text: 'Are you sure you want to modify your details?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0a5d3c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, enable editing',
            cancelButtonText: 'Cancel'
        });

        if (confirmEdit.isConfirmed) {
            isEditing = true;
            
            // Enable all inputs
            inputs.forEach(input => input.disabled = false);
            
            // Change button to Save
            actionBtn.innerHTML = '<i class="fa-solid fa-save"></i> <span>Save Changes</span>';
            
            // FIX: Explicitly remove old colors and add new ones
            actionBtn.classList.remove('bg-[#0a5d3c]', 'hover:bg-[#084a2f]', 'text-white');
            actionBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'text-white');
        }
    } else {
        // --- SAVE FORM ---
        const fName = document.getElementById('f_name').value.trim();
        const lName = document.getElementById('l_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const contact = document.getElementById('contact').value.trim();
        const oldPass = document.getElementById('old_password').value.trim();
        const newPass = document.getElementById('new_password').value.trim();
        const confirmPass = document.getElementById('confirm_password').value.trim();

        // Validation
        if (!fName || !lName || !email) {
            Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'First Name, Last Name, and Email are required.' });
            return;
        }

        // Password validation
        if (oldPass || newPass || confirmPass) {
            if (!oldPass) {
                Swal.fire({ icon: 'warning', title: 'Old Password Required', text: 'Please enter your old password to set a new one.' });
                return;
            }
            if (newPass !== confirmPass) {
                Swal.fire({ icon: 'error', title: 'Password Mismatch', text: 'New password and confirm password do not match.' });
                return;
            }
            if (newPass.length < 6) {
                Swal.fire({ icon: 'warning', title: 'Weak Password', text: 'New password must be at least 6 characters.' });
                return;
            }
        }

        // Confirm Save
        const confirmSave = await Swal.fire({
            title: 'Save Changes?',
            text: 'Your information will be updated.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0a5d3c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        });

        if (confirmSave.isConfirmed) {
            Swal.fire({ title: 'Saving...', didOpen: () => { Swal.showLoading(); } });

            try {
                const payload = { f_name: fName, l_name: lName, email, contact };
                
                if (oldPass && newPass) {
                    payload.old_password = oldPass;
                    payload.new_password = newPass;
                }

                const response = await fetch('backend/handle-setting.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Success!', text: result.message, timer: 2000, showConfirmButton: false });
                    
                    // Reset form state
                    isEditing = false;
                    inputs.forEach(input => {
                        input.disabled = true;
                        if (input.type === 'password') input.value = ''; 
                    });
                    
                    // Revert button to Edit
                    actionBtn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> <span>Edit Information</span>';
                    
                    // FIX: Explicitly remove blue colors and add green ones back
                    actionBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                    actionBtn.classList.add('bg-[#0a5d3c]', 'hover:bg-[#084a2f]', 'text-white');
                    
                } else {
                    throw new Error(result.message || 'Failed to save changes.');
                }
            } catch (error) {
                console.error('Save error:', error);
                Swal.fire({ icon: 'error', title: 'Error', text: error.message });
            }
        }
    }
}