<?php
session_start();

require_once '../config/database.php';
require_once '../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new UserModel($db);
    }

    // SCRUM-71
    public function login()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // 1. Gọi SCRUM-70
        $user = $this->userModel->findByUsername($username);

        if (!$user) {
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: ../views/login.php");
            exit();
        }

        // 2. Kiểm tra trạng thái tài khoản
        if ($user['status'] !== 'active') {
            $_SESSION['login_error'] = "Account is locked";
            header("Location: ../views/login.php");
            exit();
        }

        // 3. Check password (SCRUM-71)
        if (!password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: ../views/login.php");
            exit();
        }

        // 4. Start session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // 5. Redirect theo role
        if ($user['role'] === 'admin') {
            header("Location: ../views/admin/dashboard.php");
        } else {
            header("Location: ../views/member/home.php");
        }
        exit();
    }
    public function logout()
    {
        // Khởi tạo session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // AC 2: Xóa tất cả dữ liệu session và hủy session
        $_SESSION = array();
        session_destroy();

        // AC 3: Điều hướng về trang Login hoặc Home
        header("Location: ../../../../public/index.php");
        exit();
    }
}

// Router đơn giản
$auth = new AuthController();
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    $auth->login();
}
