
//---------------------------------------------Login Form Script
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('#loginForm');
    const emailInput = document.querySelector('#email');
    const passwordInput = document.querySelector('#password');
    const submitBtn = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
    const errorDiv = document.querySelector('#loginError');
    const successDiv = document.querySelector('#loginSuccess');

    //  Precise Toggle Password Logic
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // 1. Find the specific input field inside the same 'relative' container
            const input = this.closest('.relative').querySelector('input');
            
            // 2. Find the icon inside this specific button
            const icon = this.querySelector('i');

            if (input && icon) {
                // Toggle type
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
        });
    });

    // Helper function to show messages
    function showMessage(element, message, isError = false) {
        element.textContent = message;
        element.classList.remove('hidden');
        
        if (isError) {
            element.classList.remove('bg-green-50', 'border-green-200', 'text-green-600');
            element.classList.add('bg-red-50', 'border-red-200', 'text-red-600');
        } else {
            element.classList.remove('bg-red-50', 'border-red-200', 'text-red-600');
            element.classList.add('bg-green-50', 'border-green-200', 'text-green-600');
        }
    }

    function hideMessages() {
        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');
    }

    // Handle Form Submission
    if (loginForm && emailInput && passwordInput && submitBtn) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Stop default form reload
            
            // Clear previous messages
            hideMessages();

            // Basic validation
            const email = emailInput.value.trim();
            const password = passwordInput.value;

            if (!email || !password) {
                showMessage(errorDiv, 'Please fill in all fields.', true);
                return;
            }

            // Basic UI Feedback
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Logging in...';

            try {
                // Send data to backend
                const response = await fetch('backend/handle-login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                // Check if response is OK
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.status === 'success') {
                    // Show success message
                    showMessage(successDiv, result.message || 'Login successful! Redirecting...');
                    
                    // Update button
                    submitBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Success!';
                    submitBtn.classList.remove('bg-[#0a5d3c]', 'hover:bg-[#0d9488]');
                    submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    setTimeout(() => {
                        window.location.href = 'dashboard.php'; // Redirect to dashboard
                    }, 1500);
                } else {
                    // Show error
                    showMessage(errorDiv, result.message || 'Login failed. Please check your credentials.', true);
                    resetButton(submitBtn, originalBtnText);
                }

            } catch (error) {
                console.error('Error:', error);
                showMessage(errorDiv, 'An unexpected error occurred. Please try again.', true);
                resetButton(submitBtn, originalBtnText);
            }
        });
    }

    function resetButton(btn, text) {
        btn.disabled = false;
        btn.innerHTML = text;
        btn.classList.remove('bg-green-600', 'hover:bg-green-700');
        btn.classList.add('bg-[#0a5d3c]', 'hover:bg-[#0d9488]');
    }
});