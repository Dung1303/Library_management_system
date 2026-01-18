<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    // SCRUM-71
    public function login() {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // 1. Gọi SCRUM-70
        $user = $this->userModel->findByUsername($username); // Model đã update để tìm cả email

        if (!$user) {
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: /Library_management_system/views/auth/login.php");
            exit();
        }

        // 2. Kiểm tra trạng thái tài khoản
        if ($user['status'] !== 'active') {
            $_SESSION['login_error'] = "Account is locked";
            header("Location: /Library_management_system/views/auth/login.php");
            exit();
        }

        // 3. Check password (SCRUM-71)
        if (!password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: /Library_management_system/views/auth/login.php");
            exit();
        }

        // 4. Start session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // 5. Redirect theo role
        if ($user['role'] === 'admin') {
            header("Location: /Library_management_system/views/admin/dashboard.php");
        } else {
            // Chuyển hướng về trang chủ public để load sách
            header("Location: /Library_management_system/public/index.php");
        }
        exit();
    }

    public function logout() {
        // Xóa tất cả dữ liệu session hiện tại
        $_SESSION = [];
        
        // Hủy session
        session_destroy();

        // Chuyển hướng về trang chủ (trạng thái chưa đăng nhập)
        header("Location: /Library_management_system/public/index.php");
        exit();
    }
}
