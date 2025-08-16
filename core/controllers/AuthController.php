<?php
require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../models/SellerModel.php';
require_once BASE_PATH . 'includes/EmailTemplate.php'; // Include the new email template function

// Include PHPMailer classes
// You NEED to ensure PHPMailer library is correctly installed in your 'includes' folder.
// A common structure is includes/PHPMailer/PHPMailer.php, includes/PHPMailer/SMTP.php etc.
// For demonstration, I'm assuming you'll manage the PHPMailer installation.
// If you don't have it, download from https://github.com/PHPMailer/PHPMailer/releases
// and place the src/ directory content into includes/PHPMailer/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Dummy include paths for PHPMailer, adjust if your directory structure is different
// For example, if you place 'src' content directly in 'includes/PHPMailer/'
require_once BASE_PATH . 'includes/PHPMailer/PHPMailer.php';
require_once BASE_PATH . 'includes/PHPMailer/Exception.php';
require_once BASE_PATH . 'includes/PHPMailer/SMTP.php';


class AuthController {
    private $authModel;
    private $sellerModel;

    public function __construct() {
        $this->authModel = new AuthModel();
        $this->sellerModel = new SellerModel();
    }

    public function login() {
        // Existing login page view
        require_once __DIR__ . '/../views/seller_login.php';
    }

    public function register() {
        // Loads the initial registration form (Step 1)
        require_once __DIR__ . '/../views/seller_register.php';
    }

