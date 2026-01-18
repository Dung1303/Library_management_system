<?php
// Model class for books - handles all book and category related queries

class Book
{
    private $db;
    const ITEMS_PER_PAGE = 15; // AC 4: 15 books per page

    public function __construct()
    {
        require_once __DIR__ . '/../../config/database.php';
        $this->db = getDB();
    }

    /**
     * Get all categories from database
     * @return array List of all categories
     */
    public function getCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY category_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total number of books for pagination calculation
     * @param int|null $categoryId Optional category filter
     * @return int Total count of books
     */
    public function getTotalBooks($categoryId = null)
    {
        if ($categoryId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM books WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        $stmt = $this->db->query("SELECT COUNT(*) FROM books");
        return $stmt->fetchColumn();
    }

    /**
     * Get paginated list of books with stock information
     * AC 1: Grid Display - returns books for grid layout
     * AC 2: Book Information - includes Cover, Title, Author, Category, Stock
     * AC 3: Stock Logic - calculates available/total from book_copies table
     * AC 4: Pagination - uses LIMIT 15 and OFFSET
     * 
     * @param int $page Current page number (1-indexed)
     * @param int|null $categoryId Optional category filter
     * @param string|null $search Optional search term
     * @return array List of books with all required information
     */
    public function getBooks($page = 1, $categoryId = null, $search = null)
    {
        $limit = self::ITEMS_PER_PAGE; // 15 books per page
        $offset = ($page - 1) * $limit;

        // Base query with JOIN to get category name and stock information
        $query = "SELECT 
                    b.book_id, 
                    b.title, 
                    b.author, 
                    b.image_url,
                    c.category_id,
                    c.category_name,
                    COUNT(bc.book_copy_id) AS total_copies,
                    SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) AS available
                  FROM books b
                  LEFT JOIN categories c ON b.category_id = c.category_id
                  LEFT JOIN book_copies bc ON b.book_id = bc.book_id";

        // Add WHERE conditions
        $conditions = [];
        $params = [];

        if ($categoryId) {
            $conditions[] = "b.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        if ($search) {
            $conditions[] = "(b.title LIKE :search OR b.author LIKE :search)";
            $params[':search'] = "%{$search}%";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Group by book and add pagination
        $query .= " GROUP BY b.book_id
                    ORDER BY b.book_id ASC
                    LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);

        // Bind parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get book details by ID
     * @param int $bookId
     * @return array|false Book details or false if not found
     */
    public function getBookById($bookId)
    {
        $query = "SELECT 
                    b.book_id, 
                    b.title, 
                    b.author, 
                    b.image_url,
                    c.category_id,
                    c.category_name,
                    COUNT(bc.book_copy_id) AS total_copies,
                    SUM(CASE WHEN bc.status = 'available' THEN 1 ELSE 0 END) AS available
                  FROM books b
                  LEFT JOIN categories c ON b.category_id = c.category_id
                  LEFT JOIN book_copies bc ON b.book_id = bc.book_id
                  WHERE b.book_id = :book_id
                  GROUP BY b.book_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Search books by title or author
     * @param string $searchTerm
     * @param int $page
     * @return array List of matching books
     */
    public function searchBooks($searchTerm, $page = 1)
    {
        return $this->getBooks($page, null, $searchTerm);
    }

    /**
     * Get books by category
     * @param int $categoryId
     * @param int $page
     * @return array List of books in category
     */
    public function getBooksByCategory($categoryId, $page = 1)
    {
        return $this->getBooks($page, $categoryId);
    }
}
