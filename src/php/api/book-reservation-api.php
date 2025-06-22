<?php
session_start();
header('Content-Type: application/json');
include_once '../classes/BookReservation.php';

$bookReservation = new BookReservation();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    echo $bookReservation->getAll();
    exit;
}

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bookReservation->setId($id);
    echo $bookReservation->getById($id);
    exit;
}

if (isset($_POST['reservationSubmit'])) {

    $userId = $_SESSION['user']['id'];
    $locationId = filter_input(INPUT_POST, 'library', FILTER_SANITIZE_NUMBER_INT);
    $pickUpDate = filter_input(INPUT_POST, 'pickUpDate', filter: FILTER_SANITIZE_SPECIAL_CHARS);

    $bookReservation->setUserId($userId);
    $bookReservation->setLocationId($locationId);
    $bookReservation->setPickUpDate($pickUpDate);

    echo $bookReservation->create();

    exit;
}
