<?php

/**
 * File: views/members/home.php
 * Mục đích: Sườn cấu trúc trang chủ cho Member/Guest dựa trên thiết kế mẫu
 * Đáp ứng AC 1, 2, 4, 5, 6 của User Story
 */

// Tự động xác định đường dẫn gốc để tránh lỗi CSS khi chạy từ các thư mục khác nhau
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
// Lấy thư mục gốc của project
$baseUrl = $protocol . "://" . $host . str_replace(['/views/members/home.php', '/index.php'], '', $scriptName);
$baseUrl = rtrim($baseUrl, '/') . '/';

// Kiểm tra trạng thái đăng nhập
$isLoggedIn = isset($_SESSION['user_id']) ? true : false;

// Đảm bảo các biến dữ liệu từ Controller
if (!isset($books)) $books = [];
if (!isset($currentPage)) $currentPage = 1;
if (!isset($totalPages)) $totalPages = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home</title>
    <!-- Liên kết file CSS đảm bảo y chang thiết kế -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>public/css/members.css?v=<?php echo time(); ?>">
</head>

<body>

    <div class="container">

        <?php if (!$isLoggedIn) : ?>
            <!-- Hero Section: Chuẩn giao diện thiết kế cho người dùng mới -->
            <div class="hero-section">
                <div class="hero-content">
                    <h1>Explore Our World of Knowledge</h1>
                    <p>Join our community to access thousands of resources, track your reading history, and borrow books online.</p>
                    <div class="hero-buttons">
                        <a href="index.php?action=register" class="btn-primary">Get Started Today</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Header phần danh sách sách -->
        <div class="section-header">
            <div class="header-text">
                <h2>Featured Books</h2>
                <p>Check out our latest arrivals and popular picks</p>
            </div>
            <?php if ($isLoggedIn) : ?>
                <div class="user-badge-header">
                    <small>Welcome back,</small>
                    <strong>Member</strong>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($books)) : ?>
            <!-- AC 6: Empty State đúng như yêu cầu -->
            <div class="empty-state">
                <div class="empty-icon">📚</div>
                <h3>No books available in this category.</h3>
                <p>We couldn't find any books matching your criteria at the moment.</p>
            </div>
        <?php else : ?>
            <!-- AC 1: Grid hiển thị 5 sách mỗi hàng -->
            <div class="book-grid">
                <?php foreach ($books as $book) : ?>
                    <div class="book-card">
                        <!-- AC 2: Ảnh bìa và Badge trạng thái -->
                        <div class="book-cover">
                            <?php
                            $coverPath = !empty($book['image']) ? $baseUrl . "public/images/" . $book['image'] : $baseUrl . "public/images/default-cover.jpg";
                            ?>
                            <img src="<?php echo $coverPath; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">

                            <!-- Badge trạng thái (Available/Out of Stock) -->
                            <div class="status-badge">
                                <?php if (isset($book['stock_count']) && $book['stock_count'] > 0) : ?>
                                    <span class="badge available">Available</span>
                                <?php else : ?>
                                    <span class="badge out-of-stock">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="book-info">
                            <!-- Thể loại sách (Nhỏ, in hoa) -->
                            <span class="category"><?php echo htmlspecialchars($book['category'] ?? 'General'); ?></span>

                            <!-- Tiêu đề và Tác giả -->
                            <h3 class="title"><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p class="author">by <span><?php echo htmlspecialchars($book['author']); ?></span></p>

                            <div class="card-footer">
                                <!-- AC 3: Số lượng bản sao còn lại -->
                                <small class="stock-count"><?php echo (int)$book['stock_count']; ?> copies left</small>

                                <?php if ($isLoggedIn) : ?>
                                    <a href="index.php?action=borrow&id=<?php echo $book['id']; ?>" class="borrow-link">Borrow →</a>
                                <?php else : ?>
                                    <a href="index.php?action=login" class="borrow-link guest">Join to Borrow</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- AC 4 & 5: Phân trang chuyên nghiệp -->
            <?php if ($totalPages > 1) : ?>
                <div class="pagination">
                    <a href="index.php?page=<?php echo max(1, $currentPage - 1); ?>"
                        class="page-btn <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">Previous</a>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="index.php?page=<?php echo $i; ?>"
                            class="page-num <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <a href="index.php?page=<?php echo min($totalPages, $currentPage + 1); ?>"
                        class="page-btn <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">Next</a>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</body>

</html>