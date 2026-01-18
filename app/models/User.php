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
                WHERE username = :username OR email = :username
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


/* =========================
       SCRUM-76: CHECK TỒN TẠI
    ========================== */
    public function isUsernameExists($username) {
        $sql = "SELECT user_id FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch() ? true : false;
    }

    public function isEmailExists($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch() ? true : false;
    }

    /* =========================
       SCRUM-77: ĐĂNG KÝ USER
    ========================== */
    public function register($username, $password, $fullName, $email) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users 
                    (username, password, full_name, email, role, status)
                VALUES 
                    (:username, :password, :full_name, :email, 'member', 'active')";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }
}
