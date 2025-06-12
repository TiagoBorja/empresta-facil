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




// if (isset($_POST['saveData'])) {

//     $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?: filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
//     $authorBookName = filter_input(INPUT_POST, 'publisherName', FILTER_SANITIZE_SPECIAL_CHARS);

//     $authorBook->setPublisher($authorBookName);

//     if (!empty($id)) {
//         $authorBook->setId($id);
//         echo $authorBook->update($id);
//         exit;
//     }

//     echo $authorBook->create();
//     exit;
// }

// if (isset($_POST['changeStatus'])) {
//     $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
//     $status = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS);
//     $status = ($status === 'Y') ? 'N' : 'Y';

//     $authorBook->setId($id);
//     $authorBook->setActive($status);

//     echo $authorBook->changeActiveStatus($id, $status);
//     exit;
// }