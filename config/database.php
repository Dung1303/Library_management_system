<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_management";

try {
    // Thiết lập DSN (Data Source Name)
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

    // Tạo đối tượng PDO
    $conn = new PDO($dsn, $username, $password);

    // Thiết lập chế độ báo lỗi (Error Mode) thành Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Kết nối thành công bằng PDO!";
} catch (PDOException $e) {
    // Nếu có lỗi, nó sẽ nhảy vào đây
    echo "Kết nối thất bại: " . $e->getMessage();
}

// Ngắt kết nối (không bắt buộc, PHP sẽ tự đóng khi hết script)
// $conn = null;
