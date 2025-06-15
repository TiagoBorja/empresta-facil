<?php

header('Content-Type: application/json');
include_once '../../php/classes/AuthorBook.php';

$authorBook = new AuthorBook();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $authorBook->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    echo $authorBook->getAuthorsByBookId($id);
    exit;
}