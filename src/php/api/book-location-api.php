<?php

session_start();
header('Content-Type: application/json');

include_once '../classes/BookLocation.php';

$bookLocation = new BookLocation();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id']) && !isset($_GET['bookId'])) {
    echo $bookLocation->getAll($_SESSION['employee']['biblioteca_fk']);
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bookLocation->setId($id);
    echo $bookLocation->getById($id);
    exit;
}

if (isset($_GET['bookId']) && isset($_GET['userId'])) {
    $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
    echo $bookLocation->getLibrariesByUserId($userId, $bookId);
    exit;
}
if (isset($_GET['bookId'])) {
    $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
    echo $bookLocation->getBookStockById($bookId);
    exit;
}

if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bookFk = filter_input(INPUT_POST, 'book', FILTER_SANITIZE_NUMBER_INT);
    $locationFk = filter_input(INPUT_POST, 'locations', FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

    $bookLocation->setBookFk($bookFk);
    $bookLocation->setLocationFk($locationFk);
    $bookLocation->setQuantity($quantity);

    if ($id) {
        $bookLocation->setId($id);
        echo $bookLocation->update();
        exit;
    }
    echo $bookLocation->create();

    exit;
}
