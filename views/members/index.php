<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library - Browse Books</title>
    <link rel="stylesheet" href="/css/members.css">
    <link rel="stylesheet" href="/css/layout.css">
</head>

<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <!-- Banner chào mừng -->
    <section class="welcome-banner">
        <div class="container">
            <h1 class="welcome-title">Discover Your Next Great Read 📚</h1>
            <p class="welcome-subtitle">Browse thousands of books from our collection</p>
        </div>
    </section>

    <!-- Phần tìm kiếm và lọc -->
    <section class="search-section" id="books">
        <div class="container">
            <form method="GET" action="index.php" class="search-filter-wrapper">
                <!-- Ô tìm kiếm -->
                <div class="search-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" name="search" placeholder="Search by book title or author name"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>

                <!-- Dropdown lọc theo danh mục -->
                <div class="category-dropdown">
                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['category_id']; ?>"
                            <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['category_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 7l5 5 5-5H5z" />
                    </svg>
                </div>
            </form>
        </div>
    </section>

    <!-- Phần hiển thị sách dạng grid -->
    <section class="books-section">
        <div class="container">
            <?php if (empty($books)): ?>
            <!-- Thông báo khi không có sách -->
            <div class="empty-message">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" stroke="#ccc" stroke-width="2">
                    <rect x="16" y="12" width="32" height="40" rx="2" />
                    <line x1="24" y1="20" x2="40" y2="20" />
                    <line x1="24" y1="28" x2="40" y2="28" />
                    <line x1="24" y1="36" x2="32" y2="36" />
                </svg>
                <p>No books available in this category.</p>
                <a href="index.php" class="btn-back">View All Books</a>
            </div>
            <?php else: ?>
            <!-- Grid 5 cột hiển thị sách -->
            <div class="books-grid">
                <?php foreach ($books as $book): ?>
                <!-- Card của mỗi cuốn sách -->
                <div class="book-card">
                    <!-- Ảnh bìa sách -->
                    <div class="book-image">
                        <img src="/images/<?php  echo htmlspecialchars($book['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>"
                            onerror="this.src='/public/images/default-book.jpg'">
                        <!-- Badge "Hết hàng" nếu không còn sách -->
                        <?php if ($book['available'] <= 0): ?>
                        <div class="out-of-stock-badge">Out of Stock</div>
                        <?php endif; ?>
                    </div>

                    <!-- Thông tin sách -->
                    <div class="book-info">
                        <!-- Tiêu đề sách -->
                        <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>

                        <!-- Thông tin tác giả -->
                        <div class="book-meta">
                            <div class="book-author">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path
                                        d="M8 2C9.1 2 10 2.9 10 4C10 5.1 9.1 6 8 6C6.9 6 6 5.1 6 4C6 2.9 6.9 2 8 2ZM8 12C10.7 12 14 13.3 14 14V15H2V14C2 13.3 5.3 12 8 12Z" />
                                </svg>
                                <span><?php echo htmlspecialchars($book['author']); ?></span>
                            </div>
                        </div>

                        <!-- Badge danh mục sách -->
                        <div class="book-category-badge">
                            <span class="badge <?php echo getBadgeClass($book['category_id']); ?>">
                                <?php echo htmlspecialchars($book['category_name']); ?>
                            </span>
                        </div>

                        <!-- Footer: Số lượng sách và nút chi tiết -->
                        <div class="book-footer">
                            <div class="stock-info">
                                <span class="stock-label">Available:</span>
                                <span
                                    class="stock-value <?php echo $book['available'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                                    <?php echo $book['available']; ?>/<?php echo $book['total_copies']; ?> copies
                                </span>
                            </div>
                            <button class="btn-detail" onclick="alert('Book ID: <?php echo $book['book_id']; ?>')">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Phân trang -->
            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <!-- Nút Previous -->
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo isset($_GET['category']) && $_GET['category'] !== '' ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="page-btn prev-btn">Previous</a>
                <?php endif; ?>

                <?php
                        // Tính toán phạm vi trang hiển thị
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $page + 2);

                        // Hiển thị trang đầu và dấu ...
                        if ($start > 1): ?>
                <a href="?page=1<?php echo isset($_GET['category']) && $_GET['category'] !== '' ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="page-btn">1</a>
                <?php if ($start > 2): ?>
                <span class="page-dots">...</span>
                <?php endif; ?>
                <?php endif; ?>

                <!-- Hiển thị các số trang -->
                <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo isset($_GET['category']) && $_GET['category'] !== '' ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="page-btn <?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <!-- Hiển thị dấu ... và trang cuối -->
                <?php if ($end < $totalPages): ?>
                <?php if ($end < $totalPages - 1): ?>
                <span class="page-dots">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $totalPages; ?><?php echo isset($_GET['category']) && $_GET['category'] !== '' ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="page-btn"><?php echo $totalPages; ?></a>
                <?php endif; ?>

                <!-- Nút Next -->
                <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo isset($_GET['category']) && $_GET['category'] !== '' ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="page-btn next-btn">Next</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>

<?php
/**
 * Hàm helper để trả về class màu cho badge danh mục
 * @param int $categoryId - ID của danh mục
 * @return string - Class CSS tương ứng
 */
function getBadgeClass($categoryId)
{
    $classes = array(
        1 => 'badge-blue',    // Công nghệ thông tin
        2 => 'badge-green',   // Kinh tế
        3 => 'badge-pink',    // Văn học
        4 => 'badge-purple',  // Kỹ năng
        5 => 'badge-orange'   // Khoa học
    );
    return isset($classes[$categoryId]) ? $classes[$categoryId] : 'badge-blue';
}
?>