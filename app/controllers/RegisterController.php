<?php
// Sửa đường dẫn cho đúng cấu trúc thư mục bạn gửi
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Notification.php';

class RegisterController {
    private $userModel;
    private $notificationModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->notificationModel = new NotificationModel($db);
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
                    header('Location: login.php'); // Sau khi xong về login
                    exit;
                }
                $error = "Đăng ký thất bại";
            }
        }
        // Hiển thị view
        require __DIR__ . '/../views/auth/register.php';
    }
}

// LỆNH KÍCH HOẠT QUAN TRỌNG:
// Sửa lại dòng này nếu bạn giữ tên hàm là connect()
$database = new Database();
$db = $database->connect(); // Gọi connect() thay vì getConnection()

$controller = new RegisterController($db);
$controller->register();