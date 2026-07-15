//-----------------------------------------------------------------toggle password 

function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

//-------------------------------------------------------Sweetalert2 and Backend API
   document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Stop the form from reloading the page

            // 1. Get Input Values
            const fName = document.querySelector('input[name="f_name"]').value.trim();
            const lName = document.querySelector('input[name="l_name"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const contact = document.querySelector('input[name="contact"]').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            // 2. Validation: Check if any field is empty
            if (!fName || !lName || !email || !contact || !password || !confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please fulfill all the input fields.',
                    confirmButtonColor: '#0a5d3c'
                });
                return;
            }

            // 3. Validation: Check if passwords match
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'The passwords you entered do not match.',
                    confirmButtonColor: '#0a5d3c'
                });
                return;
            }

            // 4. UI Loading State
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Registering...';

            // 5. Prepare Data for API
            const userData = {
                f_name: fName,
                l_name: lName,
                email: email,
                contact: contact,
                password: password
            };

            try {
                // 6. Call handle-register.php using Fetch API
                const response = await fetch('backend/handle-register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(userData)
                });

                const result = await response.json();

                if (result.status === 'success') {
                    // 7. Success: Show Check Animation and Redirect
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Account registered successfully.',
                        confirmButtonColor: '#0a5d3c',
                        timer: 2000, // Auto close after 2 seconds
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'login.php'; // Redirect to login
                    });
                } else {
                    // 8. Error: Show message from backend (e.g., Email already exists)
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: result.message || 'An error occurred during registration.',
                        confirmButtonColor: '#0a5d3c'
                    });
                    
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Unexpected Error',
                    text: 'An unexpected error occurred. Please check your connection.',
                    confirmButtonColor: '#0a5d3c'
                });
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});

