<?php
// Định nghĩa đường dẫn gốc dự án để dùng chung
$projectRoot = '/Library_management_system';
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>LibraSys</title>


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $projectRoot; ?>/public/css/layout.css">
</head>


<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">


            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo $projectRoot; ?>/public/index.php">
                <img src="<?php echo $projectRoot; ?>/public/images/logo.jpg" alt="LibraSys Logo" height="40"
                    class="me-2">
                <span class="fw-bold">LibraSys</span>
            </a>


            <!-- Toggle mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active nav-item-custom" href="<?php echo $projectRoot; ?>/public/index.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-item-custom" href="<?php echo $projectRoot; ?>/public/index.php?url=book/borrowed">
                            Borrowed Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-item-custom" href="<?php echo $projectRoot; ?>/public/index.php?url=user/profile">
                            Profile
                        </a>
                    </li>
                </ul>


                <!-- User info -->
                <div class="d-flex align-items-center gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="text-end">
                            <div class="fw-semibold">
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </div>
                            <small class="text-muted"><?php echo ucfirst($_SESSION['role'] ?? 'Member'); ?></small>
                        </div>

                        <a href="<?php echo $projectRoot; ?>/public/index.php?url=auth/logout" class="btn btn-danger btn-sm">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?php echo $projectRoot; ?>/views/auth/login.php" class="btn btn-primary btn-sm">
                            Login
                        </a>
                        <a href="<?php echo $projectRoot; ?>/views/auth/register.php" class="btn btn-outline-primary btn-sm">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </nav>