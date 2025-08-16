<?php
// Includes the database connection class.
require_once BASE_PATH . 'includes/database.php';

class SellerModel {
    private $db;

    // The constructor creates a new database connection instance.
    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Fetches a seller's profile data from the database.
     * This includes their name, email, and current health score.
     *
     * @param int $seller_id The ID of the seller.
     * @return array|null A single row of seller data or null if not found.
     */
    public function getSellerData($seller_id) {
        $query = "
            SELECT 
                seller_id, 
                seller_name, 
                email, 
                health_score,
                created_at
            FROM 
                Sellers
            WHERE 
                seller_id = :seller_id
        ";
        
        $result = $this->db->query($query, ['seller_id' => $seller_id]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Fetches all pending orders for a specific seller.
     *
     * @param int $seller_id The ID of the seller.
     * @return array An array of pending order data.
     */
    public function getPendingOrders($seller_id) {
        $query = "
            SELECT 
                order_id, 
                total_amount, 
                created_at
            FROM 
                Orders
            WHERE 
                seller_id = :seller_id AND status = 'Pending'
        ";
        
        return $this->db->query($query, ['seller_id' => $seller_id]);
    }

    /**
     * Fetches a seller's total sales for the current month.
     * This is used to determine the commission rate.
     *
     * @param int $seller_id The ID of the seller.
     * @return float The total sales amount.
     */
    public function getMonthlySales($seller_id) {
        $query = "
            SELECT 
                SUM(total_amount) AS monthly_sales
            FROM 
                Orders
            WHERE 
                seller_id = :seller_id AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())
        ";
        
        $result = $this->db->query($query, ['seller_id' => $seller_id]);
        return $result && $result[0]['monthly_sales'] !== null ? (float)$result[0]['monthly_sales'] : 0.0;
    }

    /**
     * Calculates the commission for a new order based on your pricing plan.
     *
     * @param int $seller_id The ID of the seller.
     * @param float $order_amount The total amount of the current order.
     * @return float The commission percentage (e.g., 0.029 for 2.9%).
     */
    public function calculateCommission($seller_id, $order_amount) {
        $seller_data = $this->getSellerData($seller_id);
        if (!$seller_data) {
            return 0.0;
        }

        $monthly_sales = $this->getMonthlySales($seller_id);
        $total_sales_with_current_order = $monthly_sales + $order_amount;
        $commission_rate = 0.029; // 2.9%

        // Calculate the account age in months.
        $account_created = new DateTime($seller_data['created_at']);
        $now = new DateTime();
        $account_age_in_months = $account_created->diff($now)->m;

        // Rule 1: Sales over 1000 AED per month are charged 2.9%.
        if ($total_sales_with_current_order >= 1000) {
            return $commission_rate;
        }

        // Rule 2: Sales below 1000 AED are free for the first 6 months.
        if ($account_age_in_months < 6) {
            return 0.0; // Free commission.
        }

        // Rule 3: After 6 months, sales below 1000 AED are charged 2.9%.
        return $commission_rate;
    }
    
    /**
     * Finds a seller by their email address.
     * This is useful for checking if an account already exists.
     *
     * @param string $email The email address to search for.
     * @return array|null The seller data or null if not found.
     */
    public function findSellerByEmail($email) {
        $query = "
            SELECT 
                seller_id
            FROM 
                Sellers
            WHERE 
                email = :email
        ";
        
        $result = $this->db->query($query, ['email' => $email]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Creates a new seller account in the database.
     *
     * @param array $data An associative array of seller data.
     * @return bool True on success, false on failure.
     */
    public function createSellerAccount(array $data) {
        // First, check if an account with this email already exists.
        if ($this->findSellerByEmail($data['email'])) {
            return false; // Return false if a seller with this email is found.
        }

        // Securely hash the password.
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $query = "INSERT INTO Sellers 
                  (email, password, business_name, store_display_name, phone_number, trade_licence_number, emirates, deliverable_radius)
                  VALUES (:email, :password, :business_name, :store_display_name, :phone_number, :trade_licence_number, :emirates, :deliverable_radius)";
        
        $params = [
            'email' => $data['email'],
            'password' => $hashed_password,
            'business_name' => $data['business_name'],
            'store_display_name' => $data['store_display_name'],
            'phone_number' => $data['phone_number'],
            'trade_licence_number' => $data['trade_licence'],
            'emirates' => $data['emirates'],
            'deliverable_radius' => $data['deliverable_radius'],
        ];
        
        try {
            // This part needs to be completed with a PDO execution.
            // For example: $this->db->execute($query, $params);
            return true;
        } catch (Exception $e) {
            // Log the error for debugging.
            error_log($e->getMessage());
            return false;
        }
    }
}