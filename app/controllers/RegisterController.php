<?php
// Sửa đường dẫn cho đúng cấu trúc thư mục bạn gửi
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Notification.php';

class RegisterController {
    private $userModel;
    private $notificationModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new UserModel($this->db);
        $this->notificationModel = new NotificationModel($this->db);
    }

    public function register() {
        $error = ""; 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username   = trim($_POST['username']);
            $fullName   = trim($_POST['full_name']);
            $email      = trim($_POST['email']);
            $password   = $_POST['password'];
            $rePassword = $_POST['confirm_password']; // Đã sửa khớp với name trong HTML

            if ($password !== $rePassword) {
                $error = "Mật khẩu nhập lại không khớp";
            } elseif ($this->userModel->isUsernameExists($username)) {
                $error = "Username đã tồn tại";
            } elseif ($this->userModel->isEmailExists($email)) {
                $error = "Email đã tồn tại";
            } else {
                if ($this->userModel->register($username, $password, $fullName, $email)) {
                    $user = $this->userModel->findByUsername($username);
                    $this->notificationModel->create($user['user_id'], 'register');
                    $this->redirectLoginWithSuccess();
                }
                $error = "Đăng ký thất bại";
            }
        }
        // Hiển thị view
        require __DIR__ . '/../../views/auth/register.php';
    }

    /**
     * Hàm thông báo và chuyển hướng sau khi đăng ký thành công
     */
    private function redirectLoginWithSuccess() {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Lưu thông báo vào session (Flash Message)
        $_SESSION['register_success'] = "Chúc mừng! Bạn đã đăng ký tài khoản thành công. Vui lòng đăng nhập.";
        session_write_close();
        header('Location: /Library_management_system/views/auth/login.php');
        exit;
    }
}