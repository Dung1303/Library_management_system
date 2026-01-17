<?php // Trong public/index.php, phần parse URL
if ($url == '' || $url == 'home') {
    require_once '../app/controllers/BookController.php';
    $controller = new BookController();
    $controller->index();
}
