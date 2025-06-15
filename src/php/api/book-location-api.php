<?php

header('Content-Type: application/json');
include_once '../classes/BookLocation.php';

$bookLocation = new BookLocation();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $bookLocation->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bookLocation->setId($id);
    echo $bookLocation->getById($id);
    exit;
}
