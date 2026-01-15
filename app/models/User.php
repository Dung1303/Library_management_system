<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // SCRUM-70: tìm user theo username
    public function findByUsername($username) {
        $sql = "SELECT user_id, username, password, role, status 
                FROM users 
                WHERE username = :username 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}