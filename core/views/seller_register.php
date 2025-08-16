<?php
// Header and footer are now included in public/index.php
?>

<div class="container">
    <div class="glass-card login-card">
        <h2>Start Selling on Barakath</h2>
        <form id="registrationForm" action="/auth/register_request_otp" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password (6 or more characters)</label>
                <input type="password" id="password" name="password" minlength="6" required>
                <span id="passwordError" class="error-message" style="color: var(--error-color); font-size: 0.85em; margin-top: 5px; display: none;"></span>
            </div>
            <div class="form-group">
                <label for="re-password">Re-enter Password</label>
                <input type="password" id="re-password" name="re-password" minlength="6" required>
                <span id="rePasswordError" class="error-message" style="color: var(--error-color); font-size: 0.85em; margin-top: 5px; display: none;"></span>
            </div>
            <button type="submit" class="glass-button">Next</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const password = document.getElementById('password');
        const rePassword = document.getElementById('re-password');
        const passwordError = document.getElementById('passwordError');
        const rePasswordError = document.getElementById('rePasswordError');

        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Reset previous errors
            passwordError.style.display = 'none';
            rePasswordError.style.display = 'none';

            // Password length check (already handled by minlength attribute, but good for explicit JS feedback)
            if (password.value.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters.';
                passwordError.style.display = 'block';
                isValid = false;
            }

            // Password mismatch check
            if (password.value !== rePassword.value) {
                rePasswordError.textContent = 'Passwords do not match.';
                rePasswordError.style.display = 'block';
                password.value = ''; // Clear only password fields
                rePassword.value = '';
                password.focus(); // Focus on the first password field
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if validation fails
            }
        });
    });
</script>
