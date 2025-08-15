<?php
// We'll need a header for this page, but we'll assume it's a simple login header for now.
// require_once __DIR__ . '/seller_header.php';
?>

<div class="container">
    <div class="glass-card login-card">
        <h2>Seller Registration</h2>
        <form action="/register_submit" method="POST">
            <div class="form-group">
                <label for="business_name">Business Name</label>
                <input type="text" id="business_name" name="business_name" required>
            </div>
            <div class="form-group">
                <label for="store_display_name">Store Display Name</label>
                <input type="text" id="store_display_name" name="store_display_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="trade_licence">Trade Licence Number</label>
                <input type="text" id="trade_licence" name="trade_licence" required>
            </div>
            <div class="form-group">
                <label for="emirates">Emirates</label>
                <input type="text" id="emirates" name="emirates" required>
            </div>
            <div class="form-group">
                <label for="deliverable_radius">Deliverable Radius (KM)</label>
                <input type="number" step="0.1" id="deliverable_radius" name="deliverable_radius" required>
            </div>
            <button type="submit" class="glass-button">Register</button>
        </form>
    </div>
</div>

<?php
// require_once __DIR__ . '/footer.php';
?>