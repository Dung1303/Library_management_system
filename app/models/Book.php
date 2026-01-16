<?php

/**
 * File: app/models/Book.php
 * Chịu trách nhiệm truy vấn dữ liệu Sách và Bản sao (Book Copies)
 */

class Book
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Lấy danh sách sách có phân trang và đếm số bản sao 'Available'
     * Đáp ứng AC 3 & AC 4
     */
    public function getBooksWithPagination($page = 1, $limit = 15)
    {
        try {
            $offset = ($page - 1) * $limit;

            // Truy vấn lấy thông tin sách và đếm số bản sao có trạng thái 'Available'
            $sql = "SELECT b.*, 
                    (SELECT COUNT(*) FROM book_copies bc WHERE bc.book_id = b.id AND bc.status = 'Available') as stock_count 
                    FROM books b 
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching books: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Đếm tổng số đầu sách để tính toán số trang (AC 4)
     */
    public function getTotalBooksCount()
    {
        try {
            $sql = "SELECT COUNT(*) FROM books";
            return (int)$this->db->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
}
