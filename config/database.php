<?php
// Hàm trả về kết nối PDO đến DB
function getDB()
{
    $host = '127.0.0.1'; // Hoặc 'localhost'
    $dbname = 'library_management'; // Từ dump SQL
    $username = 'root'; // Thay nếu khác
    $password = ''; // Thay nếu có pass

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bật error reporting
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch assoc mặc định
        return $db;
    } catch (PDOException $e) {
        // Die với message (hoặc log error)
        die("Kết nối DB thất bại: " . $e->getMessage());
    }
}
