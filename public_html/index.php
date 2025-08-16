<?php
// Enable comprehensive error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for your application files.
// This ensures that all file inclusions are relative to the project root.
define('BASE_PATH', __DIR__ . '/../');

// Include necessary configuration and core files.
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'includes/database.php';

// Start session to store temporary registration data and user input
session_start();

// Include the header once for all pages
require_once BASE_PATH . 'core/views/seller_landing_header.php';

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

    case 'auth/request_otp': // The form action for requesting an OTP for login (existing).
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->requestOtp();
        break;

    case 'register': // The registration form (Step 1 of new flow).
        require_once BASE_PATH . 'core/controllers/AuthController.php'; // AuthController handles registration flow
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'auth/register_request_otp': // The form action for Step 1, sending OTP for registration.
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->requestRegistrationOtp();
        break;

    case 'verify_registration_otp': // Page to enter OTP for registration.
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->verifyRegistrationOtpPage(); // New method to display OTP entry page
        break;

    case 'auth/verify_registration_otp': // The form action for Step 2, verifying OTP and creating account.
        require_once BASE_PATH . 'core/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->verifyRegistrationOtp();
        break;

    case 'register_submit': // This case is now largely deprecated by the new flow, but kept for reference.
        require_once BASE_PATH . 'core/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->registerSubmit(); // This method might need to be refactored or removed
        break;
    
    default:
        // Handle 404 Not Found errors for any other path.
        http_response_code(404);
        echo "404 Not Found";
        break;
}

// Include the footer once for all pages
require_once BASE_PATH . 'core/views/seller_landing_footer.php';
?>
