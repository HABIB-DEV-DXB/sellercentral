<?php
require_once BASE_PATH . 'includes/database.php';
class AuthModel {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function findSellerByEmail($email) {
        $query = "SELECT * FROM Sellers WHERE email = :email";
        $result = $this->db->query($query, ['email' => $email]);
        return $result ? $result[0] : null;
    }
    public function storeOtp($email, $otp) {
        // This method would store the OTP and its expiration time in a database table.
        // A simple query for this would be:
        // INSERT INTO otps (email, otp_code, expiration_time) VALUES (?, ?, ?);
    }
    // You would add a verifyOtp() method here for the next step.
}