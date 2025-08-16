<?php
// Header and footer are now included in public/index.php
?>

<div class="container">
    <div class="glass-card login-card">
        <h2>Verify Your Email Address</h2>
        <p>A 6-digit security code has been sent to your email address: <?php echo htmlspecialchars($_GET['email']); ?></p>
        
        <div id="countdown" style="font-size: 1.1em; margin: 15px 0; color: var(--secondary-text-color);">
            Code expires in <span id="timer">03:00</span>
        </div>

        <form action="<?php echo BASE_URL; ?>/auth/verify_registration_otp" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" maxlength="6" pattern="\d{6}" title="Please enter a 6-digit code" required>
            </div>
            <button type="submit" class="glass-button">Verify</button>
        </form>

        <div style="margin-top: 20px;">
            <p style="color: var(--secondary-text-color);">Didn't receive the code?</p>
            <button id="resendOtpButton" class="glass-button" disabled style="background-color: var(--secondary-text-color);">Resend OTP</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resendOtpButton');
        const email = "<?php echo htmlspecialchars($_GET['email']); ?>";
        const otpExpiryTime = <?php echo isset($_SESSION['registration_otp_expiry']) ? $_SESSION['registration_otp_expiry'] : 0; ?>;
        const currentTime = Math.floor(Date.now() / 1000); // Current time in seconds

        let remainingTime = Math.max(0, otpExpiryTime - currentTime); // Calculate actual remaining time

        function startCountdown() {
            const countdownInterval = setInterval(() => {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;

                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    timerDisplay.textContent = 'Expired';
                    resendButton.disabled = false;
                    resendButton.style.backgroundColor = 'var(--primary-color)'; // Enable styling for resend
                    resendButton.textContent = 'Resend OTP';
                }
                remainingTime--;
            }, 1000);
        }

        if (remainingTime > 0) {
            startCountdown();
        } else {
            // If already expired on load
            timerDisplay.textContent = 'Expired';
            resendButton.disabled = false;
            resendButton.style.backgroundColor = 'var(--primary-color)';
            resendButton.textContent = 'Resend OTP';
        }

        resendButton.addEventListener('click', function() {
            // Temporarily disable the button to prevent multiple clicks
            resendButton.disabled = true;
            resendButton.style.backgroundColor = 'var(--secondary-text-color)';
            resendButton.textContent = 'Sending...';

            // Redirect to trigger a new OTP request.
            // This will go back to the AuthController::requestRegistrationOtp method.
            window.location.href = "<?php echo BASE_URL; ?>/auth/register_request_otp";
        });
    });
</script>
