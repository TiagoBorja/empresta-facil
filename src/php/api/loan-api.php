<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/Loan.php';
include_once '../classes/BookReservation.php';
include_once '../classes/User.php';

$loan = new Loan();
$loanBook = new LoanBook();
$user = new User();
$reservation = new BookReservation();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch (true) {
        case isset($_GET['id']):
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $bookId = filter_input(INPUT_GET, 'bookId', FILTER_SANITIZE_NUMBER_INT);
            $loan->setId($id);
            $loan->setBookFk($bookId);
            echo $loan->getById($id, $bookId);
            break;

        case isset($_GET['getLoanCount']):
            $stateType = filter_input(INPUT_GET, 'stateType', FILTER_SANITIZE_STRING);
            echo $loan->getLoanCount($stateType);
            break;

        case isset($_GET['reservationId']):
            $reservationId = filter_input(INPUT_GET, 'reservationId', FILTER_SANITIZE_NUMBER_INT);
            $reservation->setId($reservationId);
            echo $reservation->getById($reservationId);
            break;

        case isset($_GET['notifyLoanExpiration']):
            $userId = filter_input(INPUT_GET, 'user', filter: FILTER_SANITIZE_NUMBER_INT);
            $bookFk = filter_input(INPUT_GET, 'bookFk', filter: FILTER_SANITIZE_NUMBER_INT);
            $email = $user->getUserEmail($userId);
            $firstName = $user->getUserFirstName($userId);
            $bookTitle = $loanBook->getBookTitle($bookFk);
            echo Utils::notifyLoanExpiration(
                $email,
                $firstName,
                $bookTitle,
                $_SESSION['employee']['biblioteca'],
                $_SESSION['employee']['morada'],
            );
            break;
        case isset($_GET['notifyUpcomingLoanExpiration']):
            $userId = filter_input(INPUT_GET, 'user', filter: FILTER_SANITIZE_NUMBER_INT);
            $bookFk = filter_input(INPUT_GET, 'bookFk', filter: FILTER_SANITIZE_NUMBER_INT);
            $email = $user->getUserEmail($userId);
            $firstName = $user->getUserFirstName($userId);
            $bookTitle = $loanBook->getBookTitle($bookFk);
            echo Utils::notifyUpcomingLoanExpiration(
                $email,
                $firstName,
                $bookTitle,
                $_SESSION['employee']['biblioteca'],
                $_SESSION['employee']['morada'],
            );
            break;

        case isset($_GET['userId']):
            $userId = $_SESSION['user']['id'];
            $loan->setUserFk($userId);
            echo $loan->getLoansByUserId($loan->getUserFk());
            break;

        default:
            echo $loan->getAll();
            break;
    }

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
    $statePickUp = filter_input(INPUT_POST, 'statePickUp', filter: FILTER_SANITIZE_NUMBER_INT);
    $stateReturn = filter_input(INPUT_POST, 'stateReturn', filter: FILTER_SANITIZE_NUMBER_INT);

    $books = $_POST['books'] ?? [];
    $books = array_filter(array_map(function ($bookId) {
        return filter_var($bookId, FILTER_SANITIZE_NUMBER_INT);
    }, $books));

    $loan->setReservationFk($reservationId);
    $loan->setUserFk($userId);
    $loan->setEmployeeFk($employeeFk);
    $loan->setDueDate($dueDate);
    $loan->setReturnDate($returnDate);
    $loan->setStatePickUp($statePickUp);
    $loan->setStateReturn($stateReturn);

    if ($loanId && $bookFk) {
        $loan->setId($loanId);
        $loanBook->setBookFk($bookFk);
        $loanBook->setStateReturn($stateReturn);

        echo $loanBook->update(
            $loan->getId(),
            $loanBook->getStateReturn(),
            $loan->getReturnDate(),
            $loanBook->getBookFk(),
        );

        exit;
    }

    if ($loan->getReservationFk() !== null) {
        $bookFk = filter_input(INPUT_POST, 'bookSelect', FILTER_SANITIZE_NUMBER_INT);
        $loan->setBookFk($bookFk);
        echo $loan->createReservation();
        exit;
    }
    echo $loan->create($books);
    exit;
}