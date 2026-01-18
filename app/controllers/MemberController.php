<?php

/**
 * Controller MemberController - Xử lý logic cho trang chủ
 * File: app/controllers/MemberController.php
 */

// Include model Book
require_once __DIR__ . '/../models/Book.php';

class MemberController
{
    /**
     * Action index - Hiển thị trang chủ với grid sách
     * Xử lý tất cả Acceptance Criteria từ Jira LMS-86:
     * 
     * AC 1: Grid Display - 5 books per row (xử lý ở CSS)
     * AC 2: Book Information - Hiển thị đầy đủ thông tin sách
     * AC 3: Stock Logic - Lấy từ bảng book_copies
     * AC 4: Pagination - 15 books mỗi trang
     * AC 5: Navigation - Previous/Next và số trang
     * AC 6: Empty State - Thông báo khi không có sách
     */
    public function index()
    {
        // Lấy số trang từ URL (?page=1, ?page=2, ...)
        // Mặc định là trang 1
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Đảm bảo $page >= 1
        if ($page < 1) {
            $page = 1;
        }

        // Lấy filter theo category nếu có
        $categoryId = null;
        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $categoryId = intval($_GET['category']);
        }

        // Lấy search term nếu có
        $search = null;
        if (isset($_GET['search']) && trim($_GET['search']) !== '') {
            $search = trim($_GET['search']);
        }

        // Khởi tạo model Book
        $bookModel = new Book();

        // Lấy danh sách sách cho trang hiện tại
        $books = $bookModel->getBooks($page, $categoryId, $search);

        // Đếm tổng số sách (để tính số trang)
        $total = $bookModel->getTotalBooks($categoryId, $search);

        // Tính tổng số trang (15 sách/trang theo AC 4)
        $totalPages = ceil($total / 15);

        // Lấy tất cả danh mục cho dropdown
        $categories = $bookModel->getCategories();

        // Debug (bỏ comment để test)
        // echo "<pre>";
        // echo "Page: $page | Total Books: $total | Total Pages: $totalPages\n";
        // print_r($books);
        // echo "</pre>";
        // exit();

        // Load view và truyền dữ liệu
        // View sẽ nhận các biến: $books, $categories, $page, $totalPages, $total
        require_once __DIR__ . '/../../views/members/index.php';
    }

    /**
     * Action search - Xử lý tìm kiếm sách
     */
    public function search()
    {
        // Redirect về index với tham số search
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (empty($search)) {
            header('Location: index.php');
            exit();
        }

        // Có thể redirect hoặc xử lý tương tự index
        // Hiện tại đơn giản là redirect
        header('Location: index.php?search=' . urlencode($search));
        exit();
    }

    /**
     * Action category - Lọc theo danh mục
     */
    public function category()
    {
        $categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($categoryId <= 0) {
            header('Location: index.php');
            exit();
        }

        // Redirect về index với tham số category
        header('Location: index.php?category=' . $categoryId);
        exit();
    }
}
