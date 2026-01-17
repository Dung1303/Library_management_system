<?php
// Lớp model cho sách, xử lý các truy vấn liên quan đến sách và danh mục

class Book
{
    private $db;

    public function __construct()
    {
        require_once 'config/database.php';
        $this->db = getDB(); // Giả định getDB() trả về kết nối PDO từ config/database.php
    }

    // Lấy tất cả danh mục sách
    public function getCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số sách để tính toán phân trang
    public function getTotalBooks()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM books");
        return $stmt->fetchColumn();
    }

    // Lấy danh sách sách với phân trang, sử dụng LIMIT và OFFSET
    // Bao gồm thông tin stock: available/total copies
    public function getBooks($page = 1)
    {
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $query = "SELECT b.book_id, b.title, b.author, c.category_name, b.image_url,
                         COUNT(bc.book_copy_id) AS total_copies,
                         SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) AS available
                  FROM books b
                  LEFT JOIN categories c ON b.category_id = c.category_id
                  LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                  GROUP BY b.book_id
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
