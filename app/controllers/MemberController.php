<?php
// Lớp controller cho thành viên, xử lý logic trang chủ khi chưa đăng nhập

require_once 'models/Book.php';

class MemberController
{
    // Hành động index: hiển thị trang chủ với sách và phân trang
    public function index()
    {
        // Tính toán trang hiện tại từ URL (?page=)
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page < 1) $page = 1;

        // Khởi tạo model và lấy dữ liệu
        $bookModel = new Book();
        $books = $bookModel->getBooks($page);
        $total = $bookModel->getTotalBooks();
        $totalPages = ceil($total / 15);
        $categories = $bookModel->getCategories();

        // Chuyển dữ liệu sang view
        require_once 'views/members/index.php';
    }
}
