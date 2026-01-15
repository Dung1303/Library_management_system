<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Hệ Thống Quản Lý Thư Viện</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #1e90ff, #4b3cff);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        width: 380px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .login-header {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        color: #fff;
        text-align: center;
        padding: 25px 20px;
    }

    .login-header .icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 26px;
    }

    .login-header h5 {
        margin-bottom: 5px;
    }
    </style>
</head>

<body>

    <div class="login-card bg-white">

        <!-- Header -->
        <div class="login-header">
            <div class="icon">
                <i class="bi bi-book"></i>
            </div>
            <h5>Hệ Thống Quản Lý Thư Viện</h5>
            <small>Đăng nhập để tiếp tục</small>
        </div>

        <!-- Body -->
        <div class="p-4">

            <!-- Error message -->
            <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger py-2">
                <?= $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); endif; ?>

            <form method="POST" action="../controllers/AuthController.php?action=login">

                <!-- Email / Username -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="username" class="form-control" placeholder="your@email.com" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Nhập mật khẩu" required>
                        <span class="input-group-text bg-white" style="cursor:pointer;" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Links -->
                <div class="d-flex justify-content-between mb-3" style="font-size: 13px;">
                    <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                    <span>
                        Chưa có tài khoản?
                        <a href="#" class="text-decoration-none">Đăng kí</a>
                    </span>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-primary w-100">
                    Đăng nhập
                </button>
            </form>

        </div>
    </div>

    <!-- JS -->
    <script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    </script>

</body>

</html>