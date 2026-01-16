<?php

/**
 * File: app/controllers/MemberController.php
 * Quản lý logic hiển thị cho Member/Guest
 */

require_once 'app/models/Book.php';

class MemberController
{
    private $bookModel;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->bookModel = new Book($this->db);
    }

    public function index()
    {
        try {
            // Lấy trang hiện tại từ URL, mặc định là trang 1
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 15; // AC 4: 15 sách mỗi trang

            // Lấy dữ liệu từ Model
            $books = $this->bookModel->getBooksWithPagination($currentPage, $limit);
            $totalBooks = $this->bookModel->getTotalBooksCount();
            $totalPages = ceil($totalBooks / $limit);

            // Đường dẫn View
            $viewPath = 'views/members/home.php';
            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                die("View not found.");
            }
        } catch (Exception $e) {
            echo "A system error occurred.";
        }
    }
}
