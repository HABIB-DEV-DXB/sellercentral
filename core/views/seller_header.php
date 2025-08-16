<?php
session_start(); // Ensure session is started for seller-specific pages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Portal</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/seller_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Barakath Seller</h2>
        </div>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>/products"><i class="fa-solid fa-store"></i> My Products</a></li>
            <li><a href="<?php echo BASE_URL; ?>/orders"><i class="fa-solid fa-box-open"></i> Orders</a></li>
            <li><a href="<?php echo BASE_URL; ?>/settings"><i class="fa-solid fa-gear"></i> Settings</a></li>
            <li><a href="<?php echo BASE_URL; ?>/logout"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
        </ul>
    </div>
    <div class="hamburger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars fa-2x"></i>
    </div>
    <div class="main-container" id="main-container">
        <!-- Seller specific JS can be loaded here or in footer -->
        <script src="<?php echo BASE_URL; ?>/assets/js/seller.js"></script>
