<?php
session_start();
// Assume a header for the login page
// require_once __DIR__ . '/seller_header.php';
?>

<div class="container">
    <div class="glass-card login-card">
        <h2>Seller Login</h2>
        <form action="/auth/login_submit" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="glass-button">Log In</button>
        </form>
    </div>
</div>

<?php
// Assume a footer for the login page
// require_once __DIR__ . '/footer.php';
?>