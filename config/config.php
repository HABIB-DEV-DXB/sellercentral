<?php
// Database configuration
$config['db_host'] = 'localhost';
$config['db_name'] = 'u437741037_barakath_mp';
$config['db_user'] = 'u437741037_barakath_mp';
$config['db_pass'] = 'A0L7OjWcqU1ipRBqhtI4';

// Email OTP configuration (you can update these when you're ready)
$config['smtp_host'] = 'smtp.titan.email';
$config['smtp_user'] = 'no-reply@rocksouq.com';
$config['smtp_pass'] = 'fg0V-bQlAG%V';

// Define the base URL for the application
// This assumes your domain (e.g., barakath-sellercentral.rocksouq.com)
// directly points to your public_html directory.
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . "://" . $host);

?>
