<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "library_management";
    private $conn;

    public function connect()
    {
        try {
            // DSN
            $dsn = "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4";

            // Tạo PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Bật chế độ Exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;
        } catch (PDOException $e) {
            die("Kết nối CSDL thất bại: " . $e->getMessage());
        }
    }
}