    /**
     * Handles the initial registration form submission, sends OTP.
     */
    public function requestRegistrationOtp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input fields from Step 1
            if (!isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['re-password'])) {
                header("Location: " . BASE_URL . "/register?error=missing_fields");
                exit();
            }

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $re_password = $_POST['re-password'];

            // Basic server-side validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: " . BASE_URL . "/register?error=invalid_email");
                exit();
            }
            if (strlen($password) < 6) {
                header("Location: " . BASE_URL . "/register?error=password_too_short");
                exit();
            }
            if ($password !== $re_password) {
                header("Location: " . BASE_URL . "/register?error=passwords_mismatch");
                exit();
            }

            // Check if email already exists
            $seller = $this->authModel->findSellerByEmail($email);
            if ($seller) {
                header("Location: " . BASE_URL . "/register?error=email_exists");
                exit();
            }

            // Generate and store OTP in session
            $otp = rand(100000, 999999);
            $_SESSION['registration_data'] = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];
            $_SESSION['registration_otp'] = $otp;
            $_SESSION['registration_otp_expiry'] = time() + 180; // OTP expires in 3 minutes (180 seconds)

            // --- PHPMailer Email Sending Logic ---
            global $config; // Access global config for SMTP settings
            $mail = new PHPMailer(true); // Enable exceptions

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output (for testing)
                $mail->isSMTP();                       // Send using SMTP
                $mail->Host       = $config['smtp_host'];    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                     // Enable SMTP authentication
                $mail->Username   = $config['smtp_user'];    // SMTP username
                $mail->Password   = $config['smtp_pass'];    // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                      // TCP port to connect to

                //Recipients
                $mail->setFrom($config['smtp_user'], 'Barakath Seller'); // Sender email and name
                $mail->addAddress($email, $name);             // Add a recipient

                // Content
                $mail->isHTML(true);                          // Set email format to HTML
                $mail->Subject = 'Your Barakath Seller Registration Security Code';
                $mail->Body    = getOtpEmailTemplate($otp);   // Use the new email template function
                $mail->AltBody = 'Your Barakath Seller security code is: ' . $otp . '. This code expires in 3 minutes.'; // Plain text alternative

                $mail->send();
                // If successful, log to indicate email sent
                error_log("OTP email sent successfully to: " . $email);
            } catch (Exception $e) {
                error_log("OTP Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
                // Redirect back with an error if email fails to send
                header("Location: " . BASE_URL . "/register?error=email_send_failed");
                exit();
            }
            // --- END PHPMailer Email Sending Logic ---

            // Redirect to OTP verification page
            header("Location: " . BASE_URL . "/verify_registration_otp?email=" . urlencode($email));
            exit();
        }
        header("Location: " . BASE_URL . "/register");
        exit();
    }

    /**
     * Displays the OTP verification page.
     */
    public function verifyRegistrationOtpPage() {
        if (!isset($_GET['email'])) {
            header("Location: " . BASE_URL . "/register");
            exit();
        }
        require_once __DIR__ . '/../views/verify_registration_otp.php';
    }

    /**
     * Handles OTP verification and final account creation.
     */
    public function verifyRegistrationOtp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['otp']) || !isset($_SESSION['registration_data']) || !isset($_SESSION['registration_otp']) || !isset($_SESSION['registration_otp_expiry'])) {
                header("Location: " . BASE_URL . "/register?error=session_expired_or_invalid_request");
                exit();
            }

            $otp_submitted = trim($_POST['otp']);
            $stored_otp = $_SESSION['registration_otp'];
            $registration_data = $_SESSION['registration_data'];

            if ($otp_submitted == $stored_otp && time() < $_SESSION['registration_otp_expiry']) {
                // OTP is valid and not expired, proceed to create the account
                // Note: The original SellerModel::createSellerAccount expects more fields.
                // For this example, we'll fill missing fields with empty strings.
                $data_for_creation = [
                    'email' => $registration_data['email'],
                    'password' => $registration_data['password'],
                    'business_name' => $registration_data['name'], // Using name for business name initially
                    'store_display_name' => $registration_data['name'], // Using name for display name initially
                    'phone_number' => '', // These will be collected in a later profile setup
                    'trade_licence' => '',
                    'emirates' => '',
                    'deliverable_radius' => 0,
                ];
                
                if ($this->sellerModel->createSellerAccount($data_for_creation)) {
                    // Account created successfully, clean up session
                    unset($_SESSION['registration_data']);
                    unset($_SESSION['registration_otp']);
                    unset($_SESSION['registration_otp_expiry']);
                    header('Location: ' . BASE_URL . '/login?success=registration_successful');
                    exit();
                } else {
                    header('Location: ' . BASE_URL . '/register?error=registration_failed');
                    exit();
                }
            } else {
                header('Location: ' . BASE_URL . '/verify_registration_otp?email=' . urlencode($registration_data['email']) . '&error=invalid_otp');
                exit();
            }
        }
        header('Location: ' . BASE_URL . '/register'); // Default redirect if not a POST request
        exit();
    }

    // Existing requestOtp method for login flow (if applicable)
    public function requestOtp() {
        // This is a placeholder for the logic to send the OTP for existing logins.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = $_POST['email'];
            $seller = $this->authModel->findSellerByEmail($email);
            if ($seller) {
                $otp = rand(100000, 999999);
                $this->authModel->storeOtp($email, $otp); // This method needs to be implemented to actually store OTP with expiry
                // Assume a function to send an email with the OTP exists
                // For login OTP, also use PHPMailer
                global $config;
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host       = $config['smtp_host'];
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $config['smtp_user'];
                    $mail->Password   = $config['smtp_pass'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom($config['smtp_user'], 'Barakath Seller');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Barakath Seller Login Security Code';
                    $mail->Body    = getOtpEmailTemplate($otp);
                    $mail->AltBody = 'Your Barakath Seller login security code is: ' . $otp . '.';

                    $mail->send();
                    error_log("Login OTP email sent successfully to: " . $email);
                } catch (Exception $e) {
                    error_log("Login OTP Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
                    header("Location: " . BASE_URL . "/login?error=email_send_failed");
                    exit();
                }
                // Redirect to OTP verification page
                header("Location: " . BASE_URL . "/verify_otp?email=" . urlencode($email));
                exit();
            }
        }
        // Redirect back to login with an error message
        header("Location: " . BASE_URL . "/login?error=seller_not_found");
        exit();
    }
}
