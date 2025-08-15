<?php
// Define the base path for your application files.
// This ensures that all file inclusions are relative to the project root.
define('BASE_PATH', __DIR__ . '/../');

// Include necessary configuration and core files.
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'includes/database.php';

// A simple router to handle requests.
$path = isset($_GET['path']) ? $_GET['path'] : '';

// Remove trailing slash for consistent routing.
if ($path !== '' && substr($path, -1) === '/') {
    $path = substr($path, 0, -1);
}

// The main router to handle different pages.
switch ($path) {
    case 'dashboard':
        require_once BASE_PATH . 'core/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->dashboard();
        break;
        
    case '': // The homepage for sellers (the landing page).
        require_once BASE_PATH . 'core/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->index();
        break;
        
    case 'login': // The login page.
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'auth/request_otp': // The form action for requesting an OTP.
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->requestOtp();
        break;

    case 'register': // The registration form.
        require_once BASE_PATH . 'core/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->register();
        break;
        
    case 'register_submit': // The form action for registering a new seller.
        require_once BASE_PATH . 'core/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->registerSubmit();
        break;
    
    default:
        // Handle 404 Not Found errors for any other path.
        http_response_code(404);
        echo "404 Not Found";
        break;
}