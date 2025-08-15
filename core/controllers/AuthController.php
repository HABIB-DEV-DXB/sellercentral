<?php
require_once __DIR__ . '/../models/AuthModel.php';
class AuthController {
    private $model;
    public function __construct() {
        $this->model = new AuthModel();
    }
    public function login() {
        // This method simply loads the login page view.
        require_once __DIR__ . '/../views/login.php';
    }
    public function requestOtp() {
        // This is a placeholder for the logic to send the OTP.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = $_POST['email'];
            $seller = $this->model->findSellerByEmail($email);
            if ($seller) {
                $otp = rand(100000, 999999);
                $this->model->storeOtp($email, $otp);
                // Assume a function to send an email with the OTP exists
                // sendEmail($email, $otp);
                // Redirect to OTP verification page
                header("Location: /verify_otp?email=" . urlencode($email));
                exit();
            }
        }
        // Redirect back to login with an error message
        header("Location: /login?error=seller_not_found");
        exit();
    }
    // You would add a verifyOtp() method here for the next step.
}