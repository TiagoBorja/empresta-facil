<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/Comments.php';

$comments = new Comments();

if (isset($_GET['bookId'])) {
    $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
    $comments->setBookFk($bookId);
    echo $comments->getCommentsByBookId($comments->getBookFk());
    exit;
}

if (isset($_GET['userId'])) {
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
    $comments->setUserFk($userId);
    echo $comments->getLastCommentsByUserId($comments->getUserFk());
    exit;
}

if (isset($_POST['saveData'])) {
    $bookFk = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userFk = $_SESSION['user']['id'];
    $comment = filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_SPECIAL_CHARS);

    $comments->setUserFk($userFk);
    $comments->setBookFk($bookFk);
    $comments->setComment($comment);

    echo $comments->create();
    exit;
}