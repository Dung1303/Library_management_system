<?php
// Lớp controller cho thành viên, xử lý logic trang chủ khi chưa đăng nhập

require_once __DIR__ . '/../models/Book.php'; // Path từ app/controllers/ lên app/ rồi vào app/models/

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

        // Debug data (bỏ comment nếu cần test)
        // var_dump($books); exit();

        // Chuyển dữ liệu sang view
        require_once __DIR__ . '/../../views/members/index.php'; // Path từ app/controllers/ lên root rồi vào views/members/
    }
}
