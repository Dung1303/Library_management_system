<?php
// View cho trang chủ thành viên khi chưa đăng nhập, hiển thị grid sách và phân trang
include '../layouts/header.php';
?>

<div class="main-container">
    <div class="banner">
        <h1>Welcome!</h1>
        <p>Discover the world of knowledge through thousands of books</p>
    </div>

    <div class="search-bar">
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search for book title or author">
            <select name="category">
                <option value="">All categories</option>
                <?php if (isset($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="book-grid">
        <?php if (empty($books)): ?>
            <p class="empty-message">No books available.</p>
        <?php else: ?>
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <img src="images/<?php echo htmlspecialchars($book['image_url']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="author"><?php echo htmlspecialchars($book['author']); ?></p>
                    <span class="category-tag"><?php echo htmlspecialchars($book['category_name']); ?></span>
                    <span class="stock-info"><?php echo $book['available']; ?>/<?php echo $book['total_copies']; ?> copies</span>
                    <span class="status-tag <?php echo ($book['available'] > 0) ? 'available' : 'out-of-stock'; ?>">
                        <?php echo ($book['available'] > 0) ? 'Available' : 'Out of Stock'; ?>
                    </span>
                    <a href="detail.php?id=<?php echo $book['book_id']; ?>" class="detail-button">Detail</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (isset($totalPages) && $totalPages > 0): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="page-link">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>