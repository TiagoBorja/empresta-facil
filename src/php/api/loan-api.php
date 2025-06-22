<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/Loan.php';
include_once '../classes/BookReservation.php';

$loan = new Loan();
$reservation = new BookReservation();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $loan->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $loan->setId($id);
    echo $loan->getById($id);
    exit;
}

if (isset($_GET['reservationId'])) {
    $reservationId = filter_input(INPUT_GET, 'reservationId', FILTER_SANITIZE_NUMBER_INT);
    $reservation->setId($reservationId);
    echo $reservation->getById($reservationId);
    echo $loan->getByReservationId($reservationId);
    exit;
}

if (isset($_POST['saveData'])) {
    $loanId = filter_input(INPUT_POST, 'loanId', FILTER_SANITIZE_NUMBER_INT);
    $reservationId = filter_input(INPUT_POST, 'reservationId', FILTER_SANITIZE_NUMBER_INT);
    $reservationId = !empty($reservationId) ? $reservationId : null;
    $userId = filter_input(INPUT_POST, 'user', filter: FILTER_SANITIZE_NUMBER_INT);
    $employeeFk = $_SESSION['employee']['id'];
    $loanDate = filter_input(INPUT_POST, 'loanDate', filter: FILTER_SANITIZE_SPECIAL_CHARS);
    $dueDate = filter_input(INPUT_POST, 'dueDate', filter: FILTER_SANITIZE_SPECIAL_CHARS);
    $returnDate = filter_input(INPUT_POST, 'returnDate', filter: FILTER_SANITIZE_SPECIAL_CHARS);
    $stateReturn = filter_input(INPUT_POST, 'stateReturn', filter: FILTER_SANITIZE_SPECIAL_CHARS);

    $books = $_POST['books'] ?? [];
    $books = array_filter(array_map(function ($bookId) {
        return filter_var($bookId, FILTER_SANITIZE_NUMBER_INT);
    }, $books));

    $loan->setReservationFk($reservationId);
    $loan->setUserFk($userId);
    $loan->setEmployeeFk($employeeFk);
    $loan->setDueDate($dueDate);
    $loan->setReturnDate($returnDate);
    $loan->setReturnDate($returnDate);
    $loan->setStateReturn($stateReturn);
    if ($loanId) {
        $loan->setId($loanId);
        echo $loan->update($loanId);
        exit;
    }

    echo $loan->create($books);
    exit;
}
