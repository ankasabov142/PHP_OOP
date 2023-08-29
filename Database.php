<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    public function __construct($host, $username, $password, $dbname) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    
        $this->createDatabaseAndTable();
    }
    
    public function executeQuery($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error in preparing SQL statement: " . $this->conn->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); 
            $stmt->bind_param($types, ...$params);
        }
        
        if ($stmt->execute() === false) {
            die("Error in executing SQL statement: " . $stmt->error);
        }
        
        return $stmt;
    }
    
    public function createDatabaseIfNotExists() {
        $this->conn->query("CREATE DATABASE IF NOT EXISTS usermanagement");
    }

    public function createUsersTable() {
        $this->conn->query("USE usermanagement");
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                role VARCHAR(50) NOT NULL
            )
        ");
    }

    public function createDatabaseAndTable() {
        $this->createDatabaseIfNotExists();
        $this->createUsersTable();
    }
    
    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>