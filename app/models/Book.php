<?php

class Book {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Get all books from the database
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY title ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new book (For the Admin/Librarian)
    public function create($title, $author, $isbn, $copies) {
        $sql = "INSERT INTO books (title, author, isbn, available_copies) 
                VALUES (:title, :author, :isbn, :copies)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':isbn' => $isbn,
            ':copies' => $copies
        ]);
    }
}