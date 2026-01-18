<?php
// Hàm trả về kết nối PDO đến DB
function getDB()
{
    // Cấu hình database - Thay đổi các thông tin này theo môi trường của bạn
    $host = '127.0.0.1'; // Hoặc 'localhost'
    $dbname = 'library_management'; // Tên database từ dump SQL
    $username = 'root'; // Username MySQL (thường là 'root' cho localhost)
    $password = ''; // Password MySQL - Mặc định là rỗng cho XAMPP/WAMP localhost
    
    // Nếu bạn có password, đổi thành: $password = 'your_password';

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    } catch (PDOException $e) {
        die("Kết nối DB thất bại: " . $e->getMessage() . 
            "<br><br><strong>Hướng dẫn:</strong><br>" .
            "1. Kiểm tra MySQL/MariaDB đã chạy chưa<br>" .
            "2. Kiểm tra username và password trong file config/database.php<br>" .
            "3. Đảm bảo database 'library_management' đã được tạo (import file library_management.sql)<br>" .
            "4. Với XAMPP/WAMP localhost, password thường là rỗng (''), không phải 'root'");
    }
}
