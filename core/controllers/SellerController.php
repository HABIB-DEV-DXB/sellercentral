<?php
// Includes the model file that handles database interactions for the seller.
require_once __DIR__ . '/../models/SellerModel.php';

class SellerController {
    private $model;

    // The constructor initializes the SellerModel.
    public function __construct() {
        $this->model = new SellerModel();
    }

    /**
     * Renders the seller platform's landing page.
     */
    public function index() {
        // This method simply loads the seller landing page view.
        require_once __DIR__ . '/../views/seller_index.php';
    }

    /**
     * Renders the seller's dashboard.
     */
    public function dashboard() {
        // Placeholder for the logged-in seller's ID.
        // In a real application, you would get this from the user's session.
        $seller_id = 1; 
        
        $seller_data = $this->model->getSellerData($seller_id);
        $pending_orders = $this->model->getPendingOrders($seller_id);
        
        require_once __DIR__ . '/../views/seller_dashboard.php';
    }

    /**
     * Renders the seller registration form.
     */
    public function register() {
        // This method simply loads the seller registration form view.
        require_once __DIR__ . '/../views/seller_register.php';
    }

    /**
     * Handles the form submission for seller registration.
     */
    public function registerSubmit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['business_name'], $_POST['store_display_name'], $_POST['email'], 
                      $_POST['password'], $_POST['phone_number'], $_POST['trade_licence'])) {
                header('Location: /register?error=missing_fields');
                exit();
            }

            $data = [
                'business_name' => $_POST['business_name'],
                'store_display_name' => $_POST['store_display_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone_number' => $_POST['phone_number'],
                'trade_licence' => $_POST['trade_licence'],
                'emirates' => $_POST['emirates'],
                'deliverable_radius' => $_POST['deliverable_radius']
            ];

            if ($this->model->createSellerAccount($data)) {
                header('Location: /login?success=registration_successful');
                exit();
            } else {
                header('Location: /register?error=registration_failed');
                exit();
            }
        }
        header('Location: /register');
        exit();
    }
}