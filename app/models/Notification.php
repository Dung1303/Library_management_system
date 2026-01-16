<?php
class NotificationModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($userId, $type) {
        $sql = "INSERT INTO notifications (user_id, type, status)
                VALUES (:user_id, :type, 'sent')";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':type', $type);

        return $stmt->execute();
    }
}