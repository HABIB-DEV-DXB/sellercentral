<?php
// Include the landing page header.
require_once __DIR__ . '/seller_landing_header.php';
?>

<div class="container seller-landing-page">

    <div class="glass-card hero-section">
        <h1>Empower Your Business. Partner with Barakath.</h1>
        <p>A zero-cost, commission-based marketplace designed for local businesses like yours. Keep more of what you earn and connect directly with your community.</p>
        <a href="/register" class="glass-button">Start Selling Today</a>
    </div>

    <div class="glass-card features-benefits-section">
        <h2>Your Success, Our Mission</h2>
        <p>We've built a platform that gives you the tools you need to thrive in the digital marketplace without the complexity or high costs.</p>
        
        <div class="benefits-grid">
            <div class="benefit-card glass-card">
                <i class="fa-solid fa-percent icon"></i>
                <h3>Transparent Pricing</h3>
                <p>Enjoy a simple, flat 2.9% commission on all sales. No monthly subscriptions, no hidden fees.</p>
            </div>
            <div class="benefit-card glass-card">
                <i class="fa-solid fa-handshake icon"></i>
                <h3>Direct Customer Connection</h3>
                <p>Build your own brand and connect with a loyal customer base in your local area.</p>
            </div>
            <div class="benefit-card glass-card">
                <i class="fa-solid fa-chart-line icon"></i>
                <h3>Tools for Growth</h3>
                <p>Get a powerful dashboard to manage your products, track orders, and monitor your business performance.</p>
            </div>
            <div class="benefit-card glass-card">
                <i class="fa-solid fa-map-location-dot icon"></i>
                <h3>Flexible Delivery</h3>
                <p>Define your own delivery radius and choose from flexible payment options to suit your business model.</p>
            </div>
        </div>
    </div>

    <div class="glass-card pricing-section">
        <h2>Our Simple, Transparent Pricing</h2>
        <div class="pricing-table">
            <div class="pricing-card glass-card">
                <h3>Flat-Rate Commission</h3>
                <p class="price-tag">2.9%</p>
                <ul>
                    <li>Commission on Sales</li>
                    <li>No Monthly Subscription</li>
                    <li>No Hidden Fees</li>
                    <li>Cancel Anytime</li>
                </ul>
                <a href="/register" class="glass-button">Join Now</a>
            </div>
        </div>
    </div>

</div>

<?php
// Include the landing page footer.
require_once __DIR__ . '/seller_landing_footer.php';
?>