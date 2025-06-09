<?php

header('Content-Type: application/json');
include_once '../../php/classes/Book.php';

$book = new Book();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $book->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $book->setId($id);
    echo $book->getById($id);
    exit;
}


if (isset($_POST['saveData'])) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_SPECIAL_CHARS);
    $releaseYear = filter_input(INPUT_POST, 'releaseYear', FILTER_SANITIZE_NUMBER_INT);
    $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
    $resourceType = filter_input(INPUT_POST, 'resourceType', FILTER_SANITIZE_SPECIAL_CHARS);
    $publisherFk = filter_input(INPUT_POST, 'publisher', FILTER_SANITIZE_NUMBER_INT);
    $categoryFk = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $subcategoryFk = filter_input(INPUT_POST, 'subcategory', FILTER_SANITIZE_NUMBER_INT);
    $locationFk = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT);
    $stateFk = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);

    $livro->setTitle($title);
    $livro->setIsbn($isbn);
    $livro->setReleaseYear($releaseYear);
    $livro->setLanguage($language);
    $livro->setQuantity($quantity);
    $livro->setResourceType($resourceType);
    $livro->setPublisherFk($publisherFk);
    $livro->setCategoryFk($categoryFk);
    $livro->setSubcategoryFk($subcategoryFk);
    $livro->setLocationFk($locationFk);
    $livro->setStateFk($stateFk);
    $livro->setSynopsis($synopsis);

    if (!empty($id)) {
        $livro->setId($id);
        echo $livro->update($id);
        exit;
    }

    echo $livro->create();
    exit;
}


if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $book->setId($id);
    $book->setActive($status);

    echo $book->changeActiveStatus($id, $status);
    exit;
}