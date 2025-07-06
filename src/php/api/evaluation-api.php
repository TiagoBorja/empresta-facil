<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/Evaluation.php';

$evaluation = new Evaluation();

if (isset($_GET['bookId']) && isset($_GET['userId'])) {
    $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
    $evaluation->setBookFk($bookId);
    $evaluation->setUserFk($userId);

    echo $evaluation->getBookEvalutionByUserId($evaluation->getUserFk(), $evaluation->getBookFk());
    exit;
}
if (isset($_GET['bookId'])) {
    $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
    $evaluation->setBookFk($bookId);
    echo $evaluation->getEvaluationsByBookId($evaluation->getBookFk());
    exit;
}

if (isset($_POST['saveData'])) {
    $bookFk = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userFk = $_SESSION['user']['id'];
    $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS);

    $evaluation->setUserFk($userFk);
    $evaluation->setBookFk($bookFk);
    $evaluation->setRate($rate);

    if ($evaluation->exists()) {
        echo $evaluation->update();
    } else {
        echo $evaluation->create();
    }

    exit;
}
