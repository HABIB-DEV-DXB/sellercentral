// public/assets/js/landing.js

document.addEventListener('DOMContentLoaded', () => {
    const bannerSlider = document.querySelector('.banner-slider');
    
    // Function to fetch banners from the API.
    async function fetchBanners() {
        try {
            // Use the globally defined BASE_URL (assuming it's accessible or can be passed)
            // For client-side JS, you might need to embed BASE_URL as a global JS variable
            // in your header or use relative paths if applicable.
            // For now, assuming relative path for API or a placeholder.
            // If API is on a different subdomain, you'll need the full URL.
            const response = await fetch('/api.yourplatform.com/banners'); // Placeholder, adjust as needed
            const banners = await response.json();
            
            if (banners.length > 0) {
                // Remove placeholder
                bannerSlider.innerHTML = '';
                
                // Dynamically create a banner for each item from the API.
                banners.forEach(banner => {
                    const bannerItem = document.createElement('div');
                    bannerItem.className = 'banner-item';
                    bannerItem.innerHTML = `
                        <img src="${banner.image_url}" alt="${banner.heading}">
                        <div class="banner-content">
                            <h2>${banner.heading}</h2>
                            <p>${banner.subtitle}</p>
                            <a href="${banner.action_link}" class="glass-button">${banner.action_text}</a>
                        </div>
                    `;
                    bannerSlider.appendChild(bannerItem);
                });
            }
        } catch (error) {
            console.error('Error fetching banners:', error);
        }
    }

    fetchBanners();

    // --- Global Notification Box Logic ---
    const notificationBox = document.getElementById('notification-box');
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('error');
    const successMessage = urlParams.get('success');

    if (errorMessage) {
        notificationBox.textContent = formatMessage(errorMessage, 'error');
        notificationBox.classList.add('active');
        notificationBox.classList.remove('success'); // Ensure success class is removed
        setTimeout(() => {
            notificationBox.classList.remove('active');
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.delete('error');
            window.history.replaceState({}, document.title, newUrl.toString());
        }, 5000); // Hide after 5 seconds
    } else if (successMessage) {
        notificationBox.textContent = formatMessage(successMessage, 'success');
        notificationBox.classList.add('active', 'success'); // Add success class for distinct styling
        setTimeout(() => {
            notificationBox.classList.remove('active', 'success');
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.delete('success');
            window.history.replaceState({}, document.title, newUrl.toString());
        }, 5000); // Hide after 5 seconds
    }

    // Function to format messages based on type
    function formatMessage(code, type) {
        if (type === 'error') {
            switch (code) {
                case 'missing_fields':
                    return 'Please fill in all required fields.';
                case 'invalid_email':
                    return 'Please enter a valid email address.';
                case 'password_too_short':
                    return 'Password must be at least 6 characters long.';
                case 'passwords_mismatch':
                    return 'Passwords do not match.';
                case 'email_exists':
                    return 'This email is already registered. Please try logging in.';
                case 'invalid_otp':
                    return 'Invalid or expired security code. Please try again.';
                case 'registration_failed':
                    return 'Registration failed. Please try again later.';
                case 'session_expired_or_invalid_request':
                    return 'Your session has expired or the request is invalid. Please start registration again.';
                case 'email_send_failed':
                    return 'Failed to send verification email. Please try again.';
                case 'seller_not_found':
                    return 'Seller not found with that email.';
                default:
                    return 'An unexpected error occurred.';
            }
        } else if (type === 'success') {
            switch (code) {
                case 'registration_successful':
                    return 'Registration successful! Please log in.';
                default:
                    return 'Operation successful!';
            }
        }
        return '';
    }

    // --- Client-Side Registration Form Validation Logic ---
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) { // Only run if the registration form exists on the page
        const password = document.getElementById('password');
        const rePassword = document.getElementById('re-password');
        const passwordError = document.getElementById('passwordError');
        const rePasswordError = document.getElementById('rePasswordError');

        registrationForm.addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous inline errors
            passwordError.textContent = '';
            rePasswordError.textContent = '';
            passwordError.style.display = 'none';
            rePasswordError.style.display = 'none';

            // Password length check
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
    }

    // --- Mobile Navigation Toggle Logic ---
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const mainNav = document.getElementById('main-nav');

    if (hamburgerMenu && mainNav) {
        hamburgerMenu.addEventListener('click', () => {
            mainNav.classList.toggle('active');
            // Toggle hamburger icon if using an animated icon
            // hamburgerMenu.querySelector('i').classList.toggle('fa-bars');
            // hamburgerMenu.querySelector('i').classList.toggle('fa-times');
        });

        // Close menu if a nav link is clicked (for single-page apps or smooth UX)
        mainNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (mainNav.classList.contains('active')) {
                    mainNav.classList.remove('active');
                    // Reset hamburger icon
                }
            });
        });
    }
});
