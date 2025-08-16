<?php
// require_once __DIR__ . '/seller_header.php';
?>
<div class="container">
    <div class="glass-card login-card">
        <h2>Seller Login</h2>
        <form action="/auth/request_otp" method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="glass-button">Send OTP</button>
        </form>
    </div>
</div>
<?php
// require_once __DIR__ . '/footer.php';
?>