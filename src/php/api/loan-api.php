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
    exit;
}
