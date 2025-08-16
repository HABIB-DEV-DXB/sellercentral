<?php
// Ensure BASE_URL is defined, typically from config.php
if (!defined('BASE_URL')) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $subdirectory = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__) . '/public_html'));
    define('BASE_URL', $protocol . "://" . $host . $subdirectory);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barakath Seller</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/seller_landing.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/seller_login.css">
    <!-- Font Awesome for icons (if needed, already in seller_header but good to have here too) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Notification Box Container -->
<div id="notification-box" class="notification-box"></div>

<header class="landing-header">
    <div class="header-logo">
        <a href="<?php echo BASE_URL; ?>">
            <!-- Using the uploaded logo. Ensure this path is correct on your server. -->
            <img src="<?php echo BASE_URL; ?>/assets/images/barakath_logo.png" alt="Barakath Seller Logo" class="logo-img">
        </a>
    </div>

    <!-- Main Navigation -->
    <nav class="main-nav" id="main-nav">
        <ul>
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>/blogs">Blogs</a></li>
            <li><a href="<?php echo BASE_URL; ?>/forms">Forms</a></li>
            <li><a href="<?php echo BASE_URL; ?>/pricing">Pricing & Fees</a></li>
            <li><a href="<?php echo BASE_URL; ?>/about">About Us</a></li>
            <li><a href="<?php echo BASE_URL; ?>/contact">Contact Us</a></li>
        </ul>
        <div class="auth-buttons">
            <!-- These links will dynamically change based on user session if implemented -->
            <a href="<?php echo BASE_URL; ?>/register" class="glass-button nav-button">Register</a>
            <a href="<?php echo BASE_URL; ?>/login" class="glass-button nav-button">Login</a>
        </div>
    </nav>

    <!-- Hamburger Menu Icon for Mobile -->
    <div class="hamburger-menu" id="hamburger-menu">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>
<main>
