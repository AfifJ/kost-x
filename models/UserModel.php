<?php
require_once '../config/Database.php';

class User {
    private $conn;
    private $table_name = 'users';

    // Properti user
    public $id;
    public $username;
    public $email;
    public $password;
    public $user_type;
    public $created_at;

    // Konstruktor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Method Create (Register)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET 
                    username = :username, 
                    email = :email, 
                    password = :password";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method Read (Login/Find User)
    public function findByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE email = :email LIMIT 0,1";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind value
        $stmt->bindParam(":email", $this->email);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->user_type = $row['user_type'];

        return $stmt->rowCount();
    }

    // Method Update Profile
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET 
                    username = :username
                  WHERE 
                    id = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method Delete
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind value
        $stmt->bindParam(":id", $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method Validasi
    public function emailExists() {
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE email = :email
                  LIMIT 0,1";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind value
        $stmt->bindParam(":email", $this->email);

        // Execute query
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Method Autentikasi
    public function authenticate() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE email = :email LIMIT 0,1";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Sanitize email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind value
        $stmt->bindParam(":email", $this->email);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cek password
        if($row && password_verify($this->password, $row['password'])) {
            // Set properties
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->user_type = $row['user_type'];
            return true;
        }

        return false;
    }

    // Method Get All Users
    public function getAll() {
        $query = "SELECT id, username, email, created_at 
                  FROM " . $this->table_name;
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}