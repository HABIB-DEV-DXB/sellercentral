<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/seller_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Barakath Seller</h2>
        </div>
        <ul>
            <li><a href="/dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="/products"><i class="fa-solid fa-store"></i> My Products</a></li>
            <li><a href="/orders"><i class="fa-solid fa-box-open"></i> Orders</a></li>
            <li><a href="/settings"><i class="fa-solid fa-gear"></i> Settings</a></li>
            <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
        </ul>
    </div>
    <div class="hamburger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars fa-2x"></i>
    </div>
    <div class="main-container" id="main-container">
        <script>
            // public/assets/js/seller.js
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-container');
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('shifted');
}
        </script>