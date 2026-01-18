<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Hệ Thống Quản Lý Thư Viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* Nền gradient xanh như trong ảnh */
            background: linear-gradient(135deg, #007bff, #6f42c1);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 400px;
            max-width: 90%;
        }
        .card-header {
            /* Header màu xanh nhạt hơn */
            background: linear-gradient(to right, #36d1dc, #5b86e5);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border-bottom: none;
        }
        .header-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .card-header h4 {
            margin-bottom: 5px;
            font-weight: 600;
        }
        .card-header p {
            margin-bottom: 0;
            opacity: 0.8;
            font-size: 14px;
        }
        .card-body {
            padding: 30px;
        }
        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #5b86e5;
            background-color: #fff;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #eee;
            border-left: none;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            cursor: pointer;
            color: #999;
        }
        .btn-register {
            background: linear-gradient(to right, #36d1dc, #5b86e5);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            color: white;
        }
        .btn-register:hover {
            background: linear-gradient(to right, #5b86e5, #36d1dc);
            color: white;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }
        .login-link a {
            color: #5b86e5;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h4>Hệ Thống Quản Lý Thư Viện</h4>
            <p>Đăng ký để tham quan thư viện</p>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error; ?>
                </div>
            <?php endif; ?>
            <form action="/Library_management_system/public/index.php?url=register/register" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                </div>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="VD: Nguyễn Văn A" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="........" required>
                        <span class="input-group-text" onclick="togglePassword('password', 'eye-icon-pass')">
                            <i class="far fa-eye" id="eye-icon-pass"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="........" required>
                        <span class="input-group-text" onclick="togglePassword('confirm_password', 'eye-icon-confirm')">
                            <i class="far fa-eye" id="eye-icon-confirm"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-register">Đăng ký</button>
            </form>
            <div class="login-link">
                Nếu bạn có tài khoản vui lòng ấn <a href="login.php">Đăng nhập</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(iconId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>