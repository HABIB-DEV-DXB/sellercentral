<?php
require_once __DIR__ . '/seller_header.php';
?>
<div class="container seller-dashboard-container">
    <div class="main-content">
        <?php if (isset($seller_data) && !empty($seller_data)): ?>
            <div class="glass-card welcome-card">
                <h2>Welcome, <?php echo htmlspecialchars($seller_data['seller_name']); ?></h2>
                <p>Your Current Score: <?php echo htmlspecialchars($seller_data['health_score']); ?></p>
            </div>
            <div class="glass-card orders-card">
                <h3>Pending Orders</h3>
                <?php if (!empty($pending_orders)): ?>
                    <ul>
                        <?php foreach ($pending_orders as $order): ?>
                            <li>Order ID: <?php echo htmlspecialchars($order['order_id']); ?> - Amount: <?php echo htmlspecialchars($order['total_amount']); ?> AED</li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>You have no pending orders.</p>
                <?php endif; ?>
            </div>
            <div class="glass-card product-card">
                <h3>Product Management</h3>
                <p>Add new products or manage your existing ones.</p>
                <button class="glass-button">Add New Product</button>
            </div>
        <?php else: ?>
            <div class="glass-card">
                <p>No seller data found. Please check your login status.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
// require_once __DIR__ . '/footer.php';
?>