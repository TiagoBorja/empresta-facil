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