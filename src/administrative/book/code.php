<?php

header('Content-Type: application/json');
session_start();
include_once '../../php/classes/Book.php';
include_once '../../php/classes/AuthorBook.php';
include_once '../../php/classes/Utils.php';

$book = new Book();
$userId = $_SESSION['user']['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['mostRequested'])) {
        echo $book->getMostRequested();
        exit;
    }

    if (isset($_GET['userRecommend'])) {
        echo $book->getRecommendedBooksByUser($userId);
        exit;
    }

    if (!isset($_GET['id'])) {
        echo $book->getAll();
        exit;
    }

    if (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $book->setId($id);
        echo $book->getById($id);
        exit;
    }
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
    $synopsis = filter_input(INPUT_POST, 'synopsis', FILTER_SANITIZE_SPECIAL_CHARS);

    $authors = $_POST['authors'] ?? [];
    $authors = array_filter(array_map(function ($authorId) {
        return filter_var($authorId, FILTER_SANITIZE_NUMBER_INT);
    }, $authors));

    $book->setTitle($title);
    $book->setIsbn($isbn);
    $book->setReleaseYear($releaseYear);
    $book->setLanguage($language);
    $book->setQuantity($quantity);
    $book->setPublisher($publisherFk);
    $book->setCategory($categoryFk);
    $book->setSubcategory($subcategoryFk);
    $book->setSynopsis($synopsis);
    $book->setCreatedFk($userId);

    if (isset($_FILES["bookImg"]) && $_FILES["bookImg"]["tmp_name"] != "") {
        $imgPath = Utils::uploadImage('../../administrative/book/upload', 'bookImg');

        $book->setImgUrl($imgPath);
    }
    if (!empty($id)) {
        $book->setId($id);
        $book->setUpdatedFk($userId);
        echo $book->update($id, $authors);
        exit;
    }
    echo $book->create($authors);
    exit;
}


if (isset($_POST['changeStatus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($status === 'Y') ? 'N' : 'Y';

    $book->setId($id);
    $book->setActive($status);
    $book->setUpdatedFk($userId);

    echo $book->changeActiveStatus($id, $status);
    exit;
}