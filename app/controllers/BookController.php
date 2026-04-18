<?php

class BookController {
    private $bookModel;

    public function __construct() {
        // Only let logged-in users access book functions
        AuthController::checkAuth();
        $this->bookModel = new Book();
    }

    public function index() {
        $books = $this->bookModel->getAll();
        include '../views/books/list.php';
    }
}