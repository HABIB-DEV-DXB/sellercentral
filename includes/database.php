<?php
class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct() {
        // Load database credentials from the global configuration.
        global $config;
        $this->host = $config['db_host'];
        $this->db = $config['db_name'];
        $this->user = $config['db_user'];
        $this->pass = $config['db_pass'];
        $this->charset = 'utf8mb4';

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            // Throw exceptions on error, which is great for debugging.
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Fetch results as associative arrays by default.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Disable emulated prepared statements for security.
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            // Set the timezone for the database connection to GMT +4.
            $this->pdo->exec("SET time_zone = '+04:00';");
        } catch (\PDOException $e) {
            // Throw an exception with the error message.
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Executes a SQL query using a prepared statement.
     * * @param string $sql The SQL query to execute.
     * @param array $params An associative array of parameters for the query.
     * @return array An array of fetched rows.
     */
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}